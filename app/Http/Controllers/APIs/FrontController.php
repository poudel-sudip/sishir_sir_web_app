<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

// use Laravel\Sanctum\HasApiTokens;

use App\Models\Blog;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Categories;
use App\Models\FreeVideo;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Tutor;
use App\Models\TutorReview;
use App\Models\Reports\ReportUser;
use App\Models\VideoCourse\VideoCategory;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoPost;
use App\Models\Ebook\Ebook;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\StudyMaterial;
use App\Models\Syllabus;
use App\Models\ManualBooking;
use App\Models\Provience\Provience;
use App\Models\Orientation;

class FrontController extends Controller
{
    public function activeCourses()
    {
        $courses=Course::where('status','=','Active')->get()->map(function($course){
            return [
                
                'course_id'=>$course->id,
                'course_name'=>$course->name,
                'course_slug'=>$course->slug,
                'course_image'=>$course->image,
                'category'=>[
                    'category_id'=>$course->category->id ?? '',
                    'category_name'=>$course->category->name ?? '',
                    'category_slug'=>$course->category->slug ?? '',
                ],
                'batches'=> $course->batches()->whereIn('status',['Active','Running'])->get(['id','name','slug','fee','discount','status'])->map(function($batch){
                    return [
                        'batch_id'=>$batch->id,
                        'batch_name'=>$batch->name,
                        'batch_slug'=>$batch->slug,
                        'batch_fee'=>$batch->fee,
                        'batch_discount'=>$batch->discount,
                        'class_status'=>$batch->class_status,
                        'batch_status'=>$batch->status,
                    ];
                }),
            ];
        });

        return response()->json($courses, 200);
    }

    public function popularcourse()
    {
        $data=Course::where('isPopular','=','Yes')->where('status','=','Active')->get()->map(function($course){
            return [
                'id'=>$course->id,
                'name'=>$course->name,
                'slug'=>$course->slug,
                'description'=>$course->description,
                'detail'=>$course->detail,
                'isPopular'=>$course->isPopular,
                'image'=>$course->image,
                'category'=>[
                    'id'=>$course->category->id ?? '',
                    'name'=>$course->category->name ?? '',
                    'slug'=>$course->category->slug ?? '',
                ],
            ];
        });
        return response()->json($data,200);
    }

    public function runningBatches()
    {
        $batches=Batch::where('status','=','Running')->get()->map(function($batch){
            return [
                'id'=>$batch->id,
                'name'=>$batch->name,
                'slug'=>$batch->slug,
                'fee'=>$batch->fee,
                'discount'=>$batch->discount,
                'duration'=>$batch->duration.' '.$batch->durationType,
                'startDate'=>$batch->startDate,
                'endDate'=>$batch->endDate,
                'timeSlot'=>$batch->timeSlot,
                'status'=>$batch->status,
                'class_status'=>$batch->class_status,
                'course'=>[
                    'id'=>$batch->course->id ?? '',
                    'name'=>$batch->course->name ?? '',
                    'slug'=>$batch->course->slug ?? '',
                    'image'=>$batch->course->image ?? '',
                    'category'=>[
                        'id'=>$batch->course->category->id ?? '',
                        'name'=>$batch->course->category->name ?? '',
                        'slug'=>$batch->course->category->slug ?? '',
                    ],
                    
                ],                
            ];
        });
        return response()->json($batches,200);
    }

    public function sliders()
    {
        $sliders=Slider::all();
        return response()->json($sliders,200);
    }

   public function freeVideos()
   {
        $videos=FreeVideo::all();
        return response()->json($videos,200);
   }

   public function allCategories()
   {
        $categories=Categories::where('status','=','Active')->get();
        return response()->json($categories,200);
   }

   public function testimonials()
   {
        $testimonials=Testimonial::all();
        return response()->json($testimonials,200);
   }

   public function courselist($slug)
   {
       $category=Categories::where('slug',$slug)->first();

       if(!$category)
       {
          return response()->json(['error'=>'Category Not Found'], 404);
       }
       $courses=$category->courses()->where('status','=','Active')->get(['id','name','slug','image'])->toArray();
       return response()->json([
           'category'=>[
                'id'=>$category->id,
                'name'=>$category->name,
                'slug'=>$category->slug,
                'order'=>$category->order,
                'courses'=>$courses,
           ],
       ], 200);
   }

   public function coursedetails($slug)
    {
        $course=Course::where('slug',$slug)->first();
        if(!$course)
        {
            return response()->json(['error'=>'Course Not Found'], 404);
        }
        return response()->json([
            'course'=>[
                'id'=>$course->id,
                'name'=>$course->name,
                'slug'=>$course->slug,
                'description'=>$course->description,
                'detail'=>$course->detail,
                'isPopular'=>$course->isPopular,
                'image'=>$course->image,
                'category'=>[
                    'id'=>$course->category->id,
                    'name'=>$course->category->name,
                    'slug'=>$course->category->slug,
                ],
                'features'=>$course->normalFeatures()->get(['id','title','description','image']),
                'uniqueFeatures'=>$course->uniqueFeatures()->get(['id','title','description','image']),
                'batches'=>$course->batches()->get(),
            ],
        ], 200);
    }

    public function batchdetails($courseslug,$batchslug)
    {
        $course=Course::where('slug',$courseslug)->first();
        if(!$course)
        {
            return response()->json(['error'=>'Course Not Found'], 404);
        }
        $batch=Batch::where('course_id','=',$course->id)->where('slug',$batchslug)->first();
        if(!$batch)
        {
            return response()->json(['error'=>'Batch Not Found'], 404);
        }

        return response()->json([
            'batch'=>[
                'id'=>$batch->id,
                'name'=>$batch->name,
                'slug'=>$batch->slug,
                'description'=>$batch->description,
                'fee'=>$batch->fee,
                'discount'=>$batch->discount,
                'duration'=>$batch->duration.' '.$batch->durationType,
                'startDate'=>$batch->startDate,
                'endDate'=>$batch->endDate,
                'timeSlot'=>$batch->timeSlot,
                'status'=>$batch->status,
                'class_status'=>$batch->class_status,
                'course'=>[
                    'id'=>$course->id,
                    'name'=>$course->name,
                    'slug'=>$course->slug,
                    'image'=>$course->image,
                    'category'=>[
                        'id'=>$course->category->id,
                        'name'=>$course->category->name,
                        'slug'=>$course->category->slug,
                    ],
                ],
                'tutors'=>$batch->tutors()->get()->map(function($tutor){
                    return [
                        'id'=>$tutor->id,
                        'name'=>$tutor->name,
                        'slug'=>$tutor->slug,
                        'experience'=>$tutor->experience,
                        'qualification'=>$tutor->qualification,
                        'rating'=>$tutor->rating,
                        'photo'=>$tutor->user->photo ?? '',
                    ];
                }),
            ],
        ], 200);
    }
   
    public function allTutors()
    {
        $tutors=Tutor::where('status','=','Active')->get()->map(function($tutor){
            return [
                'id'=>$tutor->id,
                'user_id'=>$tutor->user_id,
                'name'=>$tutor->name,
                'slug'=>$tutor->slug,
                'email'=>$tutor->user->email ?? '',
                'contact'=>$tutor->user->contact ?? '',
                'photo'=>$tutor->user->photo ?? '',
                'experience'=>$tutor->experience,
                'qualification'=>$tutor->qualification,
                'description'=>$tutor->description,
                'rating'=>$tutor->rating,
                'status'=>$tutor->status,
            ];
        });
        return response()->json($tutors,200);
    }

    public function tutorDetails($slug)
    {
        $tutor=Tutor::where('slug',$slug)->first();
        if(!$tutor)
        {
            return response()->json(['error'=>'Tutor Not Found'], 404);
        }
        $batches=$tutor->batches;
        $courses=[];
        $c=[];
        foreach ($batches as $batch) {
            if(in_array($batch->course->id,$c))
            {
                continue;
            }
            array_push($c,$batch->course->id);
            $courses[]=[
                'id'=>$batch->course->id,
                'name'=>$batch->course->name,
                'slug'=>$batch->course->slug,
                'image'=>$batch->course->image,
            ];
        }
        $specialCourses=$tutor->specialCourses()->where('status','=','Active')->get()->toArray();

        return response()->json([
            'tutor'=>[
                'id'=>$tutor->id,
                'name'=>$tutor->name,
                'slug'=>$tutor->slug,
                'experience'=>$tutor->experience,
                'qualification'=>$tutor->qualification,
                'image'=>$tutor->user->photo ?? '',
                'email'=>$tutor->user->email ?? '',
                'contact'=>$tutor->user->contact ?? '',
                'description'=>$tutor->description,
                'rating'=>$tutor->rating,
                'courses'=>$courses,
                'specialCourses'=>$specialCourses,
                'reviews' => $tutor->reviews()->where('status','=','Published')->get(['id','name','email','rating','review','status','created_at']),
            ],
        ], 200);

    }

    public function saveTutorReview($slug, Request $request)
    {
        $tutor=Tutor::where('slug',$slug)->first();
        if(!$tutor)
        {
            return response()->json(['error'=>'Tutor Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'rating' => ['required', 'numeric', 'lt:6'],
            'review'=>['required','string'],
        ]);
    
        if($validator->fails()){
            return response()->json([$validator->errors()], 401);
        }

        $tutor->reviews()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'rating'=>$request->rating,
            'review'=>$request->review,
            'status'=>'Unpublished',
        ]);

        return response()->json([
            "success" => true,
            "message" => "Your Review Has Been Submitted.",
        ], 200);
    }

    public function search(Request $request)
    {
        $query=$request->input('query');
        $categories=Categories::where('name','Like','%'.$query.'%')->get();
        $courses=Course::where('name','Like','%'.$query.'%')->get();
        $batches=Batch::where('name','Like','%'.$query.'%')->get();
        $tutors=Tutor::where('name','Like','%'.$query.'%')->get();
        $videoCourses=VideoCourse::where('name','Like','%'.$query.'%')->get();
        $ebooks=Ebook::where('title','Like','%'.$query.'%')->get();
        $premiumExams=ExamHallCategories::where('title','Like','%'.$query.'%')->get();
        $blogs=Blog::where('title','Like','%'.$query.'%')->get();
        return  response()->json([
            'results'=>[
                'categories'=>$categories,
                'courses'=>$courses,
                'batches'=>$batches,
                'tutors'=>$tutors,
                'videocourse'=>$videoCourses,
                'ebooks'=>$ebooks,
                'premiumExams'=>$premiumExams,
                'blogs'=>$blogs,
            ],
            'count'=>$categories->count()+$courses->count()+$batches->count()+$tutors->count()+$videoCourses->count()+$ebooks->count()+$premiumExams->count()+$blogs->count(),
        ]);
    }

    public function fileUpload(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'uploadDocument' => 'required|max:10240',  //any type of file less than 10MB
            // 'uploadDocument' => 'required|mimes:doc,docx,pdf,txt|max:10240',  //document file
            // 'uploadDocument'  => 'required|mimes:png,jpg|max:10240',  // image file
        ]);
    
        if($validator->fails()){
            return response()->json([$validator->errors()], 401);
        }

        if ($files = $request->file('uploadDocument'))
        {
            //store file into uploads folder
            $file = $request->uploadDocument->store('uploads','public');

            return response()->json([
                "success" => true,
                "message" => "Document File Successfully Uploaded",
                "file" => $file,
            ], 200);
        }
        else
        {
            return response()->json([
                "success" => false,
                "message" => "Document File Failed To Upload",
            ], 200);
        }
  
    }

    public function getSyllabusList()
    {
        $syllabus=Syllabus::all();
        return response()->json($syllabus, 200);
    }

    public function getSyllabus($id)
    {
        $syllabus = Syllabus::find($id);
        if(!$syllabus)
        {
            return response()->json(['error'=>'Syllabus Not Found'], 404);
        }
        return response()->json($syllabus, 200);
    }

    public function getMaterialList()
    {
        $meterials=StudyMaterial::all();
        return response()->json($meterials, 200);
    }

    public function getMaterial($id)
    {
        $material = StudyMaterial::find($id);
        if(!$material)
        {
            return response()->json(['error'=>'Study Material Not Found'], 404);
        }
        return response()->json($material, 200);
    }

    public function getEbooksList()
    {
        $ebooks = Ebook::where('status','=','Active')->get();
        return response()->json($ebooks, 200);
    }

    public function getEbook($id)
    {
        $ebook = Ebook::find($id);
        if(!$ebook)
        {
            return response()->json(['error'=>'Ebook Not Found'], 404);
        }
        return response()->json([
            "id" => $ebook->id,
            "title" => $ebook->title,
            "slug" => $ebook->slug,
            "author" => $ebook->author,
            "thumbnail" => $ebook->thumbnail,
            "price" => $ebook->price,
            "discount" => $ebook->discount,
            "description" => $ebook->description,
            "isPinned" => $ebook->isPinned,
            "status" => $ebook->status,
            "created_at" => $ebook->created_at,
            "updated_at" => $ebook->updated_at,
            "chapters" => $ebook->chapters,
        ], 200);
    }

    public function getVideoCourseCategoryList()
    {
        $categories = VideoCategory::all();
        return response()->json($categories, 200);
    }

    public function getVideoCourseList()
    {
        $courses = VideoCourse::where('status','Active')->get()->map(function($course){
            return [
                "id" => $course->id,
                "name" => $course->name,
                "slug" => $course->slug,
                "order" => $course->order,
                "thumbnail" => $course->thumbnail,
                "fee" => $course->fee,
                "discount" => $course->discount,
                "status" => $course->status,
                "category_id" => $course->category->id ?? '',
                "category_name" => $course->category->name ?? '',
                "category_slug" => $course->category->slug ?? '',
            ];
        });
        return response()->json($courses, 200);
    }

    public function getVideoCategory($slug)
    {
        $category = VideoCategory::where('slug',$slug)->first();
        if(!$category)
        {
            return response()->json(['error'=>'Video Category Not Found'], 404);
        }

        $courses = $category->courses()->where('status','Active')->get(['id','name','slug','thumbnail','fee','discount','status']);

        return response()->json([
            "category_id" => $category->id ?? '',
            "category_name" => $category->name ?? '',
            "category_slug" => $category->slug ?? '',
            "category_order" => $category->order ?? '',
            "category_status" => $category->status ?? '',
            "courses" => $courses,
        ], 200);

    }

    public function getVideoCourse($slug)
    {
        $course = VideoCourse::where('slug',$slug)->first();
        if(!$course)
        {
            return response()->json(['error'=>'Video Course Not Found'], 404);
        }
        $recommended = $course->publicVideos->map(function($video){
            return [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'video_link' => $video->link,
                'content' => $video->content,
                'thumbnail' => $video->chapter->course->thumbnail,
                'created_at' => $video->created_at,
                'updated_at' => $video->updated_at,
            ];
        });

        return response()->json([
            "category_id" => $course->category->id ?? '',
            "category_name" => $course->category->name ?? '',
            "category_slug" => $course->category->slug ?? '',
            "id" => $course->id,
            "name" => $course->name,
            "slug" => $course->slug,
            "order" => $course->order,
            "thumbnail" => $course->thumbnail,
            "description" => $course->description,
            "intro_video_link" => $course->intro_video,
            "fee" => $course->fee,
            "discount" => $course->discount,
            "status" => $course->status,
            "recommended_videos" => $recommended,
        ], 200);
    }

    public function getVideoPost($slug)
    {
        $video = VideoPost::where('slug',$slug)->first();
        if(!$video)
        {
            return response()->json(['error' => 'Video Not Found'], 404);
        }

        $course = $video->chapter->course;
        $recommended = $course->publicVideos->map(function($video){
            return [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'video_link' => $video->link,
                'content' => $video->content,
                'thumbnail' => $video->chapter->course->thumbnail,
                'created_at' => $video->created_at,
                'updated_at' => $video->updated_at,
            ];
        });
        return response()->json([
            'course_id' => $course->id ?? '',
            'course_name' => $course->name ?? '',
            'course_slug' => $course->slug ?? '',
            'thumbnail' => $course->thumbnail ?? '',
            'id' => $video->id,
            'title' => $video->title,
            'slug' => $video->slug,
            'video_link' => $video->link,
            'video_content' => $video->content,
            'status' => $video->status,
            'created_at' => $video->created_at,
            'updated_at' => $video->updated_at,
            "recommended_videos" => $recommended,
        ], 200);
    }

    public function saveManualBooking(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'course'=>'required|numeric',
            'name'=>'required|string',
            'email'=>'required|email',
            'mobile'=>'required|numeric|digits:10',
            'provience'=>'required|string',
            'district'=>'nullable',
            'remarks'=>'nullable',
            'payment_slip'=>'required | string',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $booking=ManualBooking::create([
            'course_id'=>$request['course'],
            'name'=>$request['name'],
            'email'=>$request['email'],
            'mobile'=>$request['mobile'],
            'provience'=>ucwords($request['provience']),
            'district'=>ucwords($request['district']),
            'remarks'=>$request['remarks'],
            'payment_slip'=>$request['payment_slip'],
            'status'=>'Unverified',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your Manual Booking Has Been Submited. You Will Be Notified Shortly.',
        ], 200);
    }

    public function getProviences()
    {
        $proviences = Provience::all()->map(function($pro){
            $cities = [];
            foreach ($pro->cities as $city) {
                $cities[] = $city->name;
            }
            return [
                'name' => $pro->name,
                'districts' => $cities,
            ];
        });
        return response()->json([
            'success' => true,
            'proviences' => $proviences,
        ], 200);
    }

    public function getFreeOrientationList()
    {
        $orientations = Orientation::whereDate('date','>=',date("Y-m-d"))->where('status','=','Active')->get();
        return response()->json($orientations);
    }

    public function getFreeOrientation($slug)
    {
        $orientation = Orientation::where('slug','=',$slug)->where('status','=','Active')->whereDate('date','>=',date("Y-m-d"))->first();
        if(!$orientation)
        {
            return response()->json(["error" => "Free Orientation Not Found"], 404);
        }
        return response()->json($orientation);
    }

    public function joinFreeOrientation($slug, Request $request)
    {
        $orientation = Orientation::where('slug','=',$slug)->where('status','=','Active')->whereDate('date','>=',date("Y-m-d"))->first();
        if(!$orientation)
        {
            return response()->json(["error" => "Free Orientation Not Found"], 404);
        }
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email',
            'contact'=>'required|numeric|digits:10',
            'provience'=>'nullable|string',
            'district'=>'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $participant = $orientation->participants()->create([
            'class_id' => $orientation->id,
            'name' => $request->name,
            'email' => $request->email ?? '',
            'contact' => $request->contact ?? '',
            'provience' => $request->provience ?? '',
            'district' => $request->district ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Participant Registered Successfully.',
            'orientation_class' => $orientation,
            'data' => $participant,
        ],200);
    }

    public function getPrivacy()
    {
        $privacy = '<h1>Privacy Policy for Etutorclass Pvt. Ltd.</h1>

            <p>At Etutorclass, accessible from https://etutorclass.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Etutorclass and how we use it.</p>

            <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>

            <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in Etutorclass. This policy is not applicable to any information collected offline or via channels other than this website. Our Privacy Policy was created with the help of the <a href="https://www.termsfeed.com/privacy-policy-generator/">TermsFeed Free Privacy Policy Generator</a>.</p>

            <h2>Consent</h2>

            <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>

            <h2>Information we collect</h2>

            <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
            <p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
            <p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>

            <h2>How we use your information</h2>

            <p>We use the information we collect in various ways, including to:</p>

            <ul>
            <li>Provide, operate, and maintain our website</li>
            <li>Improve, personalize, and expand our website</li>
            <li>Understand and analyze how you use our website</li>
            <li>Develop new products, services, features, and functionality</li>
            <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
            <li>Send you emails</li>
            <li>Find and prevent fraud</li>
            </ul>

            <h2>Log Files</h2>

            <p>Etutorclass follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p>

            <h2>Cookies and Web Beacons</h2>

            <p>Like any other website, Etutorclass uses \'cookies\'. These cookies are used to store information including visitors\' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users\' experience by customizing our web page content based on visitors\' browser type and/or other information.</p>


            <h2>Our Advertising Partners</h2>

            <p>Some of advertisers on our site may use cookies and web beacons. Our advertising partners are listed below. Each of our advertising partners has their own Privacy Policy for their policies on user data. For easier access, we hyperlinked to their Privacy Policies below.</p>

            <ul>
                <li>
                    <p>Google</p>
                    <p><a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a></p>
                </li>
            </ul>

            <h2>Advertising Partners Privacy Policies</h2>

            <P>You may consult this list to find the Privacy Policy for each of the advertising partners of Etutorclass.</p>

            <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on Etutorclass, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>

            <p>Note that Etutorclass has no access to or control over these cookies that are used by third-party advertisers.</p>

            <h2>Third Party Privacy Policies</h2>

            <p>Etutorclass\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>

            <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p>

            <h2>CCPA Privacy Rights (Do Not Sell My Personal Information)</h2>

            <p>Under the CCPA, among other rights, California consumers have the right to:</p>
            <p>Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p>
            <p>Request that a business delete any personal data about the consumer that a business has collected.</p>
            <p>Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p>
            <p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>

            <h2>GDPR Data Protection Rights</h2>

            <p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>
            <p>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p>
            <p>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p>
            <p>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p>
            <p>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p>
            <p>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p>
            <p>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>
            <p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>

            <h2>Children\'s Information</h2>

            <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>

            <p>Etutorclass does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>
        ';

        return response()->json(['data' => $privacy]);
    }
}
