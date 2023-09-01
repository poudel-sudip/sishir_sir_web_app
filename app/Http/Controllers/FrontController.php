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
use App\Models\Menu\MenuItemCategory;
use App\Models\Menu\MenuItem;
use App\Models\Menu\MenuSubItem;
use App\Models\Advertisement;
use App\Helpers\Helper;
use App\Models\Library\LibraryMaterial;
use App\Models\Library\LibraryCategory;
use App\Models\Forms\DynamicForm;

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
        $data['premiumExams'] = ExamHallCategories::where('status','Active')->orderByDesc('id')->take(4)->get();
        $data['exams'] = OpenExam::where('result_status','=','Unpublished')->orderByDesc('id')->take(4)->get();
        $data['last_blog'] = Blog::where('status','=','Published')->orderByDesc('id')->first();
        $data['blogs'] = Blog::where('status','=','Published')->orderByDesc('id')->take(5)->get();
        $data['books'] = Book::where('status','=','Active')->orderBy('order')->take(12)->get();
        $data['testimonials'] = Testimonial::where('status','=','Active')->orderByDesc('id')->take(15)->get();
        $data['ads'] = Advertisement::all();
        // $data['homepopup'] = HomePopup::where('status','=','Active')->first();
        // $data['updates'] = MenuItem::where('status','=','Active')->orderByDesc('id')->take(10)->get(['id','category_id','name','slug']);
        $data['libraries'] = LibraryCategory::where('parent_id','=',null)->where('status','=','Active')->orderBy('name')->take(8)->get();

        $data['dynamic_forms'] = DynamicForm::where('banner','!=','')->where('status','=','Active')->orderByDesc('id')->take(5)->get();
        
        $data['videos'] = FreeVideo::orderByDesc('id')->take(9)->get();
        $data['updates'] = [];

        $menu_sub_items = MenuSubItem::where('status','=','Active')
        ->orderByDesc('id')
        ->take(10)
        ->get(['id','item_id','name','slug','created_at'])
        ->map(function($update)
        {
            $link = "#";
            if($update->item)
            {
                if($update->item->category)
                {
                    if($update->item->category->subGroup)
                    {
                        if($update->item->category->subGroup->group)
                        {
                            $link = '/'.$update->item->category->subGroup->group->slug.'/'.$update->item->category->subGroup->slug.'/'.$update->item->category->slug.'/'.$update->item->slug.'/'.$update->slug;
                        }
                    }
                }
            }
            
            return (object)[
                'title' => $update->name,
                'created_at' => $update->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_items = MenuItem::where('status','=','Active')
        ->orderByDesc('id')
        ->take(10)
        ->get(['id','category_id','name','slug','created_at'])
        ->map(function($update)
        {
            $link = "#";
            if($update->category)
            {
                if($update->category->subGroup)
                {
                    if($update->category->subGroup->group)
                    {
                        $link = '/'.$update->category->subGroup->group->slug.'/'.$update->category->subGroup->slug.'/'.$update->category->slug.'/'.$update->slug;
                    }
                }
            }
            return (object)[
                'title' => $update->name,
                'created_at' => $update->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_categories = MenuItemCategory::where([['status','=','Active'],['type','!=','heading']])
        ->orderByDesc('id')
        ->take(10)
        ->get(['id','subgroup_id','name','slug','created_at'])
        ->map(function($cat)
        {
            $link = "#";
            if($cat->subGroup)
            {
                if($cat->subGroup->group)
                {
                    $link = '/'.$cat->subGroup->group->slug.'/'.$cat->subGroup->slug.'/'.$cat->slug;
                }
            }
            return (object)[
                'title' => $cat->name,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_submenus = MenuSubGroup::where([['status','=','Active'],['type','!=','heading']])
        ->orderByDesc('id')
        ->take(10)
        ->get(['id','group_id','name','slug','created_at'])
        ->map(function($cat)
        {
            $link = "#";
            
            if($cat->group)
            {
                $link = '/'.$cat->group->slug.'/'.$cat->slug;
            }
            
            return (object)[
                'title' => $cat->name,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $library_materials = LibraryMaterial::where('status','=','Active')
        ->orderByDesc('id')
        ->take(10)
        ->get(['id','name','slug','created_at','category_id'])
        ->map(function($cat)
        {
            $link = "#";
            
            if($cat->category)
            {
                $link = '/library/'.$cat->category->slug.'/'.$cat->slug;
            }
            
            return (object)[
                'title' => $cat->name,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $data['updates'] = array_merge($data['updates'], $menu_submenus);
        $data['updates'] = array_merge($data['updates'], $menu_categories);
        $data['updates'] = array_merge($data['updates'], $menu_items);
        $data['updates'] = array_merge($data['updates'], $menu_sub_items);
        $data['updates'] = array_merge($data['updates'], $library_materials);

        usort($data['updates'], function($a, $b) {return strcmp($b->created_at,$a->created_at);});
        $data['updates'] = array_slice($data['updates'], 0, 10, true);
        // dd($data);
        return view('front.index',$data);
    }

    public function getMenuCategories($groupslug, $menuslug)
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

        // dd($data);
        return view('front.menucategories',$data);
    }

    public function getMenuItems($groupslug, $menuslug, $catslug)
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

        $menuCategory = MenuItemCategory::where([['slug',$catslug],['status','Active']])->first();
        if(!$menuCategory)
        {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $data['menuItems'] = $menuCategory->items()->where('status','=','Active')->orderByDesc('id')->get();

        // dd($data);
        return view('front.menulist',$data);
    }

    public function getMenuItemDetail($groupslug, $menuslug, $catslug, $itemslug)
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
        
        $menuCategory = MenuItemCategory::where([['slug',$catslug],['status','Active']])->first();
        if(!$menuCategory)
        {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $menuItem = MenuItem::where([['slug',$itemslug],['status','Active']])->first();
        if(!$menuItem)
        {
            abort(404);
        }
        $data['menuItem'] = $menuItem;

        // dd($data);
        return view('front.menuitemdetail',$data);
    }

    public function getMenuSubItemDetail($groupslug, $menuslug, $catslug, $itemslug, $subitemslug)
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
        
        $menuCategory = MenuItemCategory::where([['slug',$catslug],['status','Active']])->first();
        if(!$menuCategory)
        {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $menuItem = MenuItem::where([['slug',$itemslug],['status','Active']])->first();
        if(!$menuItem)
        {
            abort(404);
        }
        $data['menuItem'] = $menuItem;

        $menuSubItem = MenuSubItem::where([['slug',$subitemslug],['status','Active']])->first();
        if(!$menuSubItem)
        {
            abort(404);
        }
        $data['menuSubItem'] = $menuSubItem;

        // dd($data);
        return view('front.menusubitemdetail',$data);
    }

    public function getLibrary()
    {
        $library_categories = LibraryCategory::where('parent_id','=',null)->where('status','=','Active')->orderBy('name')->get();
        return view('front.libraries',compact('library_categories'));
    }

    public function getLibraryContents($catslug)
    {
        $library_category = LibraryCategory::where([['slug',$catslug],['status','Active']])->first();
        if(!$library_category)
        {
            abort(404);
        }
        $directories = $library_category->childs;
        $library_materials = $library_category->materials()->where('status','=','Active')->orderByDesc('id')->get(['id','name','slug','created_at','thumbnail']);
        // dd($directories);
        return view('front.librarycontents',compact('library_category','directories','library_materials'));
    }

    public function getLibraryContentDetail($catslug, $matslug)
    {
        $library_category = LibraryCategory::where([['slug',$catslug],['status','Active']])->first();
        if(!$library_category)
        {
            abort(404);
        }

        $material = LibraryMaterial::where([['slug',$matslug],['status','Active']])->first();
        if(!$material)
        {
            abort(404);
        }
        return view('front.librarycontentdetail',compact('library_category','material'));
    }

    public function popularcourse()
    {
        $data=Course::all()->where('isPopular','=','Yes')->where('status','=','Active')->sortBy('order');
        return view('front.popularcourse',compact('data'));
    }
    public function runningbatch()
    {
        $data=Batch::all()->where('status','=','Running');
        return view('front.runningbatches',compact('data'));
    }
    public function about()
    {
        return view('front.about');
    }

    public function books()
    {
        $data['books'] = Book::where('status','=','Active')->orderByDesc('id')->take(15)->get();
        $data['categories'] = Categories::where(['status'=>'Active','type'=>'book_category'])->whereHas('cat_books')->get();
        // dd($data);
        return view('front.books.index',$data);
    }

    public function publisherBookCategories($slug)
    {
        $publisher = Categories::where('slug',$slug)->where('type','=','book_publisher')->first();
        if(!$publisher)
        {
            abort(404,'Book Publisher Not Found');
        }

        $data['publisher'] = $publisher;
        $data['categories'] = $publisher->pub_categories()->where('status','=','Active')->get();
        
        return view('front.books.publisher_category',$data);
    }

    public function publisherAllBooks($slug)
    {
        $publisher = Categories::where('slug',$slug)->where('type','=','book_publisher')->first();
        if(!$publisher)
        {
            abort(404,'Book Publisher Not Found');
        }

        $data['publisher'] = $publisher;
        $data['category'] = null;
        $data['categories'] = $publisher->pub_categories()->where('status','=','Active')->get();
        $data['books'] = $publisher->pub_books()->where('status','=','Active')->orderByDesc('id')->get();

        return view('front.books.publisher_category_books',$data);
    }

    public function publisherCategoryBooks($pslug,$cslug)
    {
        $publisher = Categories::where('slug',$pslug)->where('type','=','book_publisher')->first();
        if(!$publisher)
        {
            abort(404,'Book Publisher Not Found');
        }

        $category = Categories::where('slug',$cslug)->where('type','=','book_category')->first();
        if(!$category)
        {
            abort(404,'Book Category Not Found');
        }

        $data['publisher'] = $publisher;
        $data['category'] = $category;
        $data['categories'] = $publisher->pub_categories()->where('status','=','Active')->get();
        $data['books'] = $category->cat_books()->where('status','=','Active')->orderByDesc('id')->get();

        return view('front.books.publisher_category_books',$data);
    }

    // public function categoryBooks($slug)
    // {
    //     $category = Categories::where('slug',$slug)->whereIn('type',['book','book_publisher'])->first();
    //     if(!$category)
    //     {
    //         abort(404,'Book Category Not Found');
    //     }
    //     $data['categories'] = Categories::where(['status'=>'Active','type'=>'book_publisher'])->whereHas('pub_books')->get();
    //     $data['category'] = $category;
    //     if($category->type == 'book')
    //     {
    //         $data['books'] = $category->books()->where('status','=','Active')->orderBy('edition')->get();
    //     }
    //     elseif($category->type == 'book_publisher')
    //     {
    //         $data['books'] = $category->pub_books()->where('status','=','Active')->orderBy('edition')->get();
    //     }
    //     else{
    //         $data['books'] = [];
    //     }

    //     return view('front.books.categorybooks',$data);
    // }

    public function singleBook($slug)
    {
        $book = Book::where('slug',$slug)->where('status','=','Active')->first();
        if(!$book)
        {
            abort(404,'Book Not Found');
        }
        $book_reviews = $book->reviews()->orderByDesc('id')->take(30)->get();

        return view('front.books.single_book',compact('book','book_reviews'));
    }

    public function addBookReview($slug, Request $request)
    {
        $book = Book::where('slug',$slug)->first();
        if(!$book)
        {
            abort(404);
        }
        
        $request->validate([
            'rating' => 'required|numeric|lt:6|gt:0',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'contents' => 'required|string',
        ]);

        $book->reviews()->create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => intval($request->rating),
            'message' => $request->contents,
        ]);

        return redirect('/books/'.$book->slug);
    }

    public function contact()
    {
        return view('front.contact');
    }
    public function enquiry()
    {
        $proviences = Provience::all()->sortBy('name');
        return view('front.admissionForm',compact('proviences'));
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
        return view('front.categoryCourses',compact('categories','category'));
    }
    public function categorylist()
    {
        $course=Course::all()->where('status','Active')->sortBy('order');
        $categories=Categories::all()->where('status','=','Active')->sortBy('order');
        return view('front.allCategory',compact('categories','course'));
    }
    public function coursedetails($slug)
    {
        $course=Course::where('slug',$slug)->first();
        if(!$course)
        {
            abort(404);
        }

        return view('front.coursedetails',compact('course'));
    }

    public function batchdetails($courseslug,$batchslug)
    {
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

        return view('front.batchdetails',compact('batch'));
    }

    public function tutorDetails($slug)
    {
        $tutor=Tutor::where('slug',$slug)->first();
        if(!$tutor)
        {
            abort(404);
        }
        $tutorposts=$tutor->posts()->where('status','=','Published')->get(); //you can use this when you need to display particular tutor posts 
        return view('front.tutordetails',compact('tutor','tutorposts'));
    }

    // public function freevideos()
    // {
    //     $videos=FreeVideo::all()->sortByDesc('id');
    //     return view('front.freeVideos',compact('videos'));
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $query = trim($query);
        if(!$query)
        {
            return back();
        }
        $data = [];
        $data['query'] = $query;

        $data['menu_posts'] = [];

        $menu_sub_items = MenuSubItem::where('status','=','Active')
        ->where(function($req) use($query) {
            $req->where('name','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get()
        ->map(function($update)
        {
            $link = "#";
            if($update->item)
            {
                if($update->item->category)
                {
                    if($update->item->category->subGroup)
                    {
                        if($update->item->category->subGroup->group)
                        {
                            $link = '/'.$update->item->category->subGroup->group->slug.'/'.$update->item->category->subGroup->slug.'/'.$update->item->category->slug.'/'.$update->item->slug.'/'.$update->slug;
                        }
                    }
                }
            }
            
            return [
                'id' => $update->id,
                'title' => $update->name,
                'slug' => $update->slug,
                'created_at' => $update->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_items = MenuItem::where('status','=','Active')
        ->where(function($req) use($query) {
            $req->where('name','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get()
        ->map(function($update)
        {
            $link = "#";
            if($update->category)
            {
                if($update->category->subGroup)
                {
                    if($update->category->subGroup->group)
                    {
                        $link = '/'.$update->category->subGroup->group->slug.'/'.$update->category->subGroup->slug.'/'.$update->category->slug.'/'.$update->slug;
                    }
                }
            }
            return [
                'id' => $update->id,
                'title' => $update->name,
                'slug' => $update->slug,
                'created_at' => $update->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_categories = MenuItemCategory::where('status','=','Active')
        ->where('type','!=','heading')
        ->where(function($req) use($query) {
            $req->where('name','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get()
        ->map(function($cat)
        {
            $link = "#";
            if($cat->subGroup)
            {
                if($cat->subGroup->group)
                {
                    $link = '/'.$cat->subGroup->group->slug.'/'.$cat->subGroup->slug.'/'.$cat->slug;
                }
            }
            return [
                'id' => $cat->id,
                'title' => $cat->name,
                'slug' => $cat->slug,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        $menu_submenus = MenuSubGroup::where('status','=','Active')
        ->where('type','!=','heading')
        ->where(function($req) use($query) {
            $req->where('name','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get()
        ->map(function($cat)
        {
            $link = "#";
            
            if($cat->group)
            {
                $link = '/'.$cat->group->slug.'/'.$cat->slug;
            }
            
            return [
                'id' => $cat->id,
                'title' => $cat->name,
                'slug' => $cat->slug,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_submenus);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_categories);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_items);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_sub_items);
        usort($data['menu_posts'], function($a, $b) {return strcmp($b['created_at'],$a['created_at']);});

        $data['blogs'] = Blog::where('status','=','Published')
        ->where(function($req) use($query) {
            $req->where('title','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get(['id','title','slug','created_at'])
        ->map(function($b){
            $b['link'] = '/blogs/'.$b->slug;
            return $b;
        })
        ->toArray();

        $data['books'] = Book::where('status','=','Active')
        ->where(function($req) use($query) {
            $req->where('title','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get(['id','title','slug','created_at'])
        ->map(function($b){
            $b['link'] = '/books/'.$b->slug;
            return $b;
        })
        ->toArray();

        $data['premium_exams'] = ExamHallCategories::where('status','=','Active')
        ->where(function($req) use($query) {
            $req->where('title','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get(['id','title','slug','created_at'])
        ->map(function($e){
            $e['link'] = '/exam-hall/premium/'.$e->slug;
            return $e;
        })
        ->toArray();

        $data['library_materials'] = LibraryMaterial::where('status','=','Active')
        ->where(function($req) use($query) {
            $req->where('name','Like','%'.$query.'%')
            ->orWhere('search_tags','Like','%'.$query.'%');
        })
        ->get(['id','name','slug','created_at','category_id'])
        ->map(function($cat)
        {
            $link = "#";
            
            if($cat->category)
            {
                $link = '/library/'.$cat->category->slug.'/'.$cat->slug;
            }
            
            return [
                'id' => $cat->id,
                'title' => $cat->name,
                'slug' => $cat->slug,
                'created_at' => $cat->created_at,
                'link' => $link,
            ];
        })
        ->toArray();

        // dd($data);
        
        return view('front.search',$data);
    }

    public function getTestimonials()
    {
        $data['testimonials'] = Testimonial::where('status','=','Active')->orderByDesc('id')->get();
        return view('front.testimonials',$data);
    }

    public function addTestimonials(Request $request)
    {
        $data = request()->validate([
            'name'=>'required | string',
            'testimonial_as'=>'required | string',
            'email'=>'nullable|email',
            'message'=>'required|string',
            'photo'=>'image|nullable',
        ]);
        $imgpath = ' ';
        if(isset($data['photo']))
        {
            $imgpath=request('photo')->store('uploads','public');
        }
        Testimonial::create([
           'name'=>$data['name'],
           'role'=>$data['testimonial_as'] ?? 'Visitor',
           'email'=>$data['email'],
           'message'=>$data['message'],
           'image'=>$imgpath,
           'status'=>'Inactive',
        ]);
        return redirect('/testimonials');
    }

    public function playFreeVideo(FreeVideo $video)
    {
        return view('front.play_free_video',compact('video'));
    }
}
