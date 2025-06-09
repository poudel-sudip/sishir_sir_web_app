<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as Category;
use App\Models\HealthDay;

class HealthDayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $year = date('Y');
        if ($request->has('year') && is_numeric($request->year)) {
            $year = (int)$request->year;
        }

        $healthYears = HealthDay::selectRaw('YEAR(date) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $healthDays = HealthDay::whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get()
            ->values();

        array_push($healthYears, date('Y'));
        sort($healthYears);
        $healthYears = array_values(array_unique($healthYears));

        $data['healthYears'] = $healthYears;
        $data['year'] = $year;
        $data['healthDays'] = $healthDays;

        // dd($data); 
        return view('admin.health_days.index', $data);
    }

    public function create(Request $request)
    {
        $year = date('Y');
        if ($request->has('year') && is_numeric($request->year)) {
            $year = (int)$request->year;
        }

        // $categories = Category::where('type', 'health-days')->get();
        $canImport = HealthDay::whereYear('date', $year)->count() ? false : true;
        $data['defaultDate'] = $year.'-'.date('m-d');
        $data['canImport'] = $canImport;
        // $data['categories'] = $categories;
        // dd($data);

        return view('admin.health_days.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'author' => 'nullable|string',
            // 'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image',
        ]);

        $image = null;
        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $pdf = null;
        if($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $healthDay = HealthDay::create([
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'pdf_file' => $pdf,
            'author' => $request->author,
            // 'category_id' => $request->category_id,
            'image' => $image,
        ]);
        

        return redirect('/admin/health-days?year='.date('Y',strtotime($request->date)))->with('success', 'Health Day created successfully.');
    }

    public function show(HealthDay $healthDay)
    {
        // Show details of a specific health day
        return view('admin.health_days.show', compact('healthDay'));
    }

    public function edit(HealthDay $healthDay)
    {
        // Show details of a specific health day
        return view('admin.health_days.edit', compact('healthDay'));
    }

    public function update(Request $request, HealthDay $healthDay)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'author' => 'nullable|string',
            // 'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image',
        ]);

        $image = $healthDay->image;
        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $pdf = $healthDay->pdf_file;
        if($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $healthDay->update([
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'pdf_file' => $pdf,
            'author' => $request->author,
            // 'category_id' => $request->category_id,
            'image' => $image,
        ]);

        return redirect('/admin/health-days?year='.date('Y',strtotime($request->date)))->with('success', 'Health Day updated successfully.');
    }

    public function destroy(Request $request, HealthDay $healthDay)
    {
        $healthDay->delete();

        return redirect('/admin/health-days?year='.date('Y',strtotime($healthDay->date)))->with('success', 'Health Day deleted successfully.');
    }

    public function import(Request $request)
    {
        $year = null;
        if ($request->has('year') && is_numeric($request->year)) {
            $year = (int)$request->year;
        }

        if(!$year) {
            abort(403,'Year is required for data import.');
        }

        $canImport = HealthDay::whereYear('date', $year)->count() ? false : true;
        if(!$canImport) {
            abort(403, 'Health Days for the year '.$year.' already exist. Import not allowed.');
        }

        $importYear = $year - 1;

        $healthDays = HealthDay::whereYear('date', $importYear)
            ->orderBy('date', 'asc')
            ->get()
            ->map(function($d) use ($year) {
                $d->date = date('Y-m-d', strtotime($d->date.' +1 year'));
                unset($d->id); 
                unset($d->created_at);
                unset($d->updated_at);
                return $d;
            })
            ->values()
            ->toArray();

        foreach($healthDays as $day) {
            HealthDay::create($day);
        }

        return redirect('/admin/health-days?year='.$year)->with('success', 'Health Days imported successfully.');
    }
       
}
