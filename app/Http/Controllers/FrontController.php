<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Categories;
use App\Models\Course;
use App\Models\FreeVideo;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Tutor;
use App\Models\TutorReview;
use App\Models\StudyMaterial;
use App\Models\Syllabus;
use App\Models\HomePopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Provience\Provience;
use App\Models\Orientation;
use App\Models\OpenExams\OpenExam;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\Blog;
use App\Models\Books\Book;
use App\Models\Menu\MenuGroup;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItem;

class FrontController extends Controller
{
    public function index()
    {
        // $categories=Categories::all()->where('status','=','Active')->sortBy('order');
        // $popularCourses=Course::where('isPopular','=','Yes')->where('status','=','Active')->orderBy('order')->take(10)->get();
        // $runningBatches=Batch::all()->where('status','=','Running')->take(8)->sortByDesc('created_at');
        // $orientations = Orientation::whereDate('date','>=',date("Y-m-d"))->where('status','=','Active')->get();

        $data = [];
        $data['sliders'] = Slider::all()->sortBy('order');
        $data['premiumExams'] = ExamHallCategories::where('status','Active')->get();
        $data['exams'] = OpenExam::where('result_status','=','Unpublished')->get()->sortByDesc('id');
        $data['last_blog'] = Blog::where('status','=','Published')->orderByDesc('created_at')->first();
        $data['blogs'] = Blog::where('status','=','Published')->get()->sortByDesc('created_at');
        $data['books'] = Book::where('status','=','Active')->get()->sortBy('order');
        $data['testimonials'] = Testimonial::all()->sortByDesc('created_at')->take(10);
        // $data['homepopup'] = HomePopup::where('status','=','Active')->first();

        return view('front.index',$data);
    }

    public function getMenuItemList($groupslug, $menuslug)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['slug',$groupslug],['status','Active']])->first();
        if(!$mainMenu)
        {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['slug',$menuslug],['status','Active']])->first();
        if(!$subMenu)
        {
            abort(404);
        }
        $data['subMenu'] = $subMenu;

        $data['menuItems'] = $subMenu->items()->where('status','Active')->orderBy('order')->get();
        // dd($data);
        return view('front.menulist',$data);
    }

    public function getMenuItemDetail($groupslug, $menuslug, $itemslug)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['slug',$groupslug],['status','Active']])->first();
        if(!$mainMenu)
        {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['slug',$menuslug],['status','Active']])->first();
        if(!$subMenu)
        {
            abort(404);
        }
        $data['subMenu'] = $subMenu;
        
        $menuItem = MenuItem::where([['slug',$itemslug],['status','Active']])->first();
        if(!$menuItem)
        {
            abort(404);
        }
        $data['menuItem'] = $menuItem;
        // dd($data);
        return view('front.menuitemdetail',$data);
    }

    public function popularcourse()
    {
        $headercategories = Categories::all()->where('status','=','Active');
        $data=Course::all()->where('isPopular','=','Yes')->where('status','=','Active')->sortBy('order');
        return view('front.popularcourse',compact('data','headercategories'));
    }
    public function runningbatch()
    {
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
        $data=Batch::all()->where('status','=','Running');
        return view('front.runningbatches',compact('data','headercategories'));
    }
    public function about()
    {
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
        return view('front.about',compact('headercategories'));
    }
    public function books()
    {
        $books=Book::all()->sortByDesc('id');
        return view('front.books',compact('books'));
    }
    public function contact()
    {
        return view('front.contact');
    }
    public function enquiry()
    {
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
        $proviences = Provience::all()->sortBy('name');
        return view('front.admissionForm',compact('proviences','headercategories'));
    }

    public function showCourseEnquiryForm($courseslug)
    {
        // dd($courseslug);
        $course = Course::where('slug',$courseslug)->first();
        if(!$course)
        {
            abort(404,'Course Not Found');
        }
        $proviences = Provience::all()->sortBy('name');
        return view('front.singleCourseEnquiryForm',compact('proviences','course'));
    }

    public function tutors()
    {
        $tutors=Tutor::where('status','=','Active')->get()->sortByDesc('id');
        return view('front.tutors',compact('tutors'));
    }
    public function syllabus()
    {
        $syllabus=Syllabus::all()->sortByDesc('id');
        return view('front.syllabus',compact('syllabus'));
    }
    public function materials()
    {
        $meterials=StudyMaterial::all()->sortByDesc('id');
        return view('front.materials',compact('meterials'));
    }
     
    public function courselist($slug)
    {
        $category=Categories::where('slug',$slug)->first();

        if(!$category)
        {
           abort(404);
        }
        $categories=Categories::all()->where('status','=','Active')->sortBy('order');
        $headercategories=$categories;
        return view('front.categoryCourses',compact('categories','category','headercategories'));
    }
    public function categorylist()
    {
        $course=Course::all()->where('status','Active')->sortBy('order');
        $categories=Categories::all()->where('status','=','Active')->sortBy('order');
        $headercategories=$categories;
        return view('front.allCategory',compact('categories','course','headercategories'));
    }
    public function coursedetails($slug)
    {
        $course=Course::where('slug',$slug)->first();
        if(!$course)
        {
            abort(404);
        }
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');

        return view('front.coursedetails',compact('headercategories','course'));
    }

    public function batchdetails($courseslug,$batchslug)
    {
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
        $course=Course::where('slug',$courseslug)->first();
        if(!$course)
        {
            abort(404);
        }
        $batch=Batch::where('course_id','=',$course->id)->where('slug',$batchslug)->first();
        if(!$batch)
        {
            abort(404);
        }

        return view('front.batchdetails',compact('headercategories','batch'));
    }

    public function tutorDetails($slug)
    {
        $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
        $tutor=Tutor::where('slug',$slug)->first();
        if(!$tutor)
        {
            abort(404);
        }
        $tutorposts=$tutor->posts()->where('status','=','Published')->get(); //you can use this when you need to display particular tutor posts 
        return view('front.tutordetails',compact('headercategories','tutor','tutorposts'));
    }

    // public function freevideos()
    // {
    //     $headercategories=Categories::all()->where('status','=','Active')->sortBy('order');
    //     $videos=FreeVideo::all()->sortByDesc('id');
    //     return view('front.freeVideos',compact('videos','headercategories'));
    // }
    public function notice()
    {
        return view('front.notice');
    }
    public function saveReview(Tutor $tutor,Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'rating' => ['required', 'numeric', 'lt:6'],
            'contents'=>['required','string'],
        ]);

        if($validator->fails()){
            return back()->withInput();
        }
        
        $tutor->reviews()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'rating'=>$request->rating,
            'review'=>$request->contents,
            'status'=>'Unpublished',
        ]);

        return redirect('/tutor/'.$tutor->slug);
    
    }

    public function privacy()
    {
        return view('front.privacy');
    }

    public function joinLiveClass(Request $request)
    {
        $request->validate([
            "std_class" => "string|required",
            "std_name" => "string|required",
            "std_contact" => "numeric|required",
            "std_email" => "email|nullable",
            "class_slug" => "string|required",
        ]);

        $class = Orientation::where('slug','=',$request->class_slug)->first();
        if(!$class)
        {
            return back()->withInput()->withErrors(['class_error' =>  'Live Class Not Found.']);
        }
        // dd($request->all(),$class->participants);
        $class->participants()->create([
            'class_id' => $class->id,
            'name' => $request->std_name,
            'email' => $request->email ?? '',
            'contact' => $request->std_contact,
        ]);
        // dd($class->join_link);
        return redirect($class->join_link);
    }

}
