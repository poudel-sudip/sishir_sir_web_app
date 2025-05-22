<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as QuestionImage;

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
use App\Models\PostViewCounter;
use App\Models\Books\QRBook;
use App\Models\Exams\DailyMCQQuestion;
use App\Models\DiscussionForum;
use App\Models\ImageGallery;
use App\Models\Books\PhysicalBookOrder;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookCategory as PDFBankCategory;
use App\Models\VaccancyPost;

class FrontController extends Controller
{
    public function index()
    {

        $data = [];
        // $data['premiumExams'] = ExamHallCategories::where('status','Active')->orderByDesc('id')->take(4)->get(['id','title','slug','image','created_at']);
        $data['highlights'] = Categories::where('type', '=', 'home_highlight')->where('status', '=', 'Active')->orderByDesc('id')->get(['id', 'type', 'name as title', 'description as link']);
        $data['exams'] = OpenExam::where('result_status', '=', 'Unpublished')->orderByDesc('id')->take(4)->get();
        $data['last_blog'] = Blog::where('status', '=', 'Published')->orderByDesc('id')->first();
        $data['blogs'] = Blog::where('status', '=', 'Published')->orderByDesc('id')->take(9)->get(['id', 'title', 'slug', 'image', 'author', 'created_at']);
        $data['books'] = Book::where('status', '=', 'Active')->orderByDesc('id')->take(9)->get(['id', 'title', 'slug', 'price', 'discount', 'thumbnail', 'published_year', 'edition','created_at']);
        // $data['testimonials'] = Testimonial::where('status', '=', 'Active')->orderByDesc('id')->take(9)->get();
        $data['ads'] = Advertisement::where('status', '=', 'Active')->get();
        $data['homepopup'] = HomePopup::where('status', '=', 'Active')->orderByDesc('id')->first();

        $data['dynamic_forms'] = DynamicForm::where('banner', '!=', '')->where('status', '=', 'Active')->orderByDesc('id')->take(5)->get();
        $data['videos'] = FreeVideo::orderByDesc('id')->take(9)->get();

        $data['vaccancy_tags'] = Categories::where('type', '=', 'vaccancy_tag')->orderBy('id')->get();

        $data['vaccancies'] = VaccancyPost::where('status', '=', 'Active')->orderByDesc('id')->take(7)->get(['id', 'title', 'slug'])->map(function ($v) {
            $v->link = url('/vaccancies/' . $v->id);
            return $v;
        });


        $today_question = DailyMCQQuestion::where('show_date', '=', date('Y-m-d'))->first();
        if ($today_question) {
            // $today_question->image = $this->generateQuestionImage($today_question);
            $today_question_date = (object)$today_question->only(['id', 'show_date', 'image']);
            $data['today_question_date'] = $today_question_date;
        }

        $data['today_question'] = $today_question;
        $data['img_gallery'] = ImageGallery::where('status', '=', 1)->orderByDesc('id')->take(9)->get();

        $data['pdf_bank_categories'] = PDFBankCategory::where('status', '=', 'Active')
            ->orderBy('order')
            ->whereHas('ebooks', function ($b) {
                $b->where('status', '=', 'Active');
            })
            // ->take(6)
            ->get()
            ->values();

        foreach ($data['pdf_bank_categories'] as $cat) {
            $cat->pdf_banks = $cat->ebooks()
                ->where('status', '=', 'Active')
                ->where(function ($q) {
                    $q->where('type', '=', 'single')
                        ->orWhere(function ($sq) {
                            $sq->whereHas('chapters', function ($ch) {
                                $ch->where('status', '=', 'Active');
                            });
                        });
                })
                ->select(['id', 'category_id', 'type', 'title', 'slug', 'author', 'price', 'discount', 'status', 'thumbnail'])
                ->withCount(['chapters as pdf_count' => function ($ch) {
                    $ch->where('status', '=', 'Active');
                }])
                ->orderByDesc('id')
                ->take(4)
                ->get();
        }

        $premium_exams = ExamHallCategories::where('status', 'Active')
            ->orderByDesc('id')
            ->take(4)
            ->get(['id', 'title', 'slug', 'image', 'created_at'])
            ->map(function ($b) {
                $b->mcq_count = $b->category_exams()->count();
                return $b;
            })
            ->values();

        $data['examhall_categories'] = Categories::where('status', '=', 'Active')
            ->where('type', '=', 'exam_hall')
            ->orderBy('order')
            ->whereHas('premium_exams', function ($b) {
                $b->where('status', '=', 'Active');
            })
            // ->take(10)
            ->get()
            ->values();

        foreach ($data['examhall_categories'] as $cat) {
            $cat->exam_sets = $cat->premium_exams()
                ->where('status', '=', 'Active')
                ->select(['id', 'group_id', 'title', 'slug', 'image', 'created_at'])
                ->withCount(['category_exams as mcq_count'])
                ->orderByDesc('id')
                ->take(4)
                ->get();
        }

        if (!$data['examhall_categories']->count()) {
            $data['examhall_categories'] = collect([
                (object)[
                    'id' => 'premium',
                    'name' => 'Premium',
                    'slug' => 'premium',
                    "order" => 1,
                    "exam_sets" => $premium_exams,
                ],
            ]);
        }

        $data['updates'] = [];

        $menu_sub_items = MenuSubItem::where('status', '=', 'Active')
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'item_id', 'name', 'slug', 'created_at'])
            ->map(function ($update) {
                $link = "#";
                if ($update->item) {
                    if ($update->item->category) {
                        if ($update->item->category->subGroup) {
                            if ($update->item->category->subGroup->group) {
                                $link = '/' . $update->item->category->subGroup->group->id . '/' . $update->item->category->subGroup->id . '/' . $update->item->category->id . '/' . $update->item->id . '/' . $update->id;
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

        $menu_items = MenuItem::where('status', '=', 'Active')
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'category_id', 'name', 'slug', 'created_at'])
            ->map(function ($update) {
                $link = "#";
                if ($update->category) {
                    if ($update->category->subGroup) {
                        if ($update->category->subGroup->group) {
                            $link = '/' . $update->category->subGroup->group->id . '/' . $update->category->subGroup->id . '/' . $update->category->id . '/' . $update->id;
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

        $menu_categories = MenuItemCategory::where([['status', '=', 'Active'], ['type', '!=', 'heading']])
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'subgroup_id', 'name', 'slug', 'created_at'])
            ->map(function ($cat) {
                $link = "#";
                if ($cat->subGroup) {
                    if ($cat->subGroup->group) {
                        $link = '/' . $cat->subGroup->group->id . '/' . $cat->subGroup->id . '/' . $cat->id;
                    }
                }
                return (object)[
                    'title' => $cat->name,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->toArray();

        $menu_submenus = MenuSubGroup::where([['status', '=', 'Active'], ['type', '!=', 'heading']])
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'group_id', 'name', 'slug', 'created_at'])
            ->map(function ($cat) {
                $link = "#";

                if ($cat->group) {
                    $link = '/' . $cat->group->id . '/' . $cat->id;
                }

                return (object)[
                    'title' => $cat->name,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->toArray();

        $library_materials = LibraryMaterial::where('status', '=', 'Active')
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'name', 'slug', 'created_at', 'category_id'])
            ->map(function ($cat) {
                $link = "#";

                if ($cat->category) {
                    $link = '/library/' . $cat->category->id . '/' . $cat->id;
                }

                return (object)[
                    'title' => $cat->name,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->toArray();

        $blog_updates = $data['blogs']->map(function ($b) {
            return (object)[
                'title' => $b->title,
                'created_at' => $b->created_at,
                'link' => '/blogs/' . $b->id,
            ];
        })->toArray();

        // $premium_exam_updates = $data['premiumExams']->map(function($b){
        //     return (object)[
        //         'title' => $b->title,
        //         'created_at' => $b->created_at,
        //         'link' => '/exam-hall/premium/'.$b->id,
        //     ];
        // })->toArray();

        $premium_exam_updates = $premium_exams
            ->map(function ($b) {
                return (object)[
                    'title' => $b->title,
                    'created_at' => $b->created_at,
                    'link' => '/exam-hall/premium/' . $b->id,
                ];
            })
            ->values()
            ->toArray();

        $free_exam_updates =  $data['exams']
            ->map(function ($b) {
                return (object)[
                    'title' => $b->name,
                    'created_at' => $b->created_at,
                    'link' => '/public-exams/' . $b->id,
                ];
            })
            ->values()
            ->toArray();

        $pdf_bank_updates = PDFBank::where('status', '=', 'Active')
            ->orderByDesc('id')
            ->take(6)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($b) {
                return (object)[
                    'title' => $b->title,
                    'created_at' => $b->created_at,
                    'link' => '/pdf-banks/bank/' . $b->id,
                ];
            })
            ->toArray();

        // $vaccancy_updates = VaccancyPost::where('status', '=', 'Active')
        //     ->orderByDesc('id')
        //     ->take(6)
        //     ->get(['id', 'title', 'slug', 'created_at'])
        //     ->map(function ($b) {
        //         return (object)[
        //             'title' => $b->title,
        //             'created_at' => $b->created_at,
        //             'link' => '/vaccancies/' . $b->id,
        //         ];
        //     })
        //     ->toArray();

        $book_updates = $data['books']
            ->map(function ($b) {
                return (object)[
                    'title' => $b->title,
                    'created_at' => $b->created_at,
                    'link' => '/books/' . $b->id,
                ];
            })
            ->toArray();


        $data['updates'] = array_merge($data['updates'], $pdf_bank_updates);
        $data['updates'] = array_merge($data['updates'], $premium_exam_updates);
        $data['updates'] = array_merge($data['updates'], $blog_updates);
        $data['updates'] = array_merge($data['updates'], $menu_submenus);
        $data['updates'] = array_merge($data['updates'], $menu_categories);
        $data['updates'] = array_merge($data['updates'], $menu_items);
        $data['updates'] = array_merge($data['updates'], $menu_sub_items);
        $data['updates'] = array_merge($data['updates'], $library_materials);
        $data['updates'] = array_merge($data['updates'], $free_exam_updates);
        $data['updates'] = array_merge($data['updates'], $book_updates);
        // $data['updates'] = array_merge($data['updates'], $vaccancy_updates);

        usort($data['updates'], function ($a, $b) {
            return strcmp($b->created_at, $a->created_at);
        });
        $data['updates'] = array_slice($data['updates'], 0, 7, true);


        $fetch_url = 'https://www.ashesh.com.np/panchang/widget.php?header_color=faf8ee&header_title=Today';
        $fetch_data = file_get_contents($fetch_url);
        preg_match('/<body[^>]*>(.*?)<\/body>/is', $fetch_data, $fetch_data_matches);
        $fetched_data_body = $fetch_data_matches[1] ?? '';

        $data['fetched_page'] = json_encode($fetched_data_body);

        // dd($data);
        return view('front.index', $data);
    }

    public function getMenuCategories($group, $menu)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['id', $group], ['status', 'Active']])->first();
        if (!$mainMenu) {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['id', $menu], ['status', 'Active']])->first();
        if (!$subMenu) {
            abort(404);
        }
        $data['subMenu'] = $subMenu;

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = $subMenu->type == 'heading' ? null : 'article';
        $counterData = Helper::pageCounterCounts($subMenu->name, $pgurl, $pgtype);

        $data['counterData'] = $counterData;
        // dd($data,$pgtype);
        return view('front.menucategories', $data);
    }

    public function getMenuItems($group, $menu, $cat)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['id', $group], ['status', 'Active']])->first();
        if (!$mainMenu) {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['id', $menu], ['status', 'Active']])->first();
        if (!$subMenu) {
            abort(404);
        }
        $data['subMenu'] = $subMenu;

        $menuCategory = MenuItemCategory::where([['id', $cat], ['status', 'Active']])->first();
        if (!$menuCategory) {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $data['menuItems'] = $menuCategory->items()->where('status', '=', 'Active')->orderByDesc('id')->get();

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = $menuCategory->type == 'heading' ? null : 'article';
        $counterData = Helper::pageCounterCounts($menuCategory->name, $pgurl, $pgtype);

        $data['counterData'] = $counterData;

        // dd($data);
        return view('front.menulist', $data);
    }

    public function getMenuItemDetail($group, $menu, $cat, $item)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['id', $group], ['status', 'Active']])->first();
        if (!$mainMenu) {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['id', $menu], ['status', 'Active']])->first();
        if (!$subMenu) {
            abort(404);
        }
        $data['subMenu'] = $subMenu;

        $menuCategory = MenuItemCategory::where([['id', $cat], ['status', 'Active']])->first();
        if (!$menuCategory) {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $menuItem = MenuItem::where([['id', $item], ['status', 'Active']])->first();
        if (!$menuItem) {
            abort(404);
        }
        $data['menuItem'] = $menuItem;

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = $menuItem->type == 'heading' ? null : 'article';
        $counterData = Helper::pageCounterCounts($menuItem->name, $pgurl, $pgtype);

        $data['counterData'] = $counterData;

        // dd($data);
        return view('front.menuitemdetail', $data);
    }

    public function getMenuSubItemDetail($group, $menu, $cat, $item, $subitem)
    {
        $data = [];
        $mainMenu = MenuGroup::where([['id', $group], ['status', 'Active']])->first();
        if (!$mainMenu) {
            abort(404);
        }
        $data['mainMenu'] = $mainMenu;

        $subMenu = MenuSubGroup::where([['id', $menu], ['status', 'Active']])->first();
        if (!$subMenu) {
            abort(404);
        }
        $data['subMenu'] = $subMenu;

        $menuCategory = MenuItemCategory::where([['id', $cat], ['status', 'Active']])->first();
        if (!$menuCategory) {
            abort(404);
        }
        $data['menuCategory'] = $menuCategory;

        $menuItem = MenuItem::where([['id', $item], ['status', 'Active']])->first();
        if (!$menuItem) {
            abort(404);
        }
        $data['menuItem'] = $menuItem;

        $menuSubItem = MenuSubItem::where([['id', $subitem], ['status', 'Active']])->first();
        if (!$menuSubItem) {
            abort(404);
        }
        $data['menuSubItem'] = $menuSubItem;

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = $menuSubItem->type == 'heading' ? null : 'article';
        $counterData = Helper::pageCounterCounts($menuSubItem->name, $pgurl, $pgtype);

        $data['counterData'] = $counterData;
        // dd($data);
        return view('front.menusubitemdetail', $data);
    }

    public function getLibrary(Request $request)
    {
        $filterchar = 'all';
        if (isset($request->filter) && trim($request->filter)) {
            $filterchar = trim($request->filter);
        }

        $library_categories = LibraryCategory::where('parent_id', '=', null)->where('status', '=', 'Active')->orderBy('name')->get(['id', 'name', 'slug'])->toArray();

        $data['filterchar'] = $filterchar;
        $data['js_lib_categories'] = json_encode($library_categories);

        return view('front.libraries', $data);
    }

    public function getLibraryContents($cat)
    {
        $library_category = LibraryCategory::where([['id', $cat], ['status', 'Active']])->first();
        if (!$library_category) {
            abort(404);
        }

        $data['library_category'] = $library_category;
        // $data['directories'] = $library_category->childs()->get(['id', 'name', 'slug']);
        // $data['library_materials'] = $library_category->materials()->where('status', '=', 'Active')->orderByDesc('id')->get(['id', 'name', 'slug', 'published_year', 'author', 'pages', 'description']);
        
        $directories = $library_category->childs()->get(['id', 'name', 'slug']);
        $library_materials = $library_category->materials()->where('status', '=', 'Active')->orderByDesc('id')->get(['id', 'name', 'slug', 'published_year', 'author', 'pages', 'description']);
        
        $data['js_lib_categories'] = json_encode($directories);
        $data['js_lib_materials'] = json_encode($library_materials);

        // dd($data);
        return view('front.librarycontents', $data);
    }

    public function getLibraryContentDetail($cat, $mat)
    {
        $library_category = LibraryCategory::where([['id', $cat], ['status', 'Active']])->first();
        if (!$library_category) {
            abort(404);
        }

        $material = LibraryMaterial::where([['id', $mat], ['status', 'Active']])->first();
        if (!$material) {
            abort(404);
        }

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = $material->type == 'heading' ? null : 'article';
        $counterData = Helper::pageCounterCounts($material->name, $pgurl, $pgtype);

        return view('front.librarycontentdetail', compact('library_category', 'material', 'counterData'));
    }

    public function popularcourse()
    {
        $data = Course::all()->where('isPopular', '=', 'Yes')->where('status', '=', 'Active')->sortBy('order');
        return view('front.popularcourse', compact('data'));
    }
    public function runningbatch()
    {
        $data = Batch::all()->where('status', '=', 'Running');
        return view('front.runningbatches', compact('data'));
    }
    public function about()
    {
        return view('front.about');
    }

    public function books()
    {
        $data['books'] = Book::where('status', '=', 'Active')->orderByDesc('order')->paginate(12);
        $data['categories'] = Categories::where(['status' => 'Active', 'type' => 'book_category'])->whereHas('cat_books')->get();
        // dd($data);
        return view('front.books.index', $data);
    }

    public function publisherBookCategories($pub)
    {
        $publisher = Categories::where('id', $pub)->where('type', '=', 'book_publisher')->first();
        if (!$publisher) {
            abort(404, 'Book Publisher Not Found');
        }

        $data['publisher'] = $publisher;
        $data['categories'] = $publisher->pub_categories()
            ->where('status', '=', 'Active')
            ->get()
            ->map(function ($cat) {
                // $bookimg = $cat->cat_books()->where('status', '=', 'Active')->orderByDesc('order')->first(['thumbnail']);
                // $cat->image = $bookimg->thumbnail ?? null;
                $book = $cat->cat_books()->where('status', '=', 'Active')->orderByDesc('order')->first(['title','thumbnail','edition']);
                $cat->image = $book->thumbnail ?? null;
                $cat->book_title = $book->title ?? null;
                $cat->book_edition = $book->edition ?? null;
                return $cat;
            });

        // dd($data);
        return view('front.books.publisher_category', $data);
    }

    public function publisherAllBooks($pub)
    {
        $publisher = Categories::where('id', $pub)->where('type', '=', 'book_publisher')->first();
        if (!$publisher) {
            abort(404, 'Book Publisher Not Found');
        }

        $data['publisher'] = $publisher;
        $data['category'] = null;
        $data['categories'] = $publisher->pub_categories()->where('status', '=', 'Active')->get();
        $data['books'] = $publisher->pub_books()->where('status', '=', 'Active')->orderByDesc('order')->paginate(12);

        // dd($data);
        return view('front.books.publisher_category_books', $data);
    }

    public function publisherCategoryBooks($pub, $cat)
    {
        $publisher = Categories::where('id', $pub)->where('type', '=', 'book_publisher')->first();
        if (!$publisher) {
            abort(404, 'Book Publisher Not Found');
        }

        $category = Categories::where('id', $cat)->where('type', '=', 'book_category')->first();
        if (!$category) {
            abort(404, 'Book Category Not Found');
        }

        $data['publisher'] = $publisher;
        $data['category'] = $category;
        $data['categories'] = $publisher->pub_categories()->where('status', '=', 'Active')->get();
        $data['books'] = $category->cat_books()->where('status', '=', 'Active')->orderByDesc('order')->paginate(12);

        // dd($data);
        return view('front.books.publisher_category_books', $data);
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

    public function singleBook($bid)
    {
        $book = Book::where('id', $bid)->where('status', '=', 'Active')->first();
        if (!$book) {
            abort(404, 'Book Not Found');
        }
        $book_reviews = $book->reviews()->orderByDesc('id')->take(30)->get();

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Single Book Detail', $pgurl);

        return view('front.books.single_book', compact('book', 'book_reviews', 'counterData'));
    }

    public function addBookReview($bid, Request $request)
    {
        $book = Book::where('id', $bid)->first();
        if (!$book) {
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

        return redirect('/books/' . $book->id);
    }

    public function contact()
    {
        return view('front.contact');
    }
    public function enquiry()
    {
        $proviences = Provience::all()->sortBy('name');
        return view('front.admissionForm', compact('proviences'));
    }

    public function showCourseEnquiryForm($courseslug)
    {
        // dd($courseslug);
        $course = Course::where('slug', $courseslug)->first();
        if (!$course) {
            abort(404, 'Course Not Found');
        }
        $proviences = Provience::all()->sortBy('name');
        return view('front.singleCourseEnquiryForm', compact('proviences', 'course'));
    }

    public function tutors()
    {
        $tutors = Tutor::where('status', '=', 'Active')->get()->sortByDesc('id');
        return view('front.tutors', compact('tutors'));
    }
    public function syllabus()
    {
        $syllabus = Syllabus::all()->sortByDesc('id');
        return view('front.syllabus', compact('syllabus'));
    }
    public function materials()
    {
        $meterials = StudyMaterial::all()->sortByDesc('id');
        return view('front.materials', compact('meterials'));
    }

    public function courselist($slug)
    {
        $category = Categories::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }
        $categories = Categories::all()->where('status', '=', 'Active')->sortBy('order');
        return view('front.categoryCourses', compact('categories', 'category'));
    }
    public function categorylist()
    {
        $course = Course::all()->where('status', 'Active')->sortBy('order');
        $categories = Categories::all()->where('status', '=', 'Active')->sortBy('order');
        return view('front.allCategory', compact('categories', 'course'));
    }
    public function coursedetails($slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            abort(404);
        }

        return view('front.coursedetails', compact('course'));
    }

    public function batchdetails($courseslug, $batchslug)
    {
        $course = Course::where('slug', $courseslug)->first();
        if (!$course) {
            abort(404);
        }
        $batch = Batch::where('course_id', '=', $course->id)->where('slug', $batchslug)->first();
        if (!$batch) {
            abort(404);
        }

        return view('front.batchdetails', compact('batch'));
    }

    public function tutorDetails($slug)
    {
        $tutor = Tutor::where('slug', $slug)->first();
        if (!$tutor) {
            abort(404);
        }
        $tutorposts = $tutor->posts()->where('status', '=', 'Published')->get(); //you can use this when you need to display particular tutor posts 
        return view('front.tutordetails', compact('tutor', 'tutorposts'));
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

    public function saveReview(Tutor $tutor, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'rating' => ['required', 'numeric', 'lt:6'],
            'contents' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withInput();
        }

        $tutor->reviews()->create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review' => $request->contents,
            'status' => 'Unpublished',
        ]);

        return redirect('/tutor/' . $tutor->slug);
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

        $class = Orientation::where('slug', '=', $request->class_slug)->first();
        if (!$class) {
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
        if (!$query) {
            return back();
        }
        $data = [];
        $data['query'] = $query;

        $data['menu_posts'] = [];

        $menu_sub_items = MenuSubItem::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('name', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get()
            ->map(function ($update) {
                $link = "#";
                if ($update->item) {
                    if ($update->item->category) {
                        if ($update->item->category->subGroup) {
                            if ($update->item->category->subGroup->group) {
                                $link = '/' . $update->item->category->subGroup->group->id . '/' . $update->item->category->subGroup->id . '/' . $update->item->category->id . '/' . $update->item->id . '/' . $update->id;
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
            ->values()
            ->toArray();

        $menu_items = MenuItem::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('name', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get()
            ->map(function ($update) {
                $link = "#";
                if ($update->category) {
                    if ($update->category->subGroup) {
                        if ($update->category->subGroup->group) {
                            $link = '/' . $update->category->subGroup->group->id . '/' . $update->category->subGroup->id . '/' . $update->category->id . '/' . $update->id;
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
            ->values()
            ->toArray();

        $menu_categories = MenuItemCategory::where('status', '=', 'Active')
            ->where('type', '!=', 'heading')
            ->where(function ($req) use ($query) {
                $req->where('name', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get()
            ->map(function ($cat) {
                $link = "#";
                if ($cat->subGroup) {
                    if ($cat->subGroup->group) {
                        $link = '/' . $cat->subGroup->group->id . '/' . $cat->subGroup->id . '/' . $cat->id;
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
            ->values()
            ->toArray();

        $menu_submenus = MenuSubGroup::where('status', '=', 'Active')
            ->where('type', '!=', 'heading')
            ->where(function ($req) use ($query) {
                $req->where('name', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get()
            ->map(function ($cat) {
                $link = "#";

                if ($cat->group) {
                    $link = '/' . $cat->group->id . '/' . $cat->id;
                }

                return [
                    'id' => $cat->id,
                    'title' => $cat->name,
                    'slug' => $cat->slug,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->values()
            ->toArray();


        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_submenus);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_categories);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_items);
        $data['menu_posts'] = array_merge($data['menu_posts'], $menu_sub_items);
        usort($data['menu_posts'], function ($a, $b) {
            return strcmp($b['created_at'], $a['created_at']);
        });

        $data['blogs'] = Blog::where('status', '=', 'Published')
            ->where(function ($req) use ($query) {
                $req->where('title', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($b) {
                $b['link'] = '/blogs/' . $b->id;
                return $b;
            })
            ->values()
            ->toArray();

        $data['books'] = Book::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('title', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($b) {
                $b['link'] = '/books/' . $b->id;
                return $b;
            })
            ->values()
            ->toArray();

        $data['premium_exams'] = ExamHallCategories::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('title', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($e) {
                $e['link'] = '/exam-hall/premium/' . $e->id;
                return $e;
            })
            ->values()
            ->toArray();

        $data['library_materials'] = LibraryMaterial::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('name', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags', 'Like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'name', 'slug', 'created_at', 'category_id'])
            ->map(function ($cat) {
                $link = "#";

                if ($cat->category) {
                    $link = '/library/' . $cat->category->id . '/' . $cat->id;
                }

                return [
                    'id' => $cat->id,
                    'title' => $cat->name,
                    'slug' => $cat->slug,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->values()
            ->toArray();

        $data['pdf_banks'] = PDFBank::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('title', 'Like', '%' . $query . '%')
                    ->orWhere('slug', 'Like', '%' . $query . '%');
                // ->orWhere('search_tags','Like','%'.$query.'%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($cat) {
                $link = "/pdf-banks/bank/" . $cat->id;

                return [
                    'id' => $cat->id,
                    'title' => $cat->title,
                    'slug' => $cat->slug,
                    'created_at' => $cat->created_at,
                    'link' => $link,
                ];
            })
            ->values()
            ->toArray();

        $data['vaccancies'] = VaccancyPost::where('status', '=', 'Active')
            ->where(function ($req) use ($query) {
                $req->where('title', 'Like', '%' . $query . '%')
                    ->orWhere('slug', 'Like', '%' . $query . '%')
                    ->orWhere('search_tags','Like','%'.$query.'%');
            })
            ->orderByDesc('id')
            ->take(20)
            ->get(['id', 'title', 'slug', 'created_at'])
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'title' => $cat->title,
                    'slug' => $cat->slug,
                    'created_at' => $cat->created_at,
                    'link' => '/vaccancies/' . $cat->id,
                ];
            })
            ->values()
            ->toArray();
        
        // dd($data);

        return view('front.search', $data);
    }

    public function getTestimonials()
    {
        $data['testimonials'] = Testimonial::where('status', '=', 'Active')->orderByDesc('id')->get();
        return view('front.testimonials', $data);
    }

    public function addTestimonials(Request $request)
    {
        $data = request()->validate([
            'name' => 'required | string',
            'testimonial_as' => 'required | string',
            'email' => 'nullable|email',
            'message' => 'required|string',
            'photo' => 'image|nullable',
        ]);
        $imgpath = ' ';
        if (isset($data['photo'])) {
            $imgpath = request('photo')->store('uploads', 'public');
        }
        Testimonial::create([
            'name' => $data['name'],
            'role' => $data['testimonial_as'] ?? 'Visitor',
            'email' => $data['email'],
            'message' => $data['message'],
            'image' => $imgpath,
            'status' => 'Inactive',
        ]);
        return redirect('/testimonials');
    }

    public function allFreeVideos()
    {
        $videos = FreeVideo::orderByDesc('id')->paginate(12);
        return view('front.all_free_video', compact('videos'));
    }

    public function playFreeVideo(FreeVideo $video)
    {
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Play Free Video', $pgurl);
        return view('front.play_free_video', compact('video', 'counterData'));
    }

    public function pageCounterIncrement(Request $request)
    {
        $data['page']            = '';
        $data['page_view_count'] = '0';
        $data['page_share_count'] = '0';
        $data['page_download_count'] = '0';

        if (isset($request->data)) {
            $fetched = json_decode($request->data);
            if (isset($fetched->type) && isset($fetched->page) && isset($fetched->pageurl) && trim($fetched->page) && trim($fetched->type) && $fetched->pageurl) {
                $postViewCounter = PostViewCounter::firstOrCreate([
                    'url' => $fetched->pageurl,
                ]);

                if (strtolower(trim($fetched->type)) == 'share') {
                    $postViewCounter->increment('share_count');
                } elseif (strtolower(trim($fetched->type)) == 'download') {
                    $postViewCounter->increment('download_count');
                } else {
                }

                $data['page']            = trim($fetched->page);
                $data['page_view_count'] = $postViewCounter->view_count;
                $data['page_share_count'] = $postViewCounter->share_count;
                $data['page_download_count'] = $postViewCounter->download_count;
                return response()->json([
                    'success' => true,
                    'message' => 'Data Counter Update Fetch Successful',
                    'data' => (object)$data,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Counter Update Fetch Failed',
            'data' => (object)$data,
        ]);
    }

    public function qrBookScanForm($book, $bsn)
    {
        $qrbook = QRBook::with('book')->whereHas('book')->where('id', $book)->first();
        if (!$qrbook) {
            abort(404, 'Book Not Found');
        }

        $furl = $qrbook->id . '/' . $bsn;
        $furl = url('/qr-book-scans/' . $furl);

        $main_book = $qrbook->scanMembers()->where('book_link', '=', $furl)->where('is_main', '=', true)->first(['id', 'book_link', 'book_id', 'is_main']);

        if (!$main_book) {
            abort(404, 'Book Serial Not Found');
        }

        $data['proviences'] = Provience::all();
        $data['book'] = $qrbook->book;
        $data['qrbook'] = $qrbook;
        $data['main_book'] = $main_book;

        // dd($data);
        return view('front.books.qr_book_scan', $data);
    }

    public function qrBookScanMemberStore($book, $member, Request $request)
    {
        // dd($request->all());
        $book = QRBook::find($book);
        if (!$book) {
            abort(404, 'Book Not Found');
        }

        $member = $book->scanMembers()->find($member);

        if ($member) {
            $request->validate([
                'full_name' => 'required|string',
                'email' => 'nullable|email',
                'contact' => 'numeric|required|digits:10',
                'provience' => 'required|string',
                'district' => 'nullable|string',
                'course' => 'nullable|string',
            ]);

            $data['status'] = 'lost';
            if (!$member->name && !$member->contact) {
                $member->update([
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'contact' => $request->contact,
                    'provience' => $request->provience,
                    'district' => $request->district,
                    'course' => $request->course,
                    'scan_date' => date('Y-m-d G:i:s'),
                ]);

                if ($member->is_winner) {
                    $data['status'] = 'won';

                    if (strtolower($member->winner_remarks) == 'book-winner') {
                        $data['message'] = "<h3>Congratulations!</h3>
                        <div> Dear <strong>" . ucwords($member->name) . "</strong> jee,</div> 
                        <div><strong>You Won The Book.</strong></div>  
                        <div>We're delighted for you and hope you thoroughly enjoy your prize.  
                        To get a prize please reach out to us at info@shisiradhikari.com. </div> 
                        <div>Thank You!</div>";
                    } elseif (strtolower($member->winner_remarks) == 'full-course-winner') {
                        $data['message'] = "<h3>Congratulations!</h3>
                        <div> Dear <strong>" . ucwords($member->name) . "</strong> jee,</div> 
                        <div><strong>You Won a Full Scholarship (Online Course of 'AHW' Loksewa) at Etutor Class.</strong></div> 
                        <div>For more details, please reach out to us at info@shisiradhikari.com.  </div>
                        <div>Thank You! </div>";
                    } elseif (strtolower($member->winner_remarks) == 'half-course-winner') {
                        $data['message'] = "<h3>Congratulations!</h3>
                        <div> Dear <strong>" . ucwords($member->name) . "</strong> jee, </div> 
                        <div><strong> You Won a 50% Scholarship (Online Course of 'AHW' Loksewa) at Etutor Class.</strong></div> 
                        <div>For more details, please reach out to us at info@shisiradhikari.com </div>.  
                        <div>Thank You!</div>";
                    } else {
                        $data['status'] = 'lost';
                    }
                }

                $data['member'] = $member;
            } else {
                $find = $book->scanMembers()->where('email', '=', $request->email)->orWhere('contact', '=', $request->contact)->first();

                if ($find) {
                    $data['member'] = $find;
                    $data['message'] = "<h3>Sorry!</h3> 
                    <div> Dear <strong>" . ucwords($data['member']->name) . "</strong> jee,</div>  
                    <div>Your details for this book lucky draw is already registered. </div> 
                    <div> Unfortunately, you were not selected as a winner in the lucky draw. 
                    We acknowledge that this situation may be frustrating,  
                    but we still encourage you to persist in reading the book.  
                    Additionally, you have the option to scan and submit another request for the Lucky Draw.  </div>
                    <div>Thank You!</div>
                    ";
                } else {
                    $new_member = $book->scanMembers()->create([
                        'book_link' => $member->book_link,
                        'name' => $request->full_name,
                        'email' => $request->email,
                        'contact' => $request->contact,
                        'provience' => $request->provience,
                        'district' => $request->district,
                        'course' => $request->course,
                        'scan_date' => date('Y-m-d G:i:s'),
                    ]);

                    $data['member'] = $new_member;
                }
            }

            $data['book'] = $book->book;

            if ($data['status'] == 'lost') {
                if (!isset($data['message'])) {
                    $data['message'] = "<h3>Sorry!</h3> 
                    <div>Dear <strong>" . ucwords($data['member']->name) . "</strong> jee, </div> 
                    <div> Unfortunately, you were not selected as a winner in the lucky draw.
                    We acknowledge that this situation may be frustrating,  
                    but we still encourage you to persist in reading the book.  
                    Additionally, you have the option to scan and submit another request for the Lucky Draw.</div>  
                    <div>Thank You!</div>
                    ";
                }
            }

            // dd($data);
            return view('front.books.qr_book_scan_result', $data);
        }

        abort(403, 'Book QR Link Not Found');
    }

    public function bmiCalculator()
    {
        $data = [];

        return view('front.bmi_calculator', $data);
    }


    public function healthIngo()
    {
        $data = [];
        return view('front.health_ingo', $data);
    }

    public function getQuestionOfDay($qdate)
    {
        $qdate = date('Y-m-d', strtotime($qdate));
        $today_question = DailyMCQQuestion::where('show_date', '=', $qdate)->first();
        if (!$today_question) {
            abort(404);
        }

        $today_question->image = $this->generateQuestionImage($today_question);
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Question Of The Day ' . $qdate, $pgurl, 'article');

        $previous_questions = DailyMCQQuestion::where('show_date', '<', $qdate)
            ->orderByDesc('id')
            ->take(2)
            ->get()
            ->map(function ($q) {
                $q->image = $this->generateQuestionImage($q);
                return (object)$q->only('id', 'show_date', 'image');
            });

        // dd($previous_questions);
        return view('front.question_of_day', compact('today_question', 'counterData', 'previous_questions'));
    }

    public function addCommentToQuestionOfDay($qdate, Request $request)
    {
        $qdate = date('Y-m-d', strtotime($qdate));
        $today_question = DailyMCQQuestion::where('show_date', '=', $qdate)->first();
        if (!$today_question) {
            abort(404);
        }

        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|string',
            'contact' => 'required|numeric',
            'contents' => 'required|string',
        ]);

        $today_question->comments()->create([
            'post_type' => 'daily_mcq_question',
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'message' => $request->contents,
            'status' => 'Published',
        ]);

        return redirect('/question-of-the-day/' . $today_question->show_date);
    }

    private function generateQuestionImage($question)
    {
        $question_image = "question_images/question_" . date('Y_m_d_', strtotime($question->show_date)) . $question->id . ".png";

        if (!file_exists(public_path($question_image))) {
            try {
                $qtext = wordwrap(trim(htmlspecialchars_decode(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags('Question: ' . $question->question))))), 60, "\n", false);
                $qtextline = substr_count($qtext, "\n");
                $qoptions = [
                    'A' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_a)))),
                    'B' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_b)))),
                    'C' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_c)))),
                    'D' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_d)))),
                ];

                $image = QuestionImage::make(public_path('question_images/question_bg.png'));

                $optionY = 150;
                $image->text($qtext, 75, $optionY, function ($font) {
                    $font->file(public_path('fonts/arial-bold.ttf'));
                    $font->size(32);
                    $font->color('#02074e');
                    $font->align('left');
                    $font->valign('top');
                });

                $optionY = $optionY + 50 + ($qtextline * 50);

                foreach ($qoptions as $key => $option) {

                    $optionText = wordwrap($option, 65, "\n", false);
                    $image->text(($key) . '.', 120, $optionY, function ($font) {
                        $font->file(public_path('fonts/arial.ttf'));
                        $font->size(32);
                        $font->color('#144389');
                        $font->align('left');
                        $font->valign('top');
                    });

                    $image->text($optionText, 160, $optionY, function ($font) {
                        $font->file(public_path('fonts/arial.ttf'));
                        $font->size(32);
                        $font->color('#144389');
                        $font->align('left');
                        $font->valign('top');
                    });

                    $optonline = substr_count($optionText, "\n");
                    $optionY = $optionY + 45 * ($optonline + 1); // Adjust vertical spacing between options
                }

                $image->text((date('Y/m/d', strtotime($question->show_date))), 875, 530, function ($font) {
                    $font->file(public_path('fonts/arial-bold.ttf'));
                    $font->size(28);
                    $font->color('#c50027');
                    $font->align('left');
                    $font->valign('top');
                });

                $image->save(public_path($question_image));
            } catch (\Throwable $th) {
                return null;
            }
        }

        return url($question_image);
    }

    public function discussionForum()
    {
        // $data['messages'] = DiscussionForum::with('user:id,name,photo')
        // ->orderByDesc('id')
        // ->take(150)
        // ->get()
        // ->sortBy('id');

        $messages = DiscussionForum::with('user:id,name,photo')
            ->orderByDesc('id')
            ->paginate(12);

        $sortedResult = $messages->getCollection()->sortBy('id')->values();
        $messages->setCollection($sortedResult);

        $data['messages'] = $messages;

        // dd($data);
        return view('front.forms.forum', $data);
    }

    public function discussionForumStore(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'post_image' => 'image|nullable|max:5000',
        ]);

        $msg = strip_tags($request->message);
        if (isset($request->post_image)) {
            $img = $request->post_image->store('forum_images', 'public');
            $msg = $msg . '  <img src="/storage/' . $img . '">';
        }

        DiscussionForum::create([
            'user_id' => auth()->user()->id,
            'message' => $msg,
        ]);

        return redirect('/discussion-forum');
    }

    public function discussionForumDestroy(Request $request)
    {
        $request->validate([
            'mid' => 'required|numeric',
        ]);

        $msg = DiscussionForum::find($request->mid);

        $msg->delete();

        return redirect()->back();

        // return redirect('/discussion-forum');
    }

    public function palikaBibaran()
    {
        $data = [];
        return view('front.palika_bibaran', $data);
    }

    public function webPolicy()
    {
        $data = [];
        return view('front.policy', $data);
    }

    public function imageGallery()
    {
        $data['images'] = ImageGallery::where('status', '=', 1)->orderByDesc('id')->paginate(12);
        return view('front.img_gallery', $data);
    }

    public function addPhysicalBookOrder($bid, Request $request)
    {
        $book = Book::where('id', $bid)->first();
        if (!$book) {
            abort(404);
        }

        // dd($request->all());

        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'location' => 'nullable|string',
            'quantity' => 'nullable|numeric',
            'unit_price' => 'nullable|numeric',
            'message' => 'nullable|string',
        ]);

        PhysicalBookOrder::create([
            'book_category' => $book->category->name ?? '',
            'book_title' => $book->title,
            'book_author' => $book->author,
            'book_publisher' => $book->publisher->name ?? '',
            'book_ref_image' => $book->thumbnail,
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'message' => $request->message,
            'name' => $request->name,
            'contact' => $request->contact,
            'location' => $request->location,
            'status' => 'pending',

        ]);

        return redirect('/books/' . $book->id)->with('success_message', 'Your Request Has Been Submitted. Our Team Will Call You For Further Enquiries. Please Wait Patiently.');
    }
}
