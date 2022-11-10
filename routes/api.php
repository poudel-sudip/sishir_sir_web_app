<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'v1'
    ],
    function($router)
    {
        Route::get('privacy', 'App\Http\Controllers\APIs\FrontController@getPrivacy'); 
        Route::get('sliders', 'App\Http\Controllers\APIs\FrontController@sliders'); 
        Route::get('active-courses', 'App\Http\Controllers\APIs\FrontController@activeCourses');
        Route::get('popular-courses', 'App\Http\Controllers\APIs\FrontController@popularcourse');
        Route::get('running-batches', 'App\Http\Controllers\APIs\FrontController@runningBatches');
        Route::get('free-videos', 'App\Http\Controllers\APIs\FrontController@freeVideos');
        Route::get('testimonials', 'App\Http\Controllers\APIs\FrontController@testimonials');
        Route::post('search', 'App\Http\Controllers\APIs\FrontController@search');

        Route::get('categories', 'App\Http\Controllers\APIs\FrontController@allCategories');
        Route::get('category/{slug}', 'App\Http\Controllers\APIs\FrontController@courselist');
        Route::get('courses/{slug}', 'App\Http\Controllers\APIs\FrontController@coursedetails');
        Route::get('courses/{courseslug}/{batchslug}', 'App\Http\Controllers\APIs\FrontController@batchdetails');
        Route::get('tutors', 'App\Http\Controllers\APIs\FrontController@allTutors');
        Route::get('tutor/{slug}', 'App\Http\Controllers\APIs\FrontController@tutorDetails');
        Route::post('tutor/{slug}/review', 'App\Http\Controllers\APIs\FrontController@saveTutorReview');
        Route::post('file-upload', 'App\Http\Controllers\APIs\FrontController@fileUpload');

        Route::get('blogs', 'App\Http\Controllers\APIs\BlogController@blogs'); 
        Route::get('blogs/{slug}', 'App\Http\Controllers\APIs\BlogController@singleBlog'); 

        Route::post('enquiry','App\Http\Controllers\APIs\EnquiryController@saveEnquiry');

        Route::get('premium-exams','App\Http\Controllers\APIs\PublicExamController@getPremiumExamsLists');
        Route::get('premium-exams/{slug}','App\Http\Controllers\APIs\PublicExamController@showPremiumExam');
        Route::get('free-exams','App\Http\Controllers\APIs\PublicExamController@getFreeExamsLists');
        Route::get('free-exams-results','App\Http\Controllers\APIs\PublicExamController@getFreeExamResultLists');
        Route::get('free-exams-results/{slug}','App\Http\Controllers\APIs\PublicExamController@showFreeExamResult');
        Route::get('free-exams/{slug}/attempt','App\Http\Controllers\APIs\PublicExamController@attemptFreeExam');
        Route::post('free-exams/{slug}/save','App\Http\Controllers\APIs\PublicExamController@saveFreeExam');

        Route::get('syllabus', 'App\Http\Controllers\APIs\FrontController@getSyllabusList');
        Route::get('syllabus/{id}', 'App\Http\Controllers\APIs\FrontController@getSyllabus');
        Route::get('materials', 'App\Http\Controllers\APIs\FrontController@getMaterialList');
        Route::get('materials/{id}', 'App\Http\Controllers\APIs\FrontController@getMaterial');
        Route::get('ebooks', 'App\Http\Controllers\APIs\FrontController@getEbooksList');
        Route::get('ebooks/{id}', 'App\Http\Controllers\APIs\FrontController@getEbook');
        Route::get('video-courses/all-categories', 'App\Http\Controllers\APIs\FrontController@getVideoCourseCategoryList');
        Route::get('video-courses/all-courses', 'App\Http\Controllers\APIs\FrontController@getVideoCourseList');
        Route::get('video-courses/category/{slug}', 'App\Http\Controllers\APIs\FrontController@getVideoCategory');
        Route::get('video-courses/video/{slug}', 'App\Http\Controllers\APIs\FrontController@getVideoPost');
        Route::get('video-courses/{slug}', 'App\Http\Controllers\APIs\FrontController@getVideoCourse');

        Route::get('orientations', 'App\Http\Controllers\APIs\FrontController@getFreeOrientationList');
        Route::get('orientations/{slug}', 'App\Http\Controllers\APIs\FrontController@getFreeOrientation');
        Route::post('orientations/{slug}/join', 'App\Http\Controllers\APIs\FrontController@joinFreeOrientation');
        
        Route::post('manual-booking', 'App\Http\Controllers\APIs\FrontController@saveManualBooking');
        Route::get('proviences', 'App\Http\Controllers\APIs\FrontController@getProviences');

        Route::post('login',[App\Http\Controllers\APIs\AuthController::class,'login']);
        Route::post('register',[App\Http\Controllers\APIs\AuthController::class,'register']);
        Route::post('logout',[App\Http\Controllers\APIs\AuthController::class,'logout']);
        Route::post('refresh',[App\Http\Controllers\APIs\AuthController::class,'refresh']);
        Route::get('profile',[App\Http\Controllers\APIs\AuthController::class,'profile']);
        Route::patch('profile',[App\Http\Controllers\APIs\AuthController::class,'updateProfile']);
        Route::delete('account/deactivate',[App\Http\Controllers\APIs\AuthController::class,'deactivateAccount']);

        Route::get('my/dashboard',[App\Http\Controllers\APIs\Student\DashboardController::class,'dashboard']);
        Route::get('my/notifications',[App\Http\Controllers\APIs\Student\DashboardController::class,'notifications']);
        Route::get('my/notifications/{id}',[App\Http\Controllers\APIs\Student\DashboardController::class,'getNotification']);
        Route::get('my/news-feeds',[App\Http\Controllers\APIs\Student\DashboardController::class,'getNewsFeeds']);
        Route::get('my/news-feeds/{slug}/comments',[App\Http\Controllers\APIs\Student\DashboardController::class,'getNewsComments']);
        Route::post('my/news-feeds/{slug}/comments',[App\Http\Controllers\APIs\Student\DashboardController::class,'postNewsComment']);

        //student main course booking api section
        Route::get('my/course/bookings/all','App\Http\Controllers\APIs\Student\MainCourse\BookingController@allBookings');
        Route::get('my/course/bookings/verified','App\Http\Controllers\APIs\Student\MainCourse\BookingController@verifiedBookings');
        Route::get('my/course/bookings/unverified','App\Http\Controllers\APIs\Student\MainCourse\BookingController@unverifiedBookings');
        Route::get('my/course/bookings/suspended','App\Http\Controllers\APIs\Student\MainCourse\BookingController@suspendedBookings');
        Route::post('my/course/bookings','App\Http\Controllers\APIs\Student\MainCourse\BookingController@storeBooking');
        Route::get('my/course/bookings/{bookingID}','App\Http\Controllers\APIs\Student\MainCourse\BookingController@showBooking');
        Route::patch('my/course/bookings/{bookingID}','App\Http\Controllers\APIs\Student\MainCourse\BookingController@updateBooking');
        Route::any('my/course/bookings/{bookingID}/esewa-success','App\Http\Controllers\APIs\Student\MainCourse\BookingController@esewaSuccess');
        Route::post('my/course/bookings/{bookingID}/khalti-success','App\Http\Controllers\APIs\Student\MainCourse\BookingController@khaltiSuccess');
        Route::any('my/course/bookings/{bookingID}/payment-failed','App\Http\Controllers\APIs\Student\MainCourse\BookingController@paymentFailed');
        
        //student main course classroom section
        Route::get('my/course/classroom','App\Http\Controllers\APIs\Student\MainCourse\ClassroomController@index');

        Route::get('my/course/classroom/{id}/units','App\Http\Controllers\APIs\Student\MainCourse\ClassroomController@unitList');
        Route::get('my/course/classroom/{id}/units/{uid}','App\Http\Controllers\APIs\Student\MainCourse\ClassroomController@unitDetail');

        Route::get('my/course/classroom/{id}/chat','App\Http\Controllers\APIs\Student\MainCourse\ChatController@index');
        Route::post('my/course/classroom/{id}/chat','App\Http\Controllers\APIs\Student\MainCourse\ChatController@store');

        Route::get('my/course/classroom/{id}/files','App\Http\Controllers\APIs\Student\MainCourse\FileController@index');
        Route::get('my/course/classroom/{id}/files/{fileID}','App\Http\Controllers\APIs\Student\MainCourse\FileController@show');

        Route::get('my/course/classroom/{id}/videos','App\Http\Controllers\APIs\Student\MainCourse\VideoController@index');
        Route::get('my/course/classroom/{id}/videos/{videoID}','App\Http\Controllers\APIs\Student\MainCourse\VideoController@show');

        Route::get('my/course/classroom/{id}/schedules','App\Http\Controllers\APIs\Student\MainCourse\ClassroomController@schedules');

        Route::get('my/course/classroom/{id}/cqc','App\Http\Controllers\APIs\Student\MainCourse\CQCController@index');
        Route::post('my/course/classroom/{id}/cqc','App\Http\Controllers\APIs\Student\MainCourse\CQCController@store');

        Route::get('my/course/classroom/{id}/assignments','App\Http\Controllers\APIs\Student\MainCourse\AssignmentController@index');
        Route::get('my/course/classroom/{id}/assignments/{assignID}/show','App\Http\Controllers\APIs\Student\MainCourse\AssignmentController@show');
        Route::get('my/course/classroom/{id}/assignments/{assignID}/view','App\Http\Controllers\APIs\Student\MainCourse\AssignmentController@view');
        Route::post('my/course/classroom/{id}/assignments/{assignID}/solve','App\Http\Controllers\APIs\Student\MainCourse\AssignmentController@solve');

        Route::get('my/course/classroom/{batchID}/mcq-exams','App\Http\Controllers\APIs\Student\MainCourse\MCQExamController@index');
        Route::get('my/course/classroom/{batchID}/mcq-exams/{examID}/attempt','App\Http\Controllers\APIs\Student\MainCourse\MCQExamController@attempt');
        Route::get('my/course/classroom/{batchID}/mcq-exams/{examID}/view','App\Http\Controllers\APIs\Student\MainCourse\MCQExamController@view');
        Route::post('my/course/classroom/{batchID}/mcq-exams/{examID}/save','App\Http\Controllers\APIs\Student\MainCourse\MCQExamController@save');
        Route::delete('my/course/classroom/{batchID}/mcq-exams/{examID}/reset','App\Http\Controllers\APIs\Student\MainCourse\MCQExamController@reset');

        Route::get('my/course/classroom/{batchID}/written-exams','App\Http\Controllers\APIs\Student\MainCourse\WrittenExamController@index');
        Route::get('my/course/classroom/{batchID}/written-exams/{examID}/attempt','App\Http\Controllers\APIs\Student\MainCourse\WrittenExamController@attempt');
        Route::get('my/course/classroom/{batchID}/written-exams/{examID}/view','App\Http\Controllers\APIs\Student\MainCourse\WrittenExamController@view');
        Route::post('my/course/classroom/{batchID}/written-exams/{examID}/save','App\Http\Controllers\APIs\Student\MainCourse\WrittenExamController@save');

        Route::get('my/course/messenger-groups','App\Http\Controllers\APIs\Student\DashboardController@messengerGroups');

        // student ebooks booking api section
        Route::get('my/ebooks/bookings/all','App\Http\Controllers\APIs\Student\Ebook\BookingController@allBookings');
        Route::get('my/ebooks/bookings/verified','App\Http\Controllers\APIs\Student\Ebook\BookingController@verifiedBookings');
        Route::get('my/ebooks/bookings/unverified','App\Http\Controllers\APIs\Student\Ebook\BookingController@unverifiedBookings');
        Route::post('my/ebooks/bookings','App\Http\Controllers\APIs\Student\Ebook\BookingController@storeBooking');
        Route::get('my/ebooks/bookings/{bookingID}','App\Http\Controllers\APIs\Student\Ebook\BookingController@showBooking');
        Route::patch('my/ebooks/bookings/{bookingID}','App\Http\Controllers\APIs\Student\Ebook\BookingController@updateBooking');
        Route::delete('my/ebooks/bookings/{bookingID}','App\Http\Controllers\APIs\Student\Ebook\BookingController@deleteBooking');

        //student ebooks detail view section
        Route::get('my/ebooks/{bookingID}/chapters','App\Http\Controllers\APIs\Student\Ebook\ChapterController@getChapterList');
        Route::get('my/ebooks/{bookingID}/chapters/{chapterID}','App\Http\Controllers\APIs\Student\Ebook\ChapterController@getChapter');
        Route::get('my/ebooks/{bookingID}/chapters/{chapterID}/files/{fileID}','App\Http\Controllers\APIs\Student\Ebook\ChapterController@getFile');

        // student video course booking api section
        Route::get('my/video-course/bookings/all','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@allBookings');
        Route::get('my/video-course/bookings/verified','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@verifiedBookings');
        Route::get('my/video-course/bookings/unverified','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@unverifiedBookings');
        Route::post('my/video-course/bookings','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@storeBooking');
        Route::get('my/video-course/bookings/{bookingID}','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@showBooking');
        Route::patch('my/video-course/bookings/{bookingID}','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@updateBooking');
        Route::delete('my/video-course/bookings/{bookingID}','App\Http\Controllers\APIs\Student\VideoCourse\BookingController@deleteBooking');

        Route::get('my/video-course/{bookingID}/cqc','App\Http\Controllers\APIs\Student\VideoCourse\CQCController@index');
        Route::post('my/video-course/{bookingID}/cqc','App\Http\Controllers\APIs\Student\VideoCourse\CQCController@store');

        Route::get('my/video-course/{bookingID}/exams','App\Http\Controllers\APIs\Student\VideoCourse\ExamController@index');
        Route::get('my/video-course/{bookingID}/exams/{examID}/attempt','App\Http\Controllers\APIs\Student\VideoCourse\ExamController@attemptExam');
        Route::get('my/video-course/{bookingID}/exams/{examID}/view','App\Http\Controllers\APIs\Student\VideoCourse\ExamController@viewExam');
        Route::post('my/video-course/{bookingID}/exams/{examID}/save','App\Http\Controllers\APIs\Student\VideoCourse\ExamController@saveExam');
        Route::delete('my/video-course/{bookingID}/exams/{examID}/reset','App\Http\Controllers\APIs\Student\VideoCourse\ExamController@resetExam');

        Route::get('my/video-course/{bookingID}/chapters','App\Http\Controllers\APIs\Student\VideoCourse\VideoController@chapterList');
        Route::get('my/video-course/{bookingID}/chapters/{chapterID}','App\Http\Controllers\APIs\Student\VideoCourse\VideoController@videoList');
        Route::get('my/video-course/{bookingID}/chapters/{chapterID}/videos/{videoID}','App\Http\Controllers\APIs\Student\VideoCourse\VideoController@getVideo');

        
        // student exam hall booking api section
        Route::get('my/examhall/bookings/all','App\Http\Controllers\APIs\Student\ExamHall\BookingController@allBookings');
        Route::get('my/examhall/bookings/verified','App\Http\Controllers\APIs\Student\ExamHall\BookingController@verifiedBookings');
        Route::get('my/examhall/bookings/unverified','App\Http\Controllers\APIs\Student\ExamHall\BookingController@unverifiedBookings');
        Route::post('my/examhall/bookings','App\Http\Controllers\APIs\Student\ExamHall\BookingController@storeBooking');
        Route::get('my/examhall/bookings/{bookingID}','App\Http\Controllers\APIs\Student\ExamHall\BookingController@showBooking');
        Route::patch('my/examhall/bookings/{bookingID}','App\Http\Controllers\APIs\Student\ExamHall\BookingController@updateBooking');
        Route::delete('my/examhall/bookings/{bookingID}','App\Http\Controllers\APIs\Student\ExamHall\BookingController@deleteBooking');

        Route::get('my/examhall/{bookingID}/cqc','App\Http\Controllers\APIs\Student\ExamHall\CQCController@index');
        Route::post('my/examhall/{bookingID}/cqc','App\Http\Controllers\APIs\Student\ExamHall\CQCController@store');

        Route::get('my/examhall/{bookingID}/exams','App\Http\Controllers\APIs\Student\ExamHall\ExamController@index');
        Route::get('my/examhall/{bookingID}/exams/{examID}/attempt','App\Http\Controllers\APIs\Student\ExamHall\ExamController@attemptExam');
        Route::get('my/examhall/{bookingID}/exams/{examID}/view','App\Http\Controllers\APIs\Student\ExamHall\ExamController@viewExam');
        Route::post('my/examhall/{bookingID}/exams/{examID}/save','App\Http\Controllers\APIs\Student\ExamHall\ExamController@saveExam');
        Route::delete('my/examhall/{bookingID}/exams/{examID}/reset','App\Http\Controllers\APIs\Student\ExamHall\ExamController@resetExam');






        Route::fallback(function () {
            return response()->json(['error' => 'Not Found!'], 404);
        });
    }
);