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

    public function indexCategory()
    {
        $categories = Category::where('type','=','health-day-category')->get();
        // dd($categories);
        return view('admin.health_days.categories',compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['category'=> 'string|required|min:2']);
        Category::create([
            'name' => $request->category,
            'type' => 'health-day-category',
            'status' => 'active',
        ]);

        return redirect('/admin/health-days/categories');
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'numeric|required|min:1',
            'category_name' => 'string|required',
        ]);
        Category::where('type','=','health-day-category')
        ->find($request->category_id)
        ->update(['name'=>$request->category_name]);

        return redirect('/admin/health-days/categories');
    }

    public function destroyCategory($category)
    {
        $category = Category::where('type','=','health-day-category')->find($category);
        if($category)
        {
            $category->delete();
        }
        
        return redirect('/admin/health-days/categories');
    }

    public function indexDay(Request $request)
    {        
        $healthDays = HealthDay::orderBy('sorting_date','asc')->get()->values();
        $data['healthDays'] = $healthDays;

        // dd($data); 
        return view('admin.health_days.index', $data);
    }

    public function createDay(Request $request)
    {        
        $data['categories'] = Category::where('type', 'health-day-category')->get();
        $data['sorting_month'] = (object)[
            "01" => 'January',
            "02" => 'February',
            "03" => 'March',
            "04" => 'April',
            "05" => 'May',
            "06" => 'June',
            "07" => 'July',
            "08" => 'August',
            "09" => 'September',
            "10" => 'October',
            "11" => 'November',
            "12" => 'December',
            "13" => 'Baisakh',
            "14" => 'Jestha',
            "15" => 'Ashadh',
            "16" => 'Shrawan',
            "17" => 'Bhadra',
            "18" => 'Ashwin',
            "19" => 'Kartik',
            "20" => 'Mangsir',
            "21" => 'Poush',
            "22" => 'Magh',
            "23" => 'Falgun',
            "24" => 'Chaitra',
        ];
        // dd($data);
        return view('admin.health_days.create', $data);
    }

    public function storeDay(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'required|string',
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string',
            'author_image' => 'nullable|image',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image',
            'sorting_month' => 'required|numeric|gte:1|lte:24',
            'sorting_date' => 'required|numeric|gte:1|lte:32',  
        ]);

        $thumbnail_image = null;
        if($request->hasFile('thumbnail_image')) {
            $thumbnail_image = $request->file('thumbnail_image')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $author_image = null;
        if($request->hasFile('author_image')) {
            $author_image = $request->file('author_image')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $pdf = null;
        if($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $sortdate = ($request->sorting_month ?? '00').':'.($request->sorting_date ?? '00');

        $healthDay = HealthDay::create([
            'category_id' => $request->category_id,
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'pdf_file' => $pdf,
            'author_name' => $request->author_name ?? auth()->user()->name ?? null,
            'author_image' => $author_image ?? auth()->user()->photo ?? null,
            'thumbnail_image' => $thumbnail_image,
            'sorting_date' => $sortdate,
        ]);
        

        return redirect('/admin/health-days')->with('success', 'Health Day created successfully.');
    }

    public function showDay(HealthDay $healthDay)
    {
        // Show details of a specific health day
        return view('admin.health_days.show', compact('healthDay'));
    }

    public function editDay(HealthDay $healthDay)
    {
        $data['healthDay'] = $healthDay;
        $data['categories'] = Category::where('type', 'health-day-category')->get();
        $data['sorting_month'] = (object)[
            "01" => 'January',
            "02" => 'February',
            "03" => 'March',
            "04" => 'April',
            "05" => 'May',
            "06" => 'June',
            "07" => 'July',
            "08" => 'August',
            "09" => 'September',
            "10" => 'October',
            "11" => 'November',
            "12" => 'December',
            "13" => 'Baisakh',
            "14" => 'Jestha',
            "15" => 'Ashadh',
            "16" => 'Shrawan',
            "17" => 'Bhadra',
            "18" => 'Ashwin',
            "19" => 'Kartik',
            "20" => 'Mangsir',
            "21" => 'Poush',
            "22" => 'Magh',
            "23" => 'Falgun',
            "24" => 'Chaitra',
        ];

        return view('admin.health_days.edit', $data);
    }

    public function updateDay(Request $request, HealthDay $healthDay)
    {
        // dd($request->all());

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'required|string',
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string',
            'author_image' => 'nullable|image',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image',
            'sorting_month' => 'required|numeric|gte:1|lte:24',
            'sorting_date' => 'required|numeric|gte:1|lte:32', 
        ]);

        $thumbnail_image = $healthDay->thumbnail_image;
        if($request->hasFile('thumbnail_image')) {
            $thumbnail_image = $request->file('thumbnail_image')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $author_image = $healthDay->author_image;
        if($request->hasFile('author_image')) {
            $author_image = $request->file('author_image')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $pdf =  $healthDay->pdf_file;
        if($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file')->store('uploads/health_days/'.date('Y',strtotime($request->date)), 'public');
        }

        $sortdate = ($request->sorting_month ?? '00').':'.($request->sorting_date ?? '00');

        $healthDay->update([           
            'category_id' => $request->category_id,
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'pdf_file' => $pdf,
            'author_name' => $request->author_name ?? auth()->user()->name ?? null,
            'author_image' => $author_image ?? auth()->user()->photo ?? null,
            'thumbnail_image' => $thumbnail_image,
            'sorting_date' => $sortdate,
        ]);

        return redirect('/admin/health-days')->with('success', 'Health Day updated successfully.');
    }

    public function destroyDay(Request $request, HealthDay $healthDay)
    {
        $healthDay->slogans()->delete();
        $healthDay->delete();

        return redirect('/admin/health-days')->with('success', 'Health Day deleted successfully.');
    }

    public function indexDaySlogan(HealthDay $healthDay)
    {
        $data['healthDay'] = $healthDay;
        $data['slogans'] = $healthDay->slogans()
        ->where('type','=','health-day-slogan')
        ->orderBy('name','desc')
        ->get()
        ->values();
        // dd($categories);
        return view('admin.health_days.slogans',$data);
    }

    public function storeDaySlogan(HealthDay $healthDay, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'year'=> 'numeric|required',
            'slogan' => 'string|required',
        ]);

        $healthDay->slogans()->create([
            'type' => 'health-day-slogan',
            'status' => 'active',
            'parent_id' => $healthDay->id,
            'name' => $request->year,
            'description' => $request->slogan,
        ]);
        
        return redirect('/admin/health-days/'.$healthDay->id.'/slogans');
    }

    public function updateDaySlogan(HealthDay $healthDay, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'slogan_id' => 'numeric|required|min:1',
            'slogan_year' => 'numeric|required',
            'slogan_title' => 'string|required',
        ]);

        $slogan = $healthDay->slogans()->where('type','=','health-day-slogan')->find($request->slogan_id);

        if($slogan)
        {
            $slogan->update([
                'name' => $request->slogan_year,
                'description' => $request->slogan_title,
            ]);
        }
        
        return redirect('/admin/health-days/'.$healthDay->id.'/slogans');
    }

    public function destroyDaySlogan(HealthDay $healthDay, $slogan, Request $request)
    {       
        $slogan = $healthDay->slogans()->where('type','=','health-day-slogan')->find($slogan);

        if($slogan)
        {
            $slogan->delete();
        }
        
        return redirect('/admin/health-days/'.$healthDay->id.'/slogans');
    }

}
