<?php

namespace App\Exports\Followup;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\Batch;
use App\Models\Followup;

class AllFollowupExport implements FromCollection, WithHeadings
{

    public $batch;
    public function __construct($batch)
    {
        $this->batch=$batch;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $batch=$this->batch;
        $users=User::where('role','=','Student')->get()
            ->map(function ($user,$i=0) use($batch) {
                $followup= $user->followup()
                    ->where('batch_id','=',$batch->id)
                    ->first()->remarks ?? '';
                $courses=$user->bookings->map(function ($book) {
                    return $book->batch->course->name ?? '';
                })->toArray();

                $courses=implode(", ",array_unique($courses));
                $i++;
                return (object)[
                    'sn'=>$i,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'contact'=>$user->contact,
                    'district'=>$user->district,
                    'interests'=>$user->interests,
                    'courses'=>$courses,
                    'remarks'=>$followup,
                ];
        });
        $i=0;
        return $users;
    }

    public function headings(): array
    {
        return ["SN", "Name", "Email","Contact","District","Interested Courses","Prev. Booked Courses","Remarks"];
    }
}
