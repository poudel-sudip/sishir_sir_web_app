<?php

namespace App\Http\Controllers\admin\Report;

use App\Exports\CourseBatchesExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Reports\ReportUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Provience\Provience;
use App\Models\Provience\DistrictCity;

class UserReportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.reports.user.index',[
            'courses'=>Course::all(),
            'cities' => DistrictCity::all()->sortBy('name'),
            'proviences' => Provience::all()->sortBy('name'),
        ]);
    }

    public function userReport()
    {
        $reports=ReportUser::all()->sortBy('created_at');
        return view('admin.reports.user.users',compact('reports'));
    }

    public function exportUsers(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'All Users.xlsx');
    }

    public function filterUsersDate(Request $request)
    {
        $request->validate([
            'createdStart'=>'date',
            'createdEnd'=>'date',
        ]);
        $date=(object)[
            'start'=>Carbon::createFromFormat('Y-m-d', $request->createdStart)->startOfDay(),
            'end'=>Carbon::createFromFormat('Y-m-d', $request->createdEnd)->endOfDay(),
        ];
        $users=User::all()->whereBetween('created_at',[$date->start,$date->end]);
        return view('admin.reports.user.filters',[
            'users'=>$users,
            'value'=>$date,
            'filter'=>'date',
        ]);
    }

    public function filterUsersDistrict(Request $request)
    {
        $request->validate(['district'=>'required | string']);
        $users=User::all()->where('district_city','=',$request->district);
        return view('admin.reports.user.filters',[
            'users'=>$users,
            'value'=>$request->district,
            'filter'=>'district_city',
        ]);
    }

    public function filterUsersProvience(Request $request)
    {
        $request->validate(['provience'=>'required | string']);
        $users=User::all()->where('provience','=',$request->provience);
        return view('admin.reports.user.filters',[
            'users'=>$users,
            'value'=>$request->provience,
            'filter'=>'provience',
        ]);
    }

    public function filterUsersCourse(Request $request)
    {
        $request->validate(['course'=>'required | string']);
        $c=$request->course;
        $users=User::where('interests','Like','%'.$c.'%')->get();
        return view('admin.reports.user.filters',[
            'users'=>$users,
            'value'=>$request->course,
            'filter'=>'interests',
        ]);
    }

    public function filteredUsersDownload($key,$value)
    {
        $fileName = 'Filtered-Users.csv';
        $users=User::where($key,'Like','%'.$value.'%')->get();
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('SN', 'Name', 'Email', 'Contact', 'Provience','District/City','Interested Course','Role','Status','Created On');

        $callback = function() use($users, $columns){
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $i=1;
            foreach ($users as $user)
            {
                $row['SN']  = $i;
                $row['Name']  = $user->name;
                $row['Email']  = $user->email;
                $row['Contact']  = $user->contact;
                $row['Provience']  = $user->provience;
                $row['District/City']  = $user->district_city;
                $row['Interested Course']  = $user->interests;
                $row['Role']  = $user->role;
                $row['Status']  = $user->status;
                $row['Created On']  = date('Y-m-d',strtotime($user->created_at));

                fputcsv($file, array($row['SN'], $row['Name'], $row['Email'], $row['Contact'], $row['Provience'], $row['District/City'], $row['Interested Course'], $row['Role'], $row['Status'], $row['Created On']));

                $i++;
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

}
