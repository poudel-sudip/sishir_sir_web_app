<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/uploads', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/artisancalls', function () {
    // Artisan::call('storage:link');
    // Artisan::call('migrate:fresh');
    // Artisan::call('db:seed');
    echo '403 | Permission Denied';
});








/*-------------------------------special routes section---------------------------*/

Auth::routes();
Route::get('/register-tutor','App\Http\Controllers\Auth\RegisterController@showTutorRegForm')->name('register.tutor');
Route::post('/register-tutor','App\Http\Controllers\Auth\RegisterController@registerTutor');
Route::get('/register-vendor','App\Http\Controllers\Auth\RegisterController@showVendorRegForm')->name('register.vendor');
Route::post('/register-vendor','App\Http\Controllers\Auth\RegisterController@registerVendor');

Route::get('/', 'App\Http\Controllers\FrontController@index');

Route::get('change-password', 'App\Http\Controllers\Auth\ChangePasswordController@index');
Route::post('change-password', 'App\Http\Controllers\Auth\ChangePasswordController@store')->name('change.password');

Route::get('/profile', 'App\Http\Controllers\profile\ProfileController@index');
Route::get('/profile/edit', 'App\Http\Controllers\profile\ProfileController@edit');
Route::patch('/profile', 'App\Http\Controllers\profile\ProfileController@update');
Route::get('/profile/professionaledit', 'App\Http\Controllers\profile\ProfileController@professionaledit');
Route::patch('/profile/professional', 'App\Http\Controllers\profile\ProfileController@professionalupdate');









/*-------------------------------all admin section routes---------------------------*/

//final routes for admin section
Route::get('/admin/home', 'App\Http\Controllers\admin\AdminHomeController@index')->middleware('role:Admin');

Route::get('/admin/categories', 'App\Http\Controllers\admin\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/categories/create', 'App\Http\Controllers\admin\CategoryController@create')->middleware('role:Admin');
Route::get('/admin/categories/{category}/edit', 'App\Http\Controllers\admin\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/categories/{category}', 'App\Http\Controllers\admin\CategoryController@update')->middleware('role:Admin');
Route::post('/admin/categories','App\Http\Controllers\admin\CategoryController@store')->middleware('role:Admin');
Route::delete('/admin/categories/{categories}','App\Http\Controllers\admin\CategoryController@destroy')->middleware('role:Admin');

Route::get('/admin/batches', 'App\Http\Controllers\admin\BatchController@index')->middleware('role:Admin');
Route::get('/admin/batches/create', 'App\Http\Controllers\admin\BatchController@create')->middleware('role:Admin');
Route::post('/admin/batches','App\Http\Controllers\admin\BatchController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}','App\Http\Controllers\admin\BatchController@show')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/edit', 'App\Http\Controllers\admin\BatchController@edit')->middleware('role:Admin');
Route::patch('/admin/batches/{batch}','App\Http\Controllers\admin\BatchController@update')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}','App\Http\Controllers\admin\BatchController@destroy')->middleware('role:Admin');

Route::get('/admin/batches/{batch}/bookings','App\Http\Controllers\admin\BatchBookingsController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/bookings/{booking}/edit','App\Http\Controllers\admin\BatchBookingsController@edit')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\admin\BatchBookingsController@show')->middleware('role:Admin');
Route::patch('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\admin\BatchBookingsController@update')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\admin\BatchBookingsController@destroy')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/Verified','App\Http\Controllers\admin\BatchBookingsController@verifiedstatus')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/Unverified','App\Http\Controllers\admin\BatchBookingsController@unverifiedstatus')->middleware('role:Admin');

Route::get('/admin/courses','App\Http\Controllers\admin\CoursesController@index')->middleware('role:Admin');
Route::get('/admin/courses/create','App\Http\Controllers\admin\CoursesController@create')->middleware('role:Admin');
Route::get('/admin/courses/{course}','App\Http\Controllers\admin\CoursesController@show')->middleware('role:Admin');
Route::get('/admin/courses/{course}/edit','App\Http\Controllers\admin\CoursesController@edit')->middleware('role:Admin');
Route::post('/admin/courses','App\Http\Controllers\admin\CoursesController@store')->middleware('role:Admin');
Route::patch('/admin/courses/{course}','App\Http\Controllers\admin\CoursesController@update')->middleware('role:Admin');
Route::delete('/admin/courses/{course}','App\Http\Controllers\admin\CoursesController@destroy')->middleware('role:Admin');

Route::get('/admin/courses/{course}/batches','App\Http\Controllers\admin\CourseBatchesController@index')->middleware('role:Admin');
Route::get('/admin/courses/{course}/batchnames','App\Http\Controllers\admin\CourseBatchesController@display');
Route::get('/admin/tutors/{tutor}/special-courses','App\Http\Controllers\admin\CourseBatchesController@tutorCourse');

Route::get('/admin/courses/{course}/features','App\Http\Controllers\admin\CourseFeaturesController@index')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/create','App\Http\Controllers\admin\CourseFeaturesController@create')->middleware('role:Admin');
Route::post('/admin/courses/{course}/features','App\Http\Controllers\admin\CourseFeaturesController@store')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/{feature}','App\Http\Controllers\admin\CourseFeaturesController@show')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/{feature}/edit','App\Http\Controllers\admin\CourseFeaturesController@edit')->middleware('role:Admin');
Route::patch('/admin/courses/{course}/features/{feature}','App\Http\Controllers\admin\CourseFeaturesController@update')->middleware('role:Admin');
Route::delete('/admin/courses/{course}/features/{feature}','App\Http\Controllers\admin\CourseFeaturesController@destroy')->middleware('role:Admin');

Route::get('/admin/users','App\Http\Controllers\admin\UsersController@index')->middleware('role:Admin');
Route::get('/admin/users/create','App\Http\Controllers\admin\UsersController@create')->middleware('role:Admin');
Route::post('/admin/users','App\Http\Controllers\admin\UsersController@store')->middleware('role:Admin');
Route::get('/admin/users/{user}','App\Http\Controllers\admin\UsersController@show')->middleware('role:Admin');
Route::get('/admin/users/{user}/edit','App\Http\Controllers\admin\UsersController@edit')->middleware('role:Admin');
Route::patch('/admin/users/{user}','App\Http\Controllers\admin\UsersController@update')->middleware('role:Admin');
Route::delete('/admin/users/{user}','App\Http\Controllers\admin\UsersController@destroy')->middleware('role:Admin');

Route::get('/admin/bookings','App\Http\Controllers\admin\BookingsController@index')->middleware('role:Admin');
Route::get('/admin/bookings/all','App\Http\Controllers\admin\BookingsController@allBookings')->middleware('role:Admin');
Route::get('/admin/bookings/create','App\Http\Controllers\admin\BookingsController@create')->middleware('role:Admin');
Route::get('/admin/bookings/verifylist','App\Http\Controllers\admin\BookingsController@verifylist')->middleware('role:Admin');
Route::get('/admin/bookings/duelist','App\Http\Controllers\admin\BookingsController@duelist')->middleware('role:Admin');
Route::get('/admin/bookings/unverifiedlist','App\Http\Controllers\admin\BookingsController@unverifiedlist')->middleware('role:Admin');
Route::get('/admin/bookings/suspendedlist','App\Http\Controllers\admin\BookingsController@suspendedlist')->middleware('role:Admin');
Route::post('/admin/bookings','App\Http\Controllers\admin\BookingsController@store')->middleware('role:Admin');
Route::get('/admin/bookings/{booking}','App\Http\Controllers\admin\BookingsController@show')->middleware('role:Admin');
Route::get('/admin/bookings/{booking}/edit','App\Http\Controllers\admin\BookingsController@edit')->middleware('role:Admin');
Route::patch('/admin/bookings/{booking}','App\Http\Controllers\admin\BookingsController@update')->middleware('role:Admin');
Route::delete('/admin/bookings/{booking}','App\Http\Controllers\admin\BookingsController@destroy')->middleware('role:Admin');

Route::get('/admin/sliders','App\Http\Controllers\admin\SliderController@index')->middleware('role:Admin');
Route::get('/admin/sliders/create','App\Http\Controllers\admin\SliderController@create')->middleware('role:Admin');
Route::post('/admin/sliders','App\Http\Controllers\admin\SliderController@store')->middleware('role:Admin');
Route::get('/admin/sliders/{slider}/edit','App\Http\Controllers\admin\SliderController@edit')->middleware('role:Admin');
Route::patch('/admin/sliders/{slider}','App\Http\Controllers\admin\SliderController@update')->middleware('role:Admin');
Route::delete('/admin/sliders/{slider}','App\Http\Controllers\admin\SliderController@destroy')->middleware('role:Admin');

Route::get('/admin/testimonials','App\Http\Controllers\admin\TestimonialController@index')->middleware('role:Admin');
Route::get('/admin/testimonials/create','App\Http\Controllers\admin\TestimonialController@create')->middleware('role:Admin');
Route::post('/admin/testimonials','App\Http\Controllers\admin\TestimonialController@store')->middleware('role:Admin');
Route::get('/admin/testimonials/{testimonial}/edit','App\Http\Controllers\admin\TestimonialController@edit')->middleware('role:Admin');
Route::patch('/admin/testimonials/{testimonial}','App\Http\Controllers\admin\TestimonialController@update')->middleware('role:Admin');
Route::delete('/admin/testimonials/{testimonial}','App\Http\Controllers\admin\TestimonialController@destroy')->middleware('role:Admin');

Route::get('/admin/notifications','App\Http\Controllers\admin\NotificationController@index')->middleware('role:Admin');
Route::get('/admin/notifications/create','App\Http\Controllers\admin\NotificationController@create')->middleware('role:Admin');
Route::post('/admin/notifications','App\Http\Controllers\admin\NotificationController@store')->middleware('role:Admin');
Route::get('/admin/notifications/{notification}','App\Http\Controllers\admin\NotificationController@show')->middleware('role:Admin');
Route::get('/admin/notifications/{notification}/edit','App\Http\Controllers\admin\NotificationController@edit')->middleware('role:Admin');
Route::patch('/admin/notifications/{notification}','App\Http\Controllers\admin\NotificationController@update')->middleware('role:Admin');
Route::delete('/admin/notifications/{notification}','App\Http\Controllers\admin\NotificationController@destroy')->middleware('role:Admin');

Route::get('/admin/videos','App\Http\Controllers\admin\VideoController@index')->middleware('role:Admin');
Route::get('/admin/videos/upload','App\Http\Controllers\admin\VideoController@upload')->middleware('role:Admin');
Route::post('/admin/videos','App\Http\Controllers\admin\VideoController@store')->middleware('role:Admin');
Route::delete('/admin/videos/{video}','App\Http\Controllers\admin\VideoController@destroy')->middleware('role:Admin');

Route::get('/admin/reports','App\Http\Controllers\admin\Report\ReportController@index')->middleware('role:Admin');

Route::get('/admin/reports/course','App\Http\Controllers\admin\Report\CourseReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/course/all','App\Http\Controllers\admin\Report\CourseReportController@courseReport')->middleware('role:Admin');
Route::get('/admin/reports/course/all/export','App\Http\Controllers\admin\Report\CourseReportController@exportCategoryCourses')->middleware('role:Admin');
Route::get('/admin/reports/course/{course}','App\Http\Controllers\admin\Report\CourseReportController@courseBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/course/{course}/export','App\Http\Controllers\admin\Report\CourseReportController@exportCourseBatches')->middleware('role:Admin');

Route::get('/admin/reports/batch','App\Http\Controllers\admin\Report\BatchReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/all','App\Http\Controllers\admin\Report\BatchReportController@batchReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/all/export','App\Http\Controllers\admin\Report\BatchReportController@exportBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/pending','App\Http\Controllers\admin\Report\BatchReportController@batchPendingReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/pending/export','App\Http\Controllers\admin\Report\BatchReportController@exportBatchPendingReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/verified','App\Http\Controllers\admin\Report\BatchReportController@batchVerifiedReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/verified/export','App\Http\Controllers\admin\Report\BatchReportController@exportBatchVerifiedReport')->middleware('role:Admin');

Route::get('/admin/reports/user','App\Http\Controllers\admin\Report\UserReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/user/all','App\Http\Controllers\admin\Report\UserReportController@userReport')->middleware('role:Admin');
Route::get('/admin/reports/user/all/export','App\Http\Controllers\admin\Report\UserReportController@exportUsers')->middleware('role:Admin');

Route::post('/admin/reports/user/filterbydate','App\Http\Controllers\admin\Report\UserReportController@filterUsersDate')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbydistrict','App\Http\Controllers\admin\Report\UserReportController@filterUsersDistrict')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbyprovience','App\Http\Controllers\admin\Report\UserReportController@filterUsersProvience')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbycourse','App\Http\Controllers\admin\Report\UserReportController@filterUsersCourse')->middleware('role:Admin');
Route::get('/admin/reports/user/filter/{key}/{value}/download','App\Http\Controllers\admin\Report\UserReportController@filteredUsersDownload')->middleware('role:Admin');


Route::get('/admin/reports/tutor','App\Http\Controllers\admin\Report\TutorReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/tutor/all','App\Http\Controllers\admin\Report\TutorReportController@tutorReport')->middleware('role:Admin');
Route::get('/admin/reports/tutor/all/export','App\Http\Controllers\admin\Report\TutorReportController@exportTutors')->middleware('role:Admin');
Route::get('/admin/reports/tutor/{tutor}/batches','App\Http\Controllers\admin\Report\TutorReportController@tutorBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/tutor/{tutor}/batches/export','App\Http\Controllers\admin\Report\TutorReportController@exportTutorBatches')->middleware('role:Admin');

Route::get('/admin/reports/booking','App\Http\Controllers\admin\Report\BookingReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/booking/all','App\Http\Controllers\admin\Report\BookingReportController@bookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/all/export','App\Http\Controllers\admin\Report\BookingReportController@exportBookings')->middleware('role:Admin');
Route::post('/admin/reports/booking/daily','App\Http\Controllers\admin\Report\BookingReportController@dailyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/daily/{date}/export','App\Http\Controllers\admin\Report\BookingReportController@dailyBookingsExport')->middleware('role:Admin');
Route::post('/admin/reports/booking/monthly','App\Http\Controllers\admin\Report\BookingReportController@monthlyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/monthly/{date}/export','App\Http\Controllers\admin\Report\BookingReportController@monthlyBookingsExport')->middleware('role:Admin');
Route::post('/admin/reports/booking/yearly','App\Http\Controllers\admin\Report\BookingReportController@yearlyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/yearly/{date}/export','App\Http\Controllers\admin\Report\BookingReportController@YearlyBookingsExport')->middleware('role:Admin');

Route::get('/admin/followup','App\Http\Controllers\admin\FollowupController@index')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/all','App\Http\Controllers\admin\FollowupController@followupAll')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/batch','App\Http\Controllers\admin\FollowupController@followupBatch')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/followed','App\Http\Controllers\admin\FollowupController@followupFollowed')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/all/download','App\Http\Controllers\admin\FollowupController@downloadFollowupAll')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/batch/download','App\Http\Controllers\admin\FollowupController@downloadFollowupBatch')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/followed/download','App\Http\Controllers\admin\FollowupController@downloadFollowupFollowed')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/{user}/followup','App\Http\Controllers\admin\FollowupController@edit')->middleware('role:Admin');
Route::patch('/admin/batch/{batch}/{user}/followup','App\Http\Controllers\admin\FollowupController@update')->middleware('role:Admin');

//admin manual bookings
Route::get('/admin/manual-booking','App\Http\Controllers\ManualBookingController@index')->middleware('role:Admin');
Route::get('/admin/manual-booking/{mbooking}/edit','App\Http\Controllers\ManualBookingController@edit')->middleware('role:Admin');
Route::patch('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@update')->middleware('role:Admin');
Route::delete('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@destroy')->middleware('role:Admin');
Route::get('/admin/manual-booking/{id}','App\Http\Controllers\ManualBookingController@view')->middleware('role:Admin');

// admin tutors routes
Route::get('/admin/tutors', 'App\Http\Controllers\admin\tutors\TutorController@index')->middleware('role:Admin');
Route::get('/admin/tutors/create', 'App\Http\Controllers\admin\tutors\TutorController@create')->middleware('role:Admin');
Route::post('/admin/tutors', 'App\Http\Controllers\admin\tutors\TutorController@store')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}', 'App\Http\Controllers\admin\tutors\TutorController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/edit', 'App\Http\Controllers\admin\tutors\TutorController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}', 'App\Http\Controllers\admin\tutors\TutorController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}', 'App\Http\Controllers\admin\tutors\TutorController@destroy')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/reviews', 'App\Http\Controllers\admin\tutors\TutorController@getReviews')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
Route::put('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/review/{review}/delete','App\Http\Controllers\admin\tutors\TutorController@destroyReview')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses', 'App\Http\Controllers\admin\tutors\TutorCourseController@index')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\admin\tutors\TutorCourseController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/edit', 'App\Http\Controllers\admin\tutors\TutorCourseController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\admin\tutors\TutorCourseController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\admin\tutors\TutorCourseController@destroy')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses/{course}/bookings', 'App\Http\Controllers\admin\tutors\TutorCourseBookingController@index')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\admin\tutors\TutorCourseBookingController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}/edit', 'App\Http\Controllers\admin\tutors\TutorCourseBookingController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\admin\tutors\TutorCourseBookingController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\admin\tutors\TutorCourseBookingController@destroy')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses/{course}/payments', 'App\Http\Controllers\admin\tutors\TutorPaymentController@index')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}/payments/{pay}', 'App\Http\Controllers\admin\tutors\TutorPaymentController@update')->middleware('role:Admin');

//blogs managing by admin
Route::get('/admin/blogs','App\Http\Controllers\admin\Blog\BlogController@index')->middleware('role:Admin');
Route::get('/admin/blogs/create','App\Http\Controllers\admin\Blog\BlogController@create')->middleware('role:Admin');
Route::post('/admin/blogs','App\Http\Controllers\admin\Blog\BlogController@store')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}','App\Http\Controllers\admin\Blog\BlogController@show')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/edit','App\Http\Controllers\admin\Blog\BlogController@edit')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}','App\Http\Controllers\admin\Blog\BlogController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}','App\Http\Controllers\admin\Blog\BlogController@destroy')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/comments','App\Http\Controllers\admin\Blog\CommentController@index')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}/comment/{comment}/{status}','App\Http\Controllers\admin\Blog\CommentController@update')->middleware('role:Admin');
Route::put('/admin/blogs/{blog}/comment/{comment}/{status}','App\Http\Controllers\admin\Blog\CommentController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}/comment/{comment}/delete','App\Http\Controllers\admin\Blog\CommentController@destroy')->middleware('role:Admin');

// admin leads and enquiries
Route::get('/leads/enquiries','App\Http\Controllers\Leads\EnquiryController@index')->middleware('role:Admin');
Route::post('/leads/enquiries/add','App\Http\Controllers\Leads\EnquiryController@store');
Route::get('/leads/enquiries/filter','App\Http\Controllers\Leads\EnquiryController@filterFormShow')->middleware('role:Admin');
Route::post('/leads/enquiries/filter','App\Http\Controllers\Leads\EnquiryController@filterResults')->middleware('role:Admin');
Route::get('/leads/enquiries/{enquiry}/edit','App\Http\Controllers\Leads\EnquiryController@edit')->middleware('role:Admin');
Route::patch('/leads/enquiries/{enquiry}','App\Http\Controllers\Leads\EnquiryController@update')->middleware('role:Admin');
Route::delete('/leads/enquiries/{enquiry}','App\Http\Controllers\Leads\EnquiryController@destroy')->middleware('role:Admin');


Route::get('/admin/enquiry-form','App\Http\Controllers\Leads\EnquiryController@getEnquiryFormList')->middleware('role:Admin');
Route::post('/admin/enquiry-form','App\Http\Controllers\Leads\EnquiryController@saveEnquiryForm')->middleware('role:Admin');
Route::delete('/admin/enquiry-form/{form}','App\Http\Controllers\Leads\EnquiryController@deleteEnquiryForm')->middleware('role:Admin');


//admin free videos
Route::get('/admin/free-videos','App\Http\Controllers\admin\FreeVideoController@index')->middleware('role:Admin');
Route::get('/admin/free-videos/create','App\Http\Controllers\admin\FreeVideoController@create')->middleware('role:Admin');
Route::post('/admin/free-videos','App\Http\Controllers\admin\FreeVideoController@store')->middleware('role:Admin');
Route::delete('/admin/free-videos/{video}','App\Http\Controllers\admin\FreeVideoController@destroy')->middleware('role:Admin');

//admin zoom meetings management
Route::get('/admin/zoom/meetings','App\Http\Controllers\Zoom\MeetingController@list')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/create','App\Http\Controllers\Zoom\MeetingController@add')->middleware('role:Admin');
Route::post('/admin/zoom/meetings','App\Http\Controllers\Zoom\MeetingController@create')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@get')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/{id}/edit','App\Http\Controllers\Zoom\MeetingController@edit')->middleware('role:Admin');
Route::patch('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@update')->middleware('role:Admin');
Route::delete('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@delete')->middleware('role:Admin');

//admin exam mgmt
Route::get('/admin/exams','App\Http\Controllers\admin\Exams\ExamController@index')->middleware('role:Admin');
Route::get('/admin/exams/create','App\Http\Controllers\admin\Exams\ExamController@create')->middleware('role:Admin');
Route::post('/admin/exams','App\Http\Controllers\admin\Exams\ExamController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}','App\Http\Controllers\admin\Exams\ExamController@show')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/edit','App\Http\Controllers\admin\Exams\ExamController@edit')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}','App\Http\Controllers\admin\Exams\ExamController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}','App\Http\Controllers\admin\Exams\ExamController@destroy')->middleware('role:Admin');

//admin exam category
Route::get('/admin/exam-category','App\Http\Controllers\admin\Exams\ExamCategoryController@index')->middleware('role:Admin');
Route::get('/admin/exam-category/create','App\Http\Controllers\admin\Exams\ExamCategoryController@create')->middleware('role:Admin');
Route::post('/admin/exam-category','App\Http\Controllers\admin\Exams\ExamCategoryController@store')->middleware('role:Admin');
Route::delete('/admin/exam-category/{category}','App\Http\Controllers\admin\Exams\ExamCategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/exams','App\Http\Controllers\admin\Exams\ExamCategoryController@exams')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/getexams','App\Http\Controllers\admin\Exams\ExamCategoryController@catExams')->middleware('role:Admin');

// admin exam questions
Route::get('/admin/exams/{exam}/questions','App\Http\Controllers\admin\Exams\QuestionController@index')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/create','App\Http\Controllers\admin\Exams\QuestionController@create')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/upload','App\Http\Controllers\admin\Exams\QuestionController@upload')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions/import','App\Http\Controllers\admin\Exams\QuestionController@import')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions','App\Http\Controllers\admin\Exams\QuestionController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}/edit','App\Http\Controllers\admin\Exams\QuestionController@edit')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}/questions/{question}','App\Http\Controllers\admin\Exams\QuestionController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}/questions/{question}','App\Http\Controllers\admin\Exams\QuestionController@destroy')->middleware('role:Admin');

//mcq exams associated with batch admin
Route::get('/admin/batches/{batch}/exams','App\Http\Controllers\admin\Exams\BatchExamController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/create','App\Http\Controllers\admin\Exams\BatchExamController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/exams','App\Http\Controllers\admin\Exams\BatchExamController@store')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/exams/{exam}','App\Http\Controllers\admin\Exams\BatchExamController@destroy')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/{exam}/results','App\Http\Controllers\admin\Exams\BatchExamController@results')->middleware('role:Admin');

//assignment admin mgmt
Route::get('/admin/batches/{batch}/assignments','App\Http\Controllers\admin\AssignmentController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/create','App\Http\Controllers\admin\AssignmentController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/assignments','App\Http\Controllers\admin\AssignmentController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/{assignment}/answers','App\Http\Controllers\admin\AssignmentController@answers')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/{assignment}/answers/{answer}','App\Http\Controllers\admin\AssignmentController@answerview')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/assignments/{assignment}/answers/{answer}','App\Http\Controllers\admin\AssignmentController@remarks')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/assignments/{assignment}','App\Http\Controllers\admin\AssignmentController@destroy')->middleware('role:Admin');


//written exams admin
Route::get('/admin/batches/{batch}/written-exams','App\Http\Controllers\admin\Exams\WrittenExamController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/create','App\Http\Controllers\admin\Exams\WrittenExamController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/written-exams','App\Http\Controllers\admin\Exams\WrittenExamController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/{exam}/solutions','App\Http\Controllers\admin\Exams\WrittenExamController@solutions')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/{exam}/solutions/{solution}','App\Http\Controllers\admin\Exams\WrittenExamController@solutionview')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/written-exams/{exam}/solutions/{solution}','App\Http\Controllers\admin\Exams\WrittenExamController@remarks')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/written-exams/{exam}','App\Http\Controllers\admin\Exams\WrittenExamController@destroy')->middleware('role:Admin');

//schedules admin
Route::get('/admin/batches/{batch}/schedules','App\Http\Controllers\classroom\ScheduleController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/schedules/create','App\Http\Controllers\classroom\ScheduleController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/schedules','App\Http\Controllers\classroom\ScheduleController@store')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/schedules/{schedule}','App\Http\Controllers\classroom\ScheduleController@destroy')->middleware('role:Admin');

//classroom units admin
Route::get('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@index')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@store')->middleware('role:Admin');
Route::patch('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@update')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/units/{unit}','App\Http\Controllers\classroom\UnitController@destroy')->middleware('role:Admin');


//open mcq exams admin
Route::get('/admin/open-exams','App\Http\Controllers\admin\OpenExams\ExamController@index')->middleware('role:Admin');
Route::get('/admin/open-exams/create','App\Http\Controllers\admin\OpenExams\ExamController@create')->middleware('role:Admin');
Route::post('/admin/open-exams','App\Http\Controllers\admin\OpenExams\ExamController@store')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}','App\Http\Controllers\admin\OpenExams\ExamController@show')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/edit','App\Http\Controllers\admin\OpenExams\ExamController@edit')->middleware('role:Admin');
Route::patch('/admin/open-exams/{exam}','App\Http\Controllers\admin\OpenExams\ExamController@update')->middleware('role:Admin');
Route::delete('/admin/open-exams/{exam}','App\Http\Controllers\admin\OpenExams\ExamController@destroy')->middleware('role:Admin');

//open mcq exams results admin
Route::get('/admin/open-exams/{exam}/results','App\Http\Controllers\admin\OpenExams\ExamController@results')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/results/export','App\Http\Controllers\admin\OpenExams\ExamController@export')->middleware('role:Admin');

//syllabus management admin
Route::resource('/admin/syllabus', App\Http\Controllers\admin\SyllabusController::class)->middleware('role:Admin');
Route::get('/admin/syllabus/{id}/delete', [App\Http\Controllers\admin\SyllabusController::class,'destroy']);

//study Materials management admin
Route::resource('/admin/studyMaterials', App\Http\Controllers\admin\StudyMaterialController::class)->middleware('role:Admin');
Route::get('/admin/studyMaterials/{id}/delete', [App\Http\Controllers\admin\StudyMaterialController::class,'destroy']);


//admin accounts mgmt
Route::get('/admin/accounts/incomes','App\Http\Controllers\admin\Accounts\IncomeController@index')->middleware('role:Admin');
Route::get('/admin/accounts/incomes/courses/add','App\Http\Controllers\admin\Accounts\IncomeController@addCourseIncome')->middleware('role:Admin');
Route::get('/admin/accounts/incomes/others/add','App\Http\Controllers\admin\Accounts\IncomeController@addOtherIncome')->middleware('role:Admin');
Route::post('/admin/accounts/incomes/courses','App\Http\Controllers\admin\Accounts\IncomeController@storeCourseIncome')->middleware('role:Admin');
Route::post('/admin/accounts/incomes/others','App\Http\Controllers\admin\Accounts\IncomeController@storeOtherIncome')->middleware('role:Admin');
Route::delete('/admin/accounts/incomes/{income}','App\Http\Controllers\admin\Accounts\IncomeController@destroy')->middleware('role:Admin');

Route::get('/admin/accounts/expenses','App\Http\Controllers\admin\Accounts\ExpenseController@index')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/tutor','App\Http\Controllers\admin\Accounts\ExpenseController@addTutorSalary')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/tutor','App\Http\Controllers\admin\Accounts\ExpenseController@storeTutorSalary')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/staff','App\Http\Controllers\admin\Accounts\ExpenseController@addStaffSalary')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/staff','App\Http\Controllers\admin\Accounts\ExpenseController@storeStaffSalary')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/refund','App\Http\Controllers\admin\Accounts\ExpenseController@addRefund')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/refund','App\Http\Controllers\admin\Accounts\ExpenseController@storeRefund')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/others','App\Http\Controllers\admin\Accounts\ExpenseController@addOtherExpenses')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/others','App\Http\Controllers\admin\Accounts\ExpenseController@storeOtherExpenses')->middleware('role:Admin');
Route::delete('/admin/accounts/expenses/{expense}','App\Http\Controllers\admin\Accounts\ExpenseController@destroy')->middleware('role:Admin');

Route::get('/admin/accounts/reports','App\Http\Controllers\admin\Accounts\ReportController@index')->middleware('role:Admin');

Route::get('/admin/accounts/reports/incomes','App\Http\Controllers\admin\Accounts\IncomeReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/course','App\Http\Controllers\admin\Accounts\IncomeReportController@courseIncomeReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/incomes/others','App\Http\Controllers\admin\Accounts\IncomeReportController@otherIncomeReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/daily','App\Http\Controllers\admin\Accounts\IncomeReportController@dailyIncomeReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/monthly','App\Http\Controllers\admin\Accounts\IncomeReportController@monthlyIncomeReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/incomes/deleted','App\Http\Controllers\admin\Accounts\IncomeReportController@deletedIncomeReport')->middleware('role:Admin');
Route::patch('/admin/accounts/reports/incomes/deleted/{income}','App\Http\Controllers\admin\Accounts\IncomeReportController@restoreIncomeReport')->middleware('role:Admin');

Route::get('/admin/accounts/reports/expenses','App\Http\Controllers\admin\Accounts\ExpenseReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/tutor','App\Http\Controllers\admin\Accounts\ExpenseReportController@tutorExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/course','App\Http\Controllers\admin\Accounts\ExpenseReportController@courseExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/staff','App\Http\Controllers\admin\Accounts\ExpenseReportController@staffExpenseReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/expenses/others','App\Http\Controllers\admin\Accounts\ExpenseReportController@otherExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/daily','App\Http\Controllers\admin\Accounts\ExpenseReportController@dailyExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/monthly','App\Http\Controllers\admin\Accounts\ExpenseReportController@monthlyExpenseReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/expenses/deleted','App\Http\Controllers\admin\Accounts\ExpenseReportController@deletedExpenseReport')->middleware('role:Admin');
Route::patch('/admin/accounts/reports/expenses/deleted/{expense}','App\Http\Controllers\admin\Accounts\ExpenseReportController@restoreExpenseReport')->middleware('role:Admin');

Route::get('/admin/accounts/reports/gross','App\Http\Controllers\admin\Accounts\GrossReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/course','App\Http\Controllers\admin\Accounts\GrossReportController@courseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/daily','App\Http\Controllers\admin\Accounts\GrossReportController@dailyReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/monthly','App\Http\Controllers\admin\Accounts\GrossReportController@monthlyReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/yearly','App\Http\Controllers\admin\Accounts\GrossReportController@yearlyReport')->middleware('role:Admin');

//admin collections 
Route::get('/admin/accounts/collections','App\Http\Controllers\admin\Accounts\ReportController@collections')->middleware('role:Admin');

//routes for sms sections
Route::get('/admin/sms','App\Http\Controllers\admin\SMSController@index')->middleware('role:Admin');
Route::get('/admin/sms/create','App\Http\Controllers\admin\SMSController@create')->middleware('role:Admin');
Route::post('/admin/sms','App\Http\Controllers\admin\SMSController@store')->middleware('role:Admin');

//routes for exam hall admin section
Route::get('/admin/exam-hall','App\Http\Controllers\admin\ExamHall\ExamHallController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/create','App\Http\Controllers\admin\ExamHall\ExamHallController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall','App\Http\Controllers\admin\ExamHall\ExamHallController@store')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/edit','App\Http\Controllers\admin\ExamHall\ExamHallController@edit')->middleware('role:Admin');
Route::patch('/admin/exam-hall/{category}','App\Http\Controllers\admin\ExamHall\ExamHallController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}','App\Http\Controllers\admin\ExamHall\ExamHallController@destroy')->middleware('role:Admin');

Route::get('/admin/exam-hall/{category}/exams','App\Http\Controllers\admin\ExamHall\ExamHallExamController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/create','App\Http\Controllers\admin\ExamHall\ExamHallExamController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/exams','App\Http\Controllers\admin\ExamHall\ExamHallExamController@store')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/exams/{exam}','App\Http\Controllers\admin\ExamHall\ExamHallExamController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/{exam}/results','App\Http\Controllers\admin\ExamHall\ExamHallExamController@results')->middleware('role:Admin');

//admin section exam hall booking
Route::get('/admin/exam-hall/{category}/bookings','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/all','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/create','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall/bookings','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@store')->middleware('role:Admin');

Route::get('/admin/exam-hall/bookings/{booking}/edit','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@edit')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@show')->middleware('role:Admin');
Route::patch('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\admin\ExamHall\ExamHallBookingController@destroy')->middleware('role:Admin');

//exam hall cqc admin section
Route::get('/admin/exam-hall/{category}/cqc','App\Http\Controllers\admin\ExamHall\ExamHallController@cqcindex')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/cqc','App\Http\Controllers\admin\ExamHall\ExamHallController@cqcstore')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/cqc/{cqc}','App\Http\Controllers\admin\ExamHall\ExamHallController@cqcdestroy')->middleware('role:Admin');

//admin vendor routes
Route::get('/admin/vendor','App\Http\Controllers\admin\Vendors\VendorController@index')->middleware('role:Admin');
Route::get('/admin/vendor/create','App\Http\Controllers\admin\Vendors\VendorController@create')->middleware('role:Admin');
Route::post('/admin/vendor','App\Http\Controllers\admin\Vendors\VendorController@store')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}','App\Http\Controllers\admin\Vendors\VendorController@show')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/edit','App\Http\Controllers\admin\Vendors\VendorController@edit')->middleware('role:Admin');
Route::patch('/admin/vendor/{vendor}','App\Http\Controllers\admin\Vendors\VendorController@update')->middleware('role:Admin');
Route::delete('/admin/vendor/{vendor}','App\Http\Controllers\admin\Vendors\VendorController@destroy')->middleware('role:Admin');

//admin vendor bookings
Route::get('/admin/vendor/{vendor}/bookings/course','App\Http\Controllers\admin\Vendors\BookingController@courseBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/exam','App\Http\Controllers\admin\Vendors\BookingController@examBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/video','App\Http\Controllers\admin\Vendors\BookingController@videoBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/ebook','App\Http\Controllers\admin\Vendors\BookingController@ebookBookings')->middleware('role:Admin');

//admin vendor users
Route::get('/admin/vendor/{vendor}/students','App\Http\Controllers\admin\Vendors\VendorController@students')->middleware('role:Admin');


//admin video course categories
Route::get('/admin/video-category','App\Http\Controllers\admin\Video\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/video-category/create','App\Http\Controllers\admin\Video\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/video-category','App\Http\Controllers\admin\Video\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/video-category/{category}/edit','App\Http\Controllers\admin\Video\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/video-category/{category}','App\Http\Controllers\admin\Video\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/video-category/{category}','App\Http\Controllers\admin\Video\CategoryController@destroy')->middleware('role:Admin');

//admin video courses
Route::get('/admin/video-course','App\Http\Controllers\admin\Video\CourseController@index')->middleware('role:Admin');
Route::get('/admin/video-course/create','App\Http\Controllers\admin\Video\CourseController@create')->middleware('role:Admin');
Route::post('/admin/video-course','App\Http\Controllers\admin\Video\CourseController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}','App\Http\Controllers\admin\Video\CourseController@show')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/edit','App\Http\Controllers\admin\Video\CourseController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}','App\Http\Controllers\admin\Video\CourseController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}','App\Http\Controllers\admin\Video\CourseController@destroy')->middleware('role:Admin');

Route::get('/admin/video-course/{course}/booking','App\Http\Controllers\admin\Video\CourseController@booking')->middleware('role:Admin');

//admin video course chapters
Route::get('/admin/video-course/{course}/chapters','App\Http\Controllers\admin\Video\ChapterController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/create','App\Http\Controllers\admin\Video\ChapterController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/chapters','App\Http\Controllers\admin\Video\ChapterController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/edit','App\Http\Controllers\admin\Video\ChapterController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\admin\Video\ChapterController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\admin\Video\ChapterController@destroy')->middleware('role:Admin');

//admin video course chapters video posts
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\admin\Video\VideoController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/create','App\Http\Controllers\admin\Video\VideoController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\admin\Video\VideoController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\admin\Video\VideoController@show')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}/edit','App\Http\Controllers\admin\Video\VideoController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\admin\Video\VideoController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\admin\Video\VideoController@destroy')->middleware('role:Admin');

//admin video course bookings
Route::get('/admin/video-booking','App\Http\Controllers\admin\Video\BookingController@index')->middleware('role:Admin');
Route::get('/admin/video-booking/all','App\Http\Controllers\admin\Video\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/video-booking/create','App\Http\Controllers\admin\Video\BookingController@create')->middleware('role:Admin');
Route::post('/admin/video-booking','App\Http\Controllers\admin\Video\BookingController@store')->middleware('role:Admin');
Route::get('/admin/video-booking/{booking}','App\Http\Controllers\admin\Video\BookingController@show')->middleware('role:Admin');
Route::get('/admin/video-booking/{booking}/edit','App\Http\Controllers\admin\Video\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/video-booking/{booking}','App\Http\Controllers\admin\Video\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/video-booking/{booking}','App\Http\Controllers\admin\Video\BookingController@destroy')->middleware('role:Admin');

//admin video course mcq exams
Route::get('/admin/video-course/{course}/exams','App\Http\Controllers\admin\Video\ExamController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/exams/create','App\Http\Controllers\admin\Video\ExamController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/exams','App\Http\Controllers\admin\Video\ExamController@store')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/exams/{exam}','App\Http\Controllers\admin\Video\ExamController@destroy')->middleware('role:Admin');

// admin video course exam results
Route::get('/admin/video-course/{course}/exams/{exam}/results','App\Http\Controllers\admin\Video\ExamController@results')->middleware('role:Admin');


//admin video course cqq/cqc
Route::get('/admin/video-course/{course}/cqc','App\Http\Controllers\admin\Video\CQCController@index')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/cqc','App\Http\Controllers\admin\Video\CQCController@store')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/cqc/{cqc}','App\Http\Controllers\admin\Video\CQCController@destroy')->middleware('role:Admin');

//admin video course tutors
Route::get('/admin/video-course/{course}/tutors','App\Http\Controllers\admin\Video\TutorController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/tutors/create','App\Http\Controllers\admin\Video\TutorController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/tutors','App\Http\Controllers\admin\Video\TutorController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/tutors/{tutor}/edit','App\Http\Controllers\admin\Video\TutorController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\admin\Video\TutorController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\admin\Video\TutorController@destroy')->middleware('role:Admin');

//admin eps korean registration
Route::get('/admin/eps-registration','App\Http\Controllers\EpsKoreaController@index')->middleware('role:Admin');
Route::get('/admin/eps-registration/{korea}/edit','App\Http\Controllers\EpsKoreaController@edit')->middleware('role:Admin');
Route::patch('/admin/eps-registration/{korea}','App\Http\Controllers\EpsKoreaController@update')->middleware('role:Admin');
Route::get('/admin/eps-registration/{korea}','App\Http\Controllers\EpsKoreaController@show')->middleware('role:Admin');
Route::delete('/admin/eps-registration/{korea}','App\Http\Controllers\EpsKoreaController@destroy')->middleware('role:Admin');

//admin ebooks categories
Route::get('/admin/ebook/categories','App\Http\Controllers\admin\Ebook\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/ebook/categories/create','App\Http\Controllers\admin\Ebook\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/ebook/categories','App\Http\Controllers\admin\Ebook\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/ebook/categories/{category}/edit','App\Http\Controllers\admin\Ebook\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/categories/{category}','App\Http\Controllers\admin\Ebook\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/categories/{category}','App\Http\Controllers\admin\Ebook\CategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/ebook/categories/{category}/books','App\Http\Controllers\admin\Ebook\CategoryController@ebooks')->middleware('role:Admin');


//admin ebooks 
Route::get('/admin/ebook/books','App\Http\Controllers\admin\Ebook\BookController@index')->middleware('role:Admin');
Route::get('/admin/ebook/books/create','App\Http\Controllers\admin\Ebook\BookController@create')->middleware('role:Admin');
Route::post('/admin/ebook/books','App\Http\Controllers\admin\Ebook\BookController@store')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}','App\Http\Controllers\admin\Ebook\BookController@show')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/edit','App\Http\Controllers\admin\Ebook\BookController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/books/{book}','App\Http\Controllers\admin\Ebook\BookController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}','App\Http\Controllers\admin\Ebook\BookController@destroy')->middleware('role:Admin');

Route::get('/admin/ebook/books/{book}/bookings','App\Http\Controllers\admin\Ebook\BookController@bookings')->middleware('role:Admin');

//admin ebooks chapters
Route::get('/admin/ebook/books/{book}/chapters','App\Http\Controllers\admin\Ebook\ChapterController@index')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/create','App\Http\Controllers\admin\Ebook\ChapterController@create')->middleware('role:Admin');
Route::post('/admin/ebook/books/{book}/chapters','App\Http\Controllers\admin\Ebook\ChapterController@store')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\admin\Ebook\ChapterController@show')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/edit','App\Http\Controllers\admin\Ebook\ChapterController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\admin\Ebook\ChapterController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\admin\Ebook\ChapterController@destroy')->middleware('role:Admin');

//admin ebooks chapters files
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/files','App\Http\Controllers\admin\Ebook\ChapterController@fileindex')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/files/create','App\Http\Controllers\admin\Ebook\ChapterController@filecreate')->middleware('role:Admin');
Route::post('/admin/ebook/books/{book}/chapters/{chapter}/files','App\Http\Controllers\admin\Ebook\ChapterController@filestore')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}/chapters/{chapter}/files/{chapterfiles}','App\Http\Controllers\admin\Ebook\ChapterController@filedestroy')->middleware('role:Admin');

//admin ebooks bookings
Route::get('/admin/ebook-booking','App\Http\Controllers\admin\Ebook\BookingController@index')->middleware('role:Admin');
Route::get('/admin/ebook-booking/all','App\Http\Controllers\admin\Ebook\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/ebook-booking/create','App\Http\Controllers\admin\Ebook\BookingController@create')->middleware('role:Admin');
Route::post('/admin/ebook-booking','App\Http\Controllers\admin\Ebook\BookingController@store')->middleware('role:Admin');
Route::get('/admin/ebook-booking/{booking}','App\Http\Controllers\admin\Ebook\BookingController@show')->middleware('role:Admin');
Route::get('/admin/ebook-booking/{booking}/edit','App\Http\Controllers\admin\Ebook\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook-booking/{booking}','App\Http\Controllers\admin\Ebook\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/ebook-booking/{booking}','App\Http\Controllers\admin\Ebook\BookingController@destroy')->middleware('role:Admin');

//admin home pop up
Route::get('/admin/home-popup','App\Http\Controllers\admin\HomePopupController@index')->middleware('role:Admin');
Route::get('/admin/home-popup/create','App\Http\Controllers\admin\HomePopupController@create')->middleware('role:Admin');
Route::post('/admin/home-popup','App\Http\Controllers\admin\HomePopupController@store')->middleware('role:Admin');
Route::get('/admin/home-popup/{popup}/edit','App\Http\Controllers\admin\HomePopupController@edit')->middleware('role:Admin');
Route::patch('/admin/home-popup/{popup}','App\Http\Controllers\admin\HomePopupController@update')->middleware('role:Admin');
Route::delete('/admin/home-popup/{popup}','App\Http\Controllers\admin\HomePopupController@destroy')->middleware('role:Admin');

//admin audio uploads categories
Route::get('/admin/audios','App\Http\Controllers\admin\Audio\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/audios/create','App\Http\Controllers\admin\Audio\CategoryController@create')->middleware('role:Admin');
Route::get('/admin/audios/{category}/edit','App\Http\Controllers\admin\Audio\CategoryController@edit')->middleware('role:Admin');
Route::post('/admin/audios','App\Http\Controllers\admin\Audio\CategoryController@store')->middleware('role:Admin');
Route::patch('/admin/audios/{category}','App\Http\Controllers\admin\Audio\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/audios/{category}','App\Http\Controllers\admin\Audio\CategoryController@destroy')->middleware('role:Admin');

//admin audio files
Route::get('/admin/audios/{category}/files','App\Http\Controllers\admin\Audio\AudioController@index')->middleware('role:Admin');
Route::get('/admin/audios/{category}/files/upload','App\Http\Controllers\admin\Audio\AudioController@upload')->middleware('role:Admin');
Route::post('/admin/audios/{category}/files','App\Http\Controllers\admin\Audio\AudioController@store')->middleware('role:Admin');
Route::delete('/admin/audios/{category}/files/{audio}','App\Http\Controllers\admin\Audio\AudioController@destroy')->middleware('role:Admin');

//admin provience mgmt
Route::get('/admin/provience','App\Http\Controllers\admin\Provience\ProvienceController@provienceList')->middleware('role:Admin');
Route::get('/admin/provience/create','App\Http\Controllers\admin\Provience\ProvienceController@createProvience')->middleware('role:Admin');
Route::post('/admin/provience','App\Http\Controllers\admin\Provience\ProvienceController@saveProvience')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/edit','App\Http\Controllers\admin\Provience\ProvienceController@editProvience')->middleware('role:Admin');
Route::patch('/admin/provience/{provience}','App\Http\Controllers\admin\Provience\ProvienceController@updateProvience')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}','App\Http\Controllers\admin\Provience\ProvienceController@destroyProvience')->middleware('role:Admin');

//admin provience district/city mgmt
Route::get('/admin/provience/{provience}/district-city','App\Http\Controllers\admin\Provience\DistrictCityController@index')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/district-city/create','App\Http\Controllers\admin\Provience\DistrictCityController@create')->middleware('role:Admin');
Route::post('/admin/provience/{provience}/district-city','App\Http\Controllers\admin\Provience\DistrictCityController@store')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}/district-city/{city}','App\Http\Controllers\admin\Provience\DistrictCityController@destroy')->middleware('role:Admin');

Route::get('/admin/branches','App\Http\Controllers\admin\Branch\BranchController@index')->middleware('role:Admin');
Route::get('/admin/branches/create','App\Http\Controllers\admin\Branch\BranchController@create')->middleware('role:Admin');
Route::post('/admin/branches','App\Http\Controllers\admin\Branch\BranchController@store')->middleware('role:Admin');
Route::get('/admin/branches/{branch}','App\Http\Controllers\admin\Branch\BranchController@show')->middleware('role:Admin');
Route::get('/admin/branches/{branch}/edit','App\Http\Controllers\admin\Branch\BranchController@edit')->middleware('role:Admin');
Route::patch('/admin/branches/{branch}','App\Http\Controllers\admin\Branch\BranchController@update')->middleware('role:Admin');
Route::delete('/admin/branches/{branch}','App\Http\Controllers\admin\Branch\BranchController@destroy')->middleware('role:Admin');

//vendor wise bookings in admin
Route::get('/admin/vendor-course-bookings','App\Http\Controllers\admin\Vendors\BookingController@allVendorsCourseBookings')->middleware('role:Admin');
Route::get('/admin/vendor-video-bookings','App\Http\Controllers\admin\Vendors\BookingController@allVendorsVideoBookings')->middleware('role:Admin');
Route::get('/admin/vendor-ebook-bookings','App\Http\Controllers\admin\Vendors\BookingController@allVendorsEbookBookings')->middleware('role:Admin');
Route::get('/admin/vendor-exam-bookings','App\Http\Controllers\admin\Vendors\BookingController@allVendorsExamBookings')->middleware('role:Admin');

//admin publisher mgmt 
Route::get('/admin/publishers','App\Http\Controllers\admin\Publisher\PublisherController@index')->middleware('role:Admin');
Route::get('/admin/publishers/create','App\Http\Controllers\admin\Publisher\PublisherController@create')->middleware('role:Admin');
Route::post('/admin/publishers','App\Http\Controllers\admin\Publisher\PublisherController@store')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}','App\Http\Controllers\admin\Publisher\PublisherController@show')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}/edit','App\Http\Controllers\admin\Publisher\PublisherController@edit')->middleware('role:Admin');
Route::patch('/admin/publishers/{publisher}','App\Http\Controllers\admin\Publisher\PublisherController@update')->middleware('role:Admin');
Route::delete('/admin/publishers/{publisher}','App\Http\Controllers\admin\Publisher\PublisherController@destroy')->middleware('role:Admin');

//admin publisher book mgmt
Route::get('/admin/publishers/{publisher}/books','App\Http\Controllers\admin\Publisher\BookController@index')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}/books/{ebook}','App\Http\Controllers\admin\Publisher\BookController@show')->middleware('role:Admin');
Route::delete('/admin/publishers/{publisher}/books/{ebook}','App\Http\Controllers\admin\Publisher\BookController@destroy')->middleware('role:Admin');

//admin career mgmt
Route::get('/admin/careers','App\Http\Controllers\admin\Career\VaccancyController@index')->middleware('role:Admin');
Route::get('/admin/careers/create','App\Http\Controllers\admin\Career\VaccancyController@create')->middleware('role:Admin');
Route::post('/admin/careers','App\Http\Controllers\admin\Career\VaccancyController@store')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}','App\Http\Controllers\admin\Career\VaccancyController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/edit','App\Http\Controllers\admin\Career\VaccancyController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}','App\Http\Controllers\admin\Career\VaccancyController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}','App\Http\Controllers\admin\Career\VaccancyController@destroy')->middleware('role:Admin');

//career applicants mgmt
Route::get('/admin/careers/{vaccancy}/applicants','App\Http\Controllers\admin\Career\ApplicantController@index')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\admin\Career\ApplicantController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}/edit','App\Http\Controllers\admin\Career\ApplicantController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\admin\Career\ApplicantController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\admin\Career\ApplicantController@destroy')->middleware('role:Admin');

//admin dynamic form category mgmt
Route::get('/admin/dynamic-forms/categories','App\Http\Controllers\admin\Forms\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/create','App\Http\Controllers\admin\Forms\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories','App\Http\Controllers\admin\Forms\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/edit','App\Http\Controllers\admin\Forms\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\admin\Forms\CategoryController@show')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/reset','App\Http\Controllers\admin\Forms\CategoryController@reset')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\admin\Forms\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\admin\Forms\CategoryController@destroy')->middleware('role:Admin');

//admin dynamic form sub category mgmt
Route::get('/admin/dynamic-forms/categories/{category}/sub-categories','App\Http\Controllers\admin\Forms\SubCategoryController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/sub-categories/create','App\Http\Controllers\admin\Forms\SubCategoryController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/sub-categories','App\Http\Controllers\admin\Forms\SubCategoryController@store')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/sub-categories/{subCategory}','App\Http\Controllers\admin\Forms\SubCategoryController@destroy')->middleware('role:Admin');

// //admin dynamic form applicants
Route::get('/admin/dynamic-forms/categories/{category}/applicants','App\Http\Controllers\admin\Forms\ApplicantController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/upload','App\Http\Controllers\admin\Forms\ApplicantController@uploadForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/applicants/filter','App\Http\Controllers\admin\Forms\ApplicantController@filterApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/export/{query}','App\Http\Controllers\admin\Forms\ApplicantController@exportFilteredApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/export','App\Http\Controllers\admin\Forms\ApplicantController@exportApplicants')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/applicants/import','App\Http\Controllers\admin\Forms\ApplicantController@importApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\admin\Forms\ApplicantController@show')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\admin\Forms\ApplicantController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\admin\Forms\ApplicantController@destroy')->middleware('role:Admin');

// //admin team assign for dynamic form applicants
Route::get('/admin/dynamic-forms/categories/{category}/team-assign','App\Http\Controllers\admin\Forms\TeamAssignController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/team-assign/create','App\Http\Controllers\admin\Forms\TeamAssignController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/team-assign','App\Http\Controllers\admin\Forms\TeamAssignController@store')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/team-assign/{assign}','App\Http\Controllers\admin\Forms\TeamAssignController@destroy')->middleware('role:Admin');

//admin dynamic forms groups
Route::get('/admin/dynamic-forms/groups','App\Http\Controllers\admin\Forms\GroupController@index')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/groups','App\Http\Controllers\admin\Forms\GroupController@store')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/groups','App\Http\Controllers\admin\Forms\GroupController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/groups/{group}','App\Http\Controllers\admin\Forms\GroupController@destroy')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/forms','App\Http\Controllers\admin\Forms\GroupController@forms')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/applicants','App\Http\Controllers\admin\Forms\GroupController@applicants')->middleware('role:Admin');


//admin orientation management
Route::get('/admin/orientations','App\Http\Controllers\admin\Orientation\OrientationController@index')->middleware('role:Admin');
Route::get('/admin/orientations/create','App\Http\Controllers\admin\Orientation\OrientationController@create')->middleware('role:Admin');
Route::post('/admin/orientations','App\Http\Controllers\admin\Orientation\OrientationController@store')->middleware('role:Admin');
Route::get('/admin/orientations/{orientation}','App\Http\Controllers\admin\Orientation\OrientationController@show')->middleware('role:Admin');
Route::get('/admin/orientations/{orientation}/edit','App\Http\Controllers\admin\Orientation\OrientationController@edit')->middleware('role:Admin');
Route::patch('/admin/orientations/{orientation}','App\Http\Controllers\admin\Orientation\OrientationController@update')->middleware('role:Admin');
Route::delete('/admin/orientations/{orientation}','App\Http\Controllers\admin\Orientation\OrientationController@destroy')->middleware('role:Admin');

//admin orientation participants management
Route::get('/admin/orientations/{orientation}/participants','App\Http\Controllers\admin\Orientation\ParticipantController@index')->middleware('role:Admin');
Route::delete('/admin/orientations/{orientation}/participants/{participant}','App\Http\Controllers\admin\Orientation\ParticipantController@destroy')->middleware('role:Admin');

//admin teams mgmt
Route::get('/admin/teams','App\Http\Controllers\admin\Teams\TeamController@index')->middleware('role:Admin');
Route::get('/admin/teams/create','App\Http\Controllers\admin\Teams\TeamController@create')->middleware('role:Admin');
Route::post('/admin/teams','App\Http\Controllers\admin\Teams\TeamController@store')->middleware('role:Admin');
Route::get('/admin/teams/{team}','App\Http\Controllers\admin\Teams\TeamController@show')->middleware('role:Admin');
Route::get('/admin/teams/{team}/edit','App\Http\Controllers\admin\Teams\TeamController@edit')->middleware('role:Admin');
Route::patch('/admin/teams/{team}','App\Http\Controllers\admin\Teams\TeamController@update')->middleware('role:Admin');
Route::delete('/admin/teams/{team}','App\Http\Controllers\admin\Teams\TeamController@destroy')->middleware('role:Admin');

//admin merchant wise bookings
Route::get('/admin/booking-through-merchant','App\Http\Controllers\admin\MerchantBookingController@index')->middleware('role:Admin');
















/*------------------------------------all student section routes---------------------------*/

//final routes for students section
Route::get('/student/home', 'App\Http\Controllers\student\StudentHomeController@index')->middleware('role:Student');
Route::get('/student/enrolled', 'App\Http\Controllers\student\StudentHomeController@enroll')->middleware('role:Student');
Route::get('/student/enrolled/approved', 'App\Http\Controllers\student\StudentHomeController@approved')->middleware('role:Student');
Route::get('/student/enrolled/pending', 'App\Http\Controllers\student\StudentHomeController@pending')->middleware('role:Student');
Route::get('/student/enrolled/suspended', 'App\Http\Controllers\student\StudentHomeController@suspended')->middleware('role:Student');
Route::get('/student/enrolled/classroom', 'App\Http\Controllers\student\StudentHomeController@classroom')->middleware('role:Student');

Route::get('/student/courses/enroll', 'App\Http\Controllers\student\BookingsController@create')->middleware('role:Student');
Route::post('/student/courses','App\Http\Controllers\student\BookingsController@store')->middleware('role:Student');
Route::get('/student/courses/{booking}','App\Http\Controllers\student\BookingsController@show')->middleware('role:Student');
Route::get('/student/courses/{booking}/edit','App\Http\Controllers\student\BookingsController@edit')->middleware('role:Student');

Route::any('/student/courses/{booking}/esewaSuccess','App\Http\Controllers\student\BookingsController@esewaSuccess')->middleware('role:Student');
Route::post('/student/courses/{booking}/khaltiSuccess','App\Http\Controllers\student\BookingsController@khaltiSuccess')->middleware('role:Student');
Route::any('/student/courses/{booking}/payment-failed','App\Http\Controllers\student\BookingsController@paymentFailed')->middleware('role:Student');

Route::patch('/student/courses/{booking}','App\Http\Controllers\student\BookingsController@update')->middleware('role:Student');

Route::get('/student/notifications', 'App\Http\Controllers\student\NotificationController@index')->middleware('role:Student');
Route::get('/student/notifications/{notification}', 'App\Http\Controllers\student\NotificationController@show')->middleware('role:Student');


//students tutor special courses bookings
Route::get('/student/tutor-special/courses','App\Http\Controllers\student\TutorCourseBookingController@index')->middleware('role:Student');
Route::get('/student/tutor-special/courses/enroll','App\Http\Controllers\student\TutorCourseBookingController@enroll')->middleware('role:Student');
Route::post('/student/tutor-special/courses','App\Http\Controllers\student\TutorCourseBookingController@store')->middleware('role:Student');
Route::get('/student/tutor-special/courses/{booking}','App\Http\Controllers\student\TutorCourseBookingController@show')->middleware('role:Student');
Route::get('/student/tutor-special/courses/{booking}/edit','App\Http\Controllers\student\TutorCourseBookingController@edit')->middleware('role:Student');
Route::patch('/student/tutor-special/courses/{booking}','App\Http\Controllers\student\TutorCourseBookingController@verify')->middleware('role:Student');

//student section exam hall booking section
Route::get('/student/exam-hall','App\Http\Controllers\student\ExamHall\ExamBookingController@index')->middleware('role:Student');
Route::get('/student/exam-hall/enroll','App\Http\Controllers\student\ExamHall\ExamBookingController@enroll')->middleware('role:Student');
Route::post('/student/exam-hall','App\Http\Controllers\student\ExamHall\ExamBookingController@store')->middleware('role:Student');
Route::get('/student/exam-hall/{booking}/edit','App\Http\Controllers\student\ExamHall\ExamBookingController@edit')->middleware('role:Student');
Route::patch('/student/exam-hall/{booking}','App\Http\Controllers\student\ExamHall\ExamBookingController@manualVerify')->middleware('role:Student');
Route::delete('/student/exam-hall/{booking}','App\Http\Controllers\student\ExamHall\ExamBookingController@destroy')->middleware('role:Student');

Route::get('/student/exam-hall/{booking}/esewaSuccess','App\Http\Controllers\student\ExamHall\ExamBookingController@esewaSuccess')->middleware('role:Student');
Route::post('/student/exam-hall/{booking}/khaltiSuccess','App\Http\Controllers\student\ExamHall\ExamBookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/exam-hall/{booking}/payment-failed','App\Http\Controllers\student\ExamHall\ExamBookingController@paymentFailed')->middleware('role:Student');

Route::get('/student/exam-hall/{category}/exams','App\Http\Controllers\student\ExamHall\ExamController@index')->middleware('role:Student');
Route::get('/student/exam-hall/{category}/exams/{exam}/attempt','App\Http\Controllers\student\ExamHall\ExamController@takeExam')->middleware('role:Student');
Route::post('/student/exam-hall/{category}/exams/{exam}/save','App\Http\Controllers\student\ExamHall\ExamController@store')->middleware('role:Student');
Route::get('/student/exam-hall/{category}/exams/{exam}/view','App\Http\Controllers\student\ExamHall\ExamController@show')->middleware('role:Student');
Route::delete('/student/exam-hall/{category}/exams/{exam}/reset','App\Http\Controllers\student\ExamHall\ExamController@resetExam')->middleware('role:Student');

//exam hall cqc student section
Route::get('/student/exam-hall/{category}/cqc','App\Http\Controllers\student\ExamHall\CQCController@index');
Route::post('/student/exam-hall/{category}/cqc','App\Http\Controllers\student\ExamHall\CQCController@store');

//student messenger
Route::get('/student/messenger', 'App\Http\Controllers\student\MessengerController@index')->middleware('role:Student');
Route::get('/student/messenger/{id}/chat', 'App\Http\Controllers\student\MessengerController@chatShow')->middleware('role:Student');
Route::post('/student/messenger/{id}/chat', 'App\Http\Controllers\student\MessengerController@chatSave')->middleware('role:Student');

//student video course bookings
Route::get('/student/video-course','App\Http\Controllers\student\Video\BookingController@index')->middleware('role:Student');
Route::get('/student/video-course/enroll','App\Http\Controllers\student\Video\BookingController@create')->middleware('role:Student');
Route::post('/student/video-course','App\Http\Controllers\student\Video\BookingController@store')->middleware('role:Student');
Route::get('/student/video-course/{booking}/edit','App\Http\Controllers\student\Video\BookingController@edit')->middleware('role:Student');
Route::patch('/student/video-course/{booking}','App\Http\Controllers\student\Video\BookingController@update')->middleware('role:Student');
Route::delete('/student/video-course/{booking}','App\Http\Controllers\student\Video\BookingController@destroy')->middleware('role:Student');

Route::get('/student/video-course/{booking}/esewaSuccess','App\Http\Controllers\student\Video\BookingController@esewaSuccess')->middleware('role:Student');
Route::post('/student/video-course/{booking}/khaltiSuccess','App\Http\Controllers\student\Video\BookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/video-course/{booking}/payment-failed','App\Http\Controllers\student\Video\BookingController@paymentFailed')->middleware('role:Student');

//student video course and chapters
Route::get('/student/video-course/{booking}/chapters','App\Http\Controllers\student\Video\CourseController@chapters')->middleware('role:Student');
Route::get('/student/video-course/{booking}/chapters/{chapter}/videos','App\Http\Controllers\student\Video\CourseController@videos')->middleware('role:Student');
Route::get('/student/video-course/{booking}/chapters/{chapter}/videos/{video}','App\Http\Controllers\student\Video\CourseController@show')->middleware('role:Student');

//student video course cqc
Route::get('/student/video-course/{booking}/cqc','App\Http\Controllers\student\Video\CQCController@index')->middleware('role:Student');
Route::post('/student/video-course/{booking}/cqc','App\Http\Controllers\student\Video\CQCController@store')->middleware('role:Student');

//student video course exams
Route::get('/student/video-course/{booking}/exams','App\Http\Controllers\student\Video\ExamController@index')->middleware('role:Student');
Route::get('/student/video-course/{booking}/exams/{exam}/attempt','App\Http\Controllers\student\Video\ExamController@takeExam')->middleware('role:Student');
Route::post('/student/video-course/{booking}/exams/{exam}/save','App\Http\Controllers\student\Video\ExamController@saveExam')->middleware('role:Student');
Route::get('/student/video-course/{booking}/exams/{exam}/view','App\Http\Controllers\student\Video\ExamController@viewExam')->middleware('role:Student');
Route::delete('/student/video-course/{booking}/exams/{exam}/reset','App\Http\Controllers\student\Video\ExamController@resetExam')->middleware('role:Student');

//student ebook booking
Route::get('/student/ebook','App\Http\Controllers\student\Ebook\BookingController@index')->middleware('role:Student');
Route::get('/student/ebook/enroll','App\Http\Controllers\student\Ebook\BookingController@create')->middleware('role:Student');
Route::post('/student/ebook','App\Http\Controllers\student\Ebook\BookingController@store')->middleware('role:Student');
Route::get('/student/ebook/{booking}/edit','App\Http\Controllers\student\Ebook\BookingController@edit')->middleware('role:Student');
Route::patch('/student/ebook/{booking}','App\Http\Controllers\student\Ebook\BookingController@update')->middleware('role:Student');
Route::delete('/student/ebook/{booking}','App\Http\Controllers\student\Ebook\BookingController@destroy')->middleware('role:Student');

Route::get('/student/ebook/{booking}/esewaSuccess','App\Http\Controllers\student\Ebook\BookingController@esewaSuccess')->middleware('role:Student');
Route::post('/student/ebook/{booking}/khaltiSuccess','App\Http\Controllers\student\Ebook\BookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/ebook/{booking}/payment-failed','App\Http\Controllers\student\Ebook\BookingController@paymentFailed')->middleware('role:Student');

//student ebook chapters
Route::get('/student/ebook/{booking}/chapters','App\Http\Controllers\student\Ebook\ChapterController@index')->middleware('role:Student');
Route::get('/student/ebook/{booking}/chapters/{chapter}','App\Http\Controllers\student\Ebook\ChapterController@show')->middleware('role:Student');

//student free orientation class mgmt
Route::get('/student/free-orientations','App\Http\Controllers\student\StudentHomeController@orientations')->middleware('role:Student');














/*-------------------------------------all tutor section final routes-----------------------------------*/

//tutors panel management
Route::get('/tutor/home','App\Http\Controllers\Tutors\TutorHomeController@index')->middleware('role:Tutor');
Route::get('/tutor/classroom','App\Http\Controllers\Tutors\TutorHomeController@classroom')->middleware('role:Tutor');
Route::get('/tutor/reviews','App\Http\Controllers\Tutors\TutorHomeController@reviews')->middleware('role:Tutor');
Route::get('/tutor/posts','App\Http\Controllers\Tutors\TutorPostController@index')->middleware('role:Tutor');
Route::get('/tutor/posts/create','App\Http\Controllers\Tutors\TutorPostController@create')->middleware('role:Tutor');
Route::post('/tutor/posts','App\Http\Controllers\Tutors\TutorPostController@store')->middleware('role:Tutor');
Route::get('/tutor/posts/{post}','App\Http\Controllers\Tutors\TutorPostController@show')->middleware('role:Tutor');
Route::get('/tutor/posts/{post}/edit','App\Http\Controllers\Tutors\TutorPostController@edit')->middleware('role:Tutor');
Route::patch('/tutor/posts/{post}','App\Http\Controllers\Tutors\TutorPostController@update')->middleware('role:Tutor');
Route::delete('/tutor/posts/{post}','App\Http\Controllers\Tutors\TutorPostController@destroy')->middleware('role:Tutor');
Route::post('/tutor/posts/{post}/comments/add','App\Http\Controllers\Tutors\TutorPostController@addComments')->middleware('role:Tutor');
Route::post('/tutor/{post}/comments/add','App\Http\Controllers\Tutors\TutorHomeController@addComments')->middleware('role:Tutor');
Route::get('/tutor/posts/{post}/comments','App\Http\Controllers\Tutors\TutorPostController@comments')->middleware('role:Tutor');
Route::delete('/tutor/posts/{post}/comments/{comment}','App\Http\Controllers\Tutors\TutorPostController@deleteComment')->middleware('role:Tutor');

//tutor panel mgmt for tutor courses
Route::get('/tutor/special-courses', 'App\Http\Controllers\Tutors\TutorCourseController@index');
Route::get('/tutor/special-courses/create', 'App\Http\Controllers\Tutors\TutorCourseController@create');
Route::post('/tutor/special-courses', 'App\Http\Controllers\Tutors\TutorCourseController@store');
Route::get('/tutor/special-courses/{course}', 'App\Http\Controllers\Tutors\TutorCourseController@show');
Route::get('/tutor/special-courses/{course}/edit', 'App\Http\Controllers\Tutors\TutorCourseController@edit');
Route::patch('/tutor/special-courses/{course}', 'App\Http\Controllers\Tutors\TutorCourseController@update');
Route::get('/tutor/special-courses/{course}/bookings', 'App\Http\Controllers\Tutors\TutorCourseController@bookings');

//tutor course payment requests handeler
Route::get('/tutor/payment-requests', 'App\Http\Controllers\Tutors\TutorCoursePaymentController@index');
Route::get('/tutor/payment-requests/request', 'App\Http\Controllers\Tutors\TutorCoursePaymentController@request');
Route::get('/tutor/payment-requests/request/{course}', 'App\Http\Controllers\Tutors\TutorCoursePaymentController@create');
Route::post('/tutor/payment-requests', 'App\Http\Controllers\Tutors\TutorCoursePaymentController@store');

//tutor messenger 
Route::get('/tutor/messenger', 'App\Http\Controllers\messenger\ChatMessengerController@tutorindex')->middleware('role:Tutor');
Route::get('/tutor/messenger/{user}/chat', 'App\Http\Controllers\messenger\ChatMessengerController@tutorchat')->middleware('role:Tutor');
Route::post('/tutor/messenger/{user}/chat', 'App\Http\Controllers\messenger\ChatMessengerController@chatsave')->middleware('role:Tutor');

//tutor video course
Route::get('/tutor/video-course','App\Http\Controllers\Tutors\TutorVideoCourseController@index')->middleware('role:Tutor');
















/*-------------------------------------all vendor section final routes-----------------------------------*/

//final routes for vendor panel
Route::get('/vendor/home','App\Http\Controllers\Vendors\VendorHomeController@index')->middleware('role:Vendor');

//vendor registered users
Route::get('/vendor/users','App\Http\Controllers\Vendors\UserController@index')->middleware('role:Vendor');
Route::get('/vendor/users/create','App\Http\Controllers\Vendors\UserController@create')->middleware('role:Vendor');
Route::post('/vendor/users','App\Http\Controllers\Vendors\UserController@store')->middleware('role:Vendor');
Route::get('/vendor/users/{vendoruser}','App\Http\Controllers\Vendors\UserController@show')->middleware('role:Vendor');
Route::get('/vendor/users/{vendoruser}/edit','App\Http\Controllers\Vendors\UserController@edit')->middleware('role:Vendor');
Route::patch('/vendor/users/{vendoruser}','App\Http\Controllers\Vendors\UserController@update')->middleware('role:Vendor');
Route::delete('/vendor/users/{vendoruser}','App\Http\Controllers\Vendors\UserController@destroy')->middleware('role:Vendor');

//vendor registered course bookings
Route::get('/vendor/bookings','App\Http\Controllers\Vendors\BookingController@index')->middleware('role:Vendor');
Route::get('/vendor/bookings/all','App\Http\Controllers\Vendors\BookingController@allBookings')->middleware('role:Vendor');
Route::get('/vendor/bookings/create','App\Http\Controllers\Vendors\BookingController@create')->middleware('role:Vendor');
Route::post('/vendor/bookings/next','App\Http\Controllers\Vendors\BookingController@next')->middleware('role:Vendor');
Route::post('/vendor/bookings','App\Http\Controllers\Vendors\BookingController@store')->middleware('role:Vendor');
Route::get('/vendor/bookings/{vendorbooking}','App\Http\Controllers\Vendors\BookingController@show')->middleware('role:Vendor');
Route::get('/vendor/bookings/{vendorbooking}/edit','App\Http\Controllers\Vendors\BookingController@edit')->middleware('role:Vendor');
Route::patch('/vendor/bookings/{vendorbooking}','App\Http\Controllers\Vendors\BookingController@update')->middleware('role:Vendor');
Route::delete('/vendor/bookings/{vendorbooking}','App\Http\Controllers\Vendors\BookingController@destroy')->middleware('role:Vendor');
Route::any('/vendor/bookings/batch/{batch}/users/{userids}/esewaSuccess', 'App\Http\Controllers\Vendors\BookingController@esewaSuccess')->middleware('role:Vendor');
Route::any('/vendor/bookings/batch/{batch}/users/{userids}/payment-failed', 'App\Http\Controllers\Vendors\BookingController@paymentFailed')->middleware('role:Vendor');

//vendor registered exam bookings
Route::get('/vendor/exam-hall/bookings','App\Http\Controllers\Vendors\ExamBookingController@index')->middleware('role:Vendor');
Route::get('/vendor/exam-hall/bookings/all','App\Http\Controllers\Vendors\ExamBookingController@allBookings')->middleware('role:Vendor');
Route::get('/vendor/exam-hall/bookings/create','App\Http\Controllers\Vendors\ExamBookingController@create')->middleware('role:Vendor');
Route::post('/vendor/exam-hall/bookings/next','App\Http\Controllers\Vendors\ExamBookingController@next')->middleware('role:Vendor');
Route::post('/vendor/exam-hall/bookings','App\Http\Controllers\Vendors\ExamBookingController@store')->middleware('role:Vendor');
Route::get('/vendor/exam-hall/bookings/{booking}','App\Http\Controllers\Vendors\ExamBookingController@show')->middleware('role:Vendor');
Route::get('/vendor/exam-hall/bookings/{exambooking}/edit','App\Http\Controllers\Vendors\ExamBookingController@edit')->middleware('role:Vendor');
Route::patch('/vendor/exam-hall/bookings/{vendorbooking}','App\Http\Controllers\Vendors\ExamBookingController@update')->middleware('role:Vendor');
Route::delete('/vendor/exam-hall/bookings/{booking}','App\Http\Controllers\Vendors\ExamBookingController@destroy')->middleware('role:Vendor');
Route::any('/vendor/exam-hall/bookings/exam/{exam}/users/{userids}/esewaSuccess', 'App\Http\Controllers\Vendors\ExamBookingController@esewaSuccess')->middleware('role:Vendor');
Route::any('/vendor/exam-hall/bookings/exam/{exam}/users/{userids}/payment-failed', 'App\Http\Controllers\Vendors\ExamBookingController@paymentFailed')->middleware('role:Vendor');

//vendor registered video bookings
Route::get('/vendor/video-booking','App\Http\Controllers\Vendors\VideoBookingController@index')->middleware('role:Vendor');
Route::get('/vendor/video-booking/all','App\Http\Controllers\Vendors\VideoBookingController@allBookings')->middleware('role:Vendor');
Route::get('/vendor/video-booking/create','App\Http\Controllers\Vendors\VideoBookingController@create')->middleware('role:Vendor');
Route::post('/vendor/video-booking/next','App\Http\Controllers\Vendors\VideoBookingController@next')->middleware('role:Vendor');
Route::post('/vendor/video-booking','App\Http\Controllers\Vendors\VideoBookingController@store')->middleware('role:Vendor');
Route::get('/vendor/video-booking/{booking}','App\Http\Controllers\Vendors\VideoBookingController@show')->middleware('role:Vendor');
Route::get('/vendor/video-booking/{videobooking}/edit','App\Http\Controllers\Vendors\VideoBookingController@edit')->middleware('role:Vendor');
Route::patch('/vendor/video-booking/{videobooking}','App\Http\Controllers\Vendors\VideoBookingController@update')->middleware('role:Vendor');
Route::delete('/vendor/video-booking/{videobooking}','App\Http\Controllers\Vendors\VideoBookingController@destroy')->middleware('role:Vendor');
Route::any('/vendor/video-booking/course/{course}/users/{userids}/esewaSuccess', 'App\Http\Controllers\Vendors\VideoBookingController@esewaSuccess')->middleware('role:Vendor');
Route::any('/vendor/video-booking/course/{course}/users/{userids}/payment-failed', 'App\Http\Controllers\Vendors\VideoBookingController@paymentFailed')->middleware('role:Vendor');

//vendor registered ebook booking
Route::get('/vendor/ebook-booking','App\Http\Controllers\Vendors\EbookBookingController@index')->middleware('role:Vendor');
Route::get('/vendor/ebook-booking/all','App\Http\Controllers\Vendors\EbookBookingController@allBookings')->middleware('role:Vendor');
Route::get('/vendor/ebook-booking/create','App\Http\Controllers\Vendors\EbookBookingController@create')->middleware('role:Vendor');
Route::post('/vendor/ebook-booking/next','App\Http\Controllers\Vendors\EbookBookingController@next')->middleware('role:Vendor');
Route::post('/vendor/ebook-booking','App\Http\Controllers\Vendors\EbookBookingController@store')->middleware('role:Vendor');
Route::get('/vendor/ebook-booking/{booking}','App\Http\Controllers\Vendors\EbookBookingController@show')->middleware('role:Vendor');
Route::get('/vendor/ebook-booking/{vendorbooking}/edit','App\Http\Controllers\Vendors\EbookBookingController@edit')->middleware('role:Vendor');
Route::patch('/vendor/ebook-booking/{vendorbooking}','App\Http\Controllers\Vendors\EbookBookingController@update')->middleware('role:Vendor');
Route::delete('/vendor/ebook-booking/{vendorbooking}','App\Http\Controllers\Vendors\EbookBookingController@destroy')->middleware('role:Vendor');
Route::any('/vendor/ebook-booking/book/{book}/users/{userids}/esewaSuccess', 'App\Http\Controllers\Vendors\EbookBookingController@esewaSuccess')->middleware('role:Vendor');
Route::any('/vendor/ebook-booking/book/{book}/users/{userids}/payment-failed', 'App\Http\Controllers\Vendors\EbookBookingController@paymentFailed')->middleware('role:Vendor');

//vendor provience users mgmt
Route::get('/vendor/provience-users','App\Http\Controllers\Vendors\UserController@listProvienceUsers')->middleware('role:Vendor');
Route::get('/vendor/provience-users/{user}','App\Http\Controllers\Vendors\UserController@showProvienceUser')->middleware('role:Vendor');
Route::get('/vendor/provience-users/{user}/edit','App\Http\Controllers\Vendors\UserController@editProvienceUser')->middleware('role:Vendor');
Route::patch('/vendor/provience-users/{user}','App\Http\Controllers\Vendors\UserController@updateProvienceUser')->middleware('role:Vendor');

//vendor all users
Route::get('/vendor/all-users','App\Http\Controllers\Vendors\UserController@allUsers')->middleware('role:Vendor');
Route::get('/vendor/all-users/{user}','App\Http\Controllers\Vendors\UserController@showUser')->middleware('role:Vendor');

//vendor course manual bookings
Route::get('/vendor/manual-bookings','App\Http\Controllers\Vendors\ManualBookingController@index')->middleware('role:Vendor');
Route::get('/vendor/manual-bookings/{booking}','App\Http\Controllers\Vendors\ManualBookingController@view')->middleware('role:Vendor');
Route::get('/vendor/manual-bookings/{booking}/edit','App\Http\Controllers\Vendors\ManualBookingController@edit')->middleware('role:Vendor');
Route::patch('/vendor/manual-bookings/{booking}','App\Http\Controllers\Vendors\ManualBookingController@update')->middleware('role:Vendor');
Route::delete('/vendor/manual-bookings/{booking}','App\Http\Controllers\Vendors\ManualBookingController@destroy')->middleware('role:Vendor');

//vendor enquiries leads management
Route::get('/vendor/enquiries','App\Http\Controllers\Vendors\EnquiryController@index')->middleware('role:Vendor');
Route::get('/vendor/enquiries/{enquiry}/edit','App\Http\Controllers\Vendors\EnquiryController@edit')->middleware('role:Vendor');
Route::patch('/vendor/enquiries/{enquiry}','App\Http\Controllers\Vendors\EnquiryController@update')->middleware('role:Vendor');
Route::delete('/vendor/enquiries/{enquiry}','App\Http\Controllers\Vendors\EnquiryController@destroy')->middleware('role:Vendor');
Route::get('/vendor/enquiries/filter','App\Http\Controllers\Vendors\EnquiryController@filterFormShow')->middleware('role:Vendor');
Route::post('/vendor/enquiries/filter','App\Http\Controllers\Vendors\EnquiryController@filterResults')->middleware('role:Vendor');

//vendor admin dynamic forms mgmt
Route::get('/vendor/dynamic-forms','App\Http\Controllers\Vendors\DynamicFormController@formLists')->middleware('role:Vendor');
Route::get('/vendor/dynamic-forms/{category}/applicants','App\Http\Controllers\Vendors\DynamicFormController@applicantLists')->middleware('role:Vendor');
Route::get('/vendor/dynamic-forms/{category}/applicants/{applicant}','App\Http\Controllers\Vendors\DynamicFormController@showApplicant')->middleware('role:Vendor');
Route::patch('/vendor/dynamic-forms/{category}/applicants/{applicant}','App\Http\Controllers\Vendors\DynamicFormController@updateApplicant')->middleware('role:Vendor');
Route::delete('/vendor/dynamic-forms/{category}/applicants/{applicant}','App\Http\Controllers\Vendors\DynamicFormController@destroyApplicant')->middleware('role:Vendor');

//vendor vendor dynamic form group mgmt
Route::get('/vendor/vendor-dynamic-forms/groups','App\Http\Controllers\Vendors\VendorFormGroupController@index')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms/groups','App\Http\Controllers\Vendors\VendorFormGroupController@store')->middleware('role:Vendor');
Route::patch('/vendor/vendor-dynamic-forms/groups','App\Http\Controllers\Vendors\VendorFormGroupController@update')->middleware('role:Vendor');
Route::delete('/vendor/vendor-dynamic-forms/groups/{group}','App\Http\Controllers\Vendors\VendorFormGroupController@destroy')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/groups/{group}/forms','App\Http\Controllers\Vendors\VendorFormGroupController@forms')->middleware('role:Vendor');


//vendor vendor dynamic forms mgmt
Route::get('/vendor/vendor-dynamic-forms','App\Http\Controllers\Vendors\VendorFormController@formLists')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/create','App\Http\Controllers\Vendors\VendorFormController@createForm')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms','App\Http\Controllers\Vendors\VendorFormController@saveForm')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}','App\Http\Controllers\Vendors\VendorFormController@showForm')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/edit','App\Http\Controllers\Vendors\VendorFormController@editForm')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms/{vform}/reset','App\Http\Controllers\Vendors\VendorFormController@resetForm')->middleware('role:Vendor');
Route::patch('/vendor/vendor-dynamic-forms/{vform}','App\Http\Controllers\Vendors\VendorFormController@updateForm')->middleware('role:Vendor');
Route::delete('/vendor/vendor-dynamic-forms/{vform}','App\Http\Controllers\Vendors\VendorFormController@destroyForm')->middleware('role:Vendor');

//vendor vendor-dynamic-form applicants mgmt
Route::get('/vendor/vendor-dynamic-forms/{vform}/applicants','App\Http\Controllers\Vendors\VendorFormController@applicantLists')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/applicants/upload','App\Http\Controllers\Vendors\VendorFormController@uploadApplicantListForm')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/applicants/export','App\Http\Controllers\Vendors\VendorFormController@exportApplicantLists')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms/{vform}/applicants/import','App\Http\Controllers\Vendors\VendorFormController@importApplicantLists')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms/{vform}/applicants/filter','App\Http\Controllers\Vendors\VendorFormController@filteredApplicantLists')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/applicants/export/{query}','App\Http\Controllers\Vendors\VendorFormController@exportFilteredApplicantLists')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Vendors\VendorFormController@showApplicant')->middleware('role:Vendor');
Route::patch('/vendor/vendor-dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Vendors\VendorFormController@updateApplicant')->middleware('role:Vendor');
Route::delete('/vendor/vendor-dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Vendors\VendorFormController@destroyApplicant')->middleware('role:Vendor');

// //vendor team assign for vendor dynamic form applicants
Route::get('/vendor/vendor-dynamic-forms/{vform}/team-assign','App\Http\Controllers\Vendors\FormTeamAssignController@index')->middleware('role:Vendor');
Route::get('/vendor/vendor-dynamic-forms/{vform}/team-assign/create','App\Http\Controllers\Vendors\FormTeamAssignController@create')->middleware('role:Vendor');
Route::post('/vendor/vendor-dynamic-forms/{vform}/team-assign','App\Http\Controllers\Vendors\FormTeamAssignController@store')->middleware('role:Vendor');
Route::delete('/vendor/vendor-dynamic-forms/{vform}/team-assign/{assign}','App\Http\Controllers\Vendors\FormTeamAssignController@destroy')->middleware('role:Vendor');






















/*---------------------------------all Teams panel routes--------------------------------------*/
Route::get('/team/home','App\Http\Controllers\Teams\TeamHomeController@index')->middleware('role:Team');

// team users mgmt
Route::get('/team/all-users','App\Http\Controllers\Teams\UserController@allUsers')->middleware('role:Team');
Route::get('/team/all-users/{user}','App\Http\Controllers\Teams\UserController@showUser')->middleware('role:Team');
Route::get('/team/users','App\Http\Controllers\Teams\UserController@index')->middleware('role:Team');
Route::get('/team/users/create','App\Http\Controllers\Teams\UserController@create')->middleware('role:Team');
Route::post('/team/users','App\Http\Controllers\Teams\UserController@store')->middleware('role:Team');
Route::get('/team/users/{vuser}','App\Http\Controllers\Teams\UserController@show')->middleware('role:Team');
Route::get('/team/users/{vuser}/edit','App\Http\Controllers\Teams\UserController@edit')->middleware('role:Team');
Route::patch('/team/users/{vuser}','App\Http\Controllers\Teams\UserController@update')->middleware('role:Team');
Route::delete('/team/users/{vuser}','App\Http\Controllers\Teams\UserController@destroy')->middleware('role:Team');

// team course booking mgmt
Route::get('/team/all-course-bookings','App\Http\Controllers\Teams\CourseBookingController@allBookings')->middleware('role:Team');
Route::get('/team/course-bookings','App\Http\Controllers\Teams\CourseBookingController@index')->middleware('role:Team');
Route::get('/team/course-bookings/create','App\Http\Controllers\Teams\CourseBookingController@create')->middleware('role:Team');
Route::post('/team/course-bookings','App\Http\Controllers\Teams\CourseBookingController@store')->middleware('role:Team');
Route::get('/team/course-bookings/{vbooking}','App\Http\Controllers\Teams\CourseBookingController@show')->middleware('role:Team');
Route::get('/team/course-bookings/{vbooking}/edit','App\Http\Controllers\Teams\CourseBookingController@edit')->middleware('role:Team');
Route::patch('/team/course-bookings/{vbooking}','App\Http\Controllers\Teams\CourseBookingController@update')->middleware('role:Team');
Route::delete('/team/course-bookings/{vbooking}','App\Http\Controllers\Teams\CourseBookingController@destroy')->middleware('role:Team');

// team exam booking mgmt
Route::get('/team/all-exam-bookings','App\Http\Controllers\Teams\ExamBookingController@allBookings')->middleware('role:Team');
Route::get('/team/exam-bookings','App\Http\Controllers\Teams\ExamBookingController@index')->middleware('role:Team');
Route::get('/team/exam-bookings/create','App\Http\Controllers\Teams\ExamBookingController@create')->middleware('role:Team');
Route::post('/team/exam-bookings','App\Http\Controllers\Teams\ExamBookingController@store')->middleware('role:Team');
Route::get('/team/exam-bookings/{vbooking}','App\Http\Controllers\Teams\ExamBookingController@show')->middleware('role:Team');
Route::get('/team/exam-bookings/{vbooking}/edit','App\Http\Controllers\Teams\ExamBookingController@edit')->middleware('role:Team');
Route::patch('/team/exam-bookings/{vbooking}','App\Http\Controllers\Teams\ExamBookingController@update')->middleware('role:Team');
Route::delete('/team/exam-bookings/{vbooking}','App\Http\Controllers\Teams\ExamBookingController@destroy')->middleware('role:Team');

// team video booking mgmt
Route::get('/team/all-video-bookings','App\Http\Controllers\Teams\VideoBookingController@allBookings')->middleware('role:Team');
Route::get('/team/video-bookings','App\Http\Controllers\Teams\VideoBookingController@index')->middleware('role:Team');
Route::get('/team/video-bookings/create','App\Http\Controllers\Teams\VideoBookingController@create')->middleware('role:Team');
Route::post('/team/video-bookings','App\Http\Controllers\Teams\VideoBookingController@store')->middleware('role:Team');
Route::get('/team/video-bookings/{vbooking}','App\Http\Controllers\Teams\VideoBookingController@show')->middleware('role:Team');
Route::get('/team/video-bookings/{vbooking}/edit','App\Http\Controllers\Teams\VideoBookingController@edit')->middleware('role:Team');
Route::patch('/team/video-bookings/{vbooking}','App\Http\Controllers\Teams\VideoBookingController@update')->middleware('role:Team');
Route::delete('/team/video-bookings/{vbooking}','App\Http\Controllers\Teams\VideoBookingController@destroy')->middleware('role:Team');

// team video booking mgmt
Route::get('/team/all-ebook-bookings','App\Http\Controllers\Teams\EbookBookingController@allBookings')->middleware('role:Team');
Route::get('/team/ebook-bookings','App\Http\Controllers\Teams\EbookBookingController@index')->middleware('role:Team');
Route::get('/team/ebook-bookings/create','App\Http\Controllers\Teams\EbookBookingController@create')->middleware('role:Team');
Route::post('/team/ebook-bookings','App\Http\Controllers\Teams\EbookBookingController@store')->middleware('role:Team');
Route::get('/team/ebook-bookings/{vbooking}','App\Http\Controllers\Teams\EbookBookingController@show')->middleware('role:Team');
Route::get('/team/ebook-bookings/{vbooking}/edit','App\Http\Controllers\Teams\EbookBookingController@edit')->middleware('role:Team');
Route::patch('/team/ebook-bookings/{vbooking}','App\Http\Controllers\Teams\EbookBookingController@update')->middleware('role:Team');
Route::delete('/team/ebook-bookings/{vbooking}','App\Http\Controllers\Teams\EbookBookingController@destroy')->middleware('role:Team');

// team manual booking mgmt
Route::get('/team/manual-bookings','App\Http\Controllers\Teams\ManualBookingController@index')->middleware('role:Team');
Route::get('/team/manual-bookings/{booking}/edit','App\Http\Controllers\Teams\ManualBookingController@edit')->middleware('role:Team');
Route::patch('/team/manual-bookings/{booking}','App\Http\Controllers\Teams\ManualBookingController@update')->middleware('role:Team');
Route::delete('/team/manual-bookings/{booking}','App\Http\Controllers\Teams\ManualBookingController@destroy')->middleware('role:Team');

// team followup mgmt
Route::get('/team/followup/pending','App\Http\Controllers\Teams\FollowupController@pending')->middleware('role:Team');
Route::get('/team/followup/followed','App\Http\Controllers\Teams\FollowupController@followed')->middleware('role:Team');

Route::get('/team/followup/pending/registered-users','App\Http\Controllers\Teams\FollowupUserController@pendingUserFollowup')->middleware('role:Team');
Route::post('/team/followup/pending/registered-users/add','App\Http\Controllers\Teams\FollowupUserController@addPendingUserFollowup')->middleware('role:Team');
Route::get('/team/followup/followed/registered-users','App\Http\Controllers\Teams\FollowupUserController@followedUserFollowup')->middleware('role:Team');
Route::post('/team/followup/followed/registered-users/update','App\Http\Controllers\Teams\FollowupUserController@updateFollowedUserFollowup')->middleware('role:Team');
Route::get('/team/followup/followed/registered-users/{followup}','App\Http\Controllers\Teams\FollowupUserController@showFollowedUser')->middleware('role:Team');

Route::get('/team/followup/pending/admin-forms','App\Http\Controllers\Teams\FollowupAdminFormController@pendingFollowupList')->middleware('role:Team');
Route::get('/team/followup/pending/admin-forms/{assignId}/applicants','App\Http\Controllers\Teams\FollowupAdminFormController@pendingFollowupApplicantList')->middleware('role:Team');
Route::post('/team/followup/pending/admin-forms/{assignId}/applicants/add','App\Http\Controllers\Teams\FollowupAdminFormController@addPendingFollowupApplicant')->middleware('role:Team');
Route::get('/team/followup/followed/admin-forms','App\Http\Controllers\Teams\FollowupAdminFormController@followedFollowupList')->middleware('role:Team');
Route::get('/team/followup/followed/admin-forms/{assignId}/applicants','App\Http\Controllers\Teams\FollowupAdminFormController@followedFollowupApplicantList')->middleware('role:Team');
Route::post('/team/followup/followed/admin-forms/{assignId}/applicants/update','App\Http\Controllers\Teams\FollowupAdminFormController@updateFollowedApplicant')->middleware('role:Team');
Route::get('/team/followup/followed/admin-forms/{assignId}/applicants/{followup}','App\Http\Controllers\Teams\FollowupAdminFormController@showFollowedApplicant')->middleware('role:Team');

Route::get('/team/followup/pending/vendor-forms','App\Http\Controllers\Teams\FollowupVendorFormController@pendingFollowupList')->middleware('role:Team');
Route::get('/team/followup/pending/vendor-forms/{assignId}/applicants','App\Http\Controllers\Teams\FollowupVendorFormController@pendingFollowupApplicantList')->middleware('role:Team');
Route::post('/team/followup/pending/vendor-forms/{assignId}/applicants/add','App\Http\Controllers\Teams\FollowupVendorFormController@addPendingFollowupApplicant')->middleware('role:Team');
Route::get('/team/followup/followed/vendor-forms','App\Http\Controllers\Teams\FollowupVendorFormController@followedFollowupList')->middleware('role:Team');
Route::get('/team/followup/followed/vendor-forms/{assignId}/applicants','App\Http\Controllers\Teams\FollowupVendorFormController@followedFollowupApplicantList')->middleware('role:Team');
Route::post('/team/followup/followed/vendor-forms/{assignId}/applicants/update','App\Http\Controllers\Teams\FollowupVendorFormController@updateFollowedApplicant')->middleware('role:Team');
Route::get('/team/followup/followed/vendor-forms/{assignId}/applicants/{followup}','App\Http\Controllers\Teams\FollowupVendorFormController@showFollowedApplicant')->middleware('role:Team');

















/*---------------------------------all branch panel routes--------------------------------------*/
// Route::get('/branch/home','App\Http\Controllers\Branches\BranchHomeController@home')->middleware('role:Branch');

// //branch users all students
// Route::get('/branch/all-students','App\Http\Controllers\Branches\Users\StudentController@allStudents')->middleware('role:Branch');
// Route::get('/branch/all-students/{user}/edit','App\Http\Controllers\Branches\Users\StudentController@editStudent')->middleware('role:Branch');
// Route::patch('/branch/all-students/{user}','App\Http\Controllers\Branches\Users\StudentController@updateStudent')->middleware('role:Branch');

// //branch users members
// Route::get('/branch/members','App\Http\Controllers\Branches\Users\MemberController@index')->middleware('role:Branch');
// Route::get('/branch/members/create','App\Http\Controllers\Branches\Users\MemberController@create')->middleware('role:Branch');
// Route::post('/branch/members','App\Http\Controllers\Branches\Users\MemberController@store')->middleware('role:Branch');
// Route::get('/branch/members/{member}/edit','App\Http\Controllers\Branches\Users\MemberController@edit')->middleware('role:Branch');
// Route::patch('/branch/members/{member}','App\Http\Controllers\Branches\Users\MemberController@update')->middleware('role:Branch');
// Route::delete('/branch/members/{member}','App\Http\Controllers\Branches\Users\MemberController@destroy')->middleware('role:Branch');













/*---------------------------------all special integrated routes--------------------------------------*/

//final routes for classroom section
Route::get('/classroom/chat/{batch}','App\Http\Controllers\classroom\ChatController@index');
Route::post('/classroom/chat/{batch}','App\Http\Controllers\classroom\ChatController@store');

Route::get('/classroom/files/{batch}/all','App\Http\Controllers\classroom\FileController@index');
Route::get('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@fileUnits');
Route::get('/classroom/files/{batch}/unit/{unit}','App\Http\Controllers\classroom\FileController@unitFiles');
Route::post('/classroom/files/{batch}/unit/{unit}','App\Http\Controllers\classroom\FileController@saveUnitFile');
Route::post('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@store');
Route::get('/classroom/view/{id}','App\Http\Controllers\classroom\FileController@view');
Route::delete('/classroom/files/{batch}/{file}','App\Http\Controllers\classroom\FileController@destroy')->middleware('role:Admin');
Route::patch('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@update');

Route::get('/classroom/videos/{batch}/all','App\Http\Controllers\classroom\VideoController@index');
Route::get('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@videoUnits');
Route::get('/classroom/videos/{batch}/unit/{unit}','App\Http\Controllers\classroom\VideoController@videoUnitsVideos');
Route::post('/classroom/videos/{batch}/unit/{unit}','App\Http\Controllers\classroom\VideoController@savevideoUnitsVideo');
Route::post('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@store');
Route::delete('/classroom/videos/{batch}/{video}','App\Http\Controllers\classroom\VideoController@destroy')->middleware('role:Admin');
Route::patch('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@update');

//assignment mgmt student classrooom
Route::get('/classroom/assignments/{batch}','App\Http\Controllers\classroom\AssignmentController@index');
Route::post('/classroom/assignments/{batch}','App\Http\Controllers\classroom\AssignmentController@store');
Route::get('/classroom/assignments/{batch}/{assignment}/solve','App\Http\Controllers\classroom\AssignmentController@solve');
Route::post('/classroom/assignments/{batch}/{assignment}/save','App\Http\Controllers\classroom\AssignmentController@save');
Route::get('/classroom/assignments/{batch}/{assignment}/view','App\Http\Controllers\classroom\AssignmentController@view');

//schedules for classroom
Route::get('/classroom/schedules/{batch}','App\Http\Controllers\classroom\ScheduleController@classroomindex');

//common question collection (cqc) for classroom
Route::get('/classroom/cqcs/{batch}','App\Http\Controllers\classroom\CQCController@index');
Route::post('/classroom/cqcs/{batch}','App\Http\Controllers\classroom\CQCController@store');
Route::delete('/classroom/cqcs/{batch}/{question}','App\Http\Controllers\classroom\CQCController@destroy');

//classroom batch exams
Route::get('/student/classroom/exams/{batch}','App\Http\Controllers\student\Exams\ExamController@index');
Route::get('/student/classroom/exams/{batch}/mcq-exams/{exam}/attempt','App\Http\Controllers\student\Exams\ExamController@takeExam');
Route::post('/student/classroom/exams/{batch}/mcq-exams/{exam}/result','App\Http\Controllers\student\Exams\ExamController@store')->middleware('role:Student');
Route::get('/student/classroom/exams/{batch}/mcq-exams/{exam}/view','App\Http\Controllers\student\Exams\ExamController@show');
Route::delete('/student/classroom/exams/{batch}/mcq-exams/{exam}/reset','App\Http\Controllers\student\Exams\ExamController@reset')->middleware('role:Student');


// Route::get('/student/{batch}/written-exams/{exam}/solve','App\Http\Controllers\student\Exams\WrittenExamController@solve')->middleware('role:Student');
// Route::post('/student/{batch}/written-exams/{exam}','App\Http\Controllers\student\Exams\WrittenExamController@save')->middleware('role:Student');
// Route::get('/student/{batch}/written-exams/{exam}/view','App\Http\Controllers\student\Exams\WrittenExamController@view')->middleware('role:Student');


//final routes for special course classroom section
Route::get('/special-course/classroom/chat/{course}','App\Http\Controllers\classroom\TutorCourse\ChatController@index');
Route::post('/special-course/classroom/chat/{course}','App\Http\Controllers\classroom\TutorCourse\ChatController@store');

Route::get('/special-course/classroom/files/{course}','App\Http\Controllers\classroom\TutorCourse\FileController@index');
Route::post('/special-course/classroom/files/{course}','App\Http\Controllers\classroom\TutorCourse\FileController@store');
Route::get('/special-course/classroom/view/{id}','App\Http\Controllers\classroom\TutorCourse\FileController@view');
Route::delete('/special-course/classroom/files/{course}/{file}','App\Http\Controllers\classroom\TutorCourse\FileController@destroy')->middleware('role:Admin');


Route::get('/special-course/classroom/videos/{course}','App\Http\Controllers\classroom\TutorCourse\VideoController@index');
Route::post('/special-course/classroom/videos/{course}','App\Http\Controllers\classroom\TutorCourse\VideoController@store');
Route::delete('/special-course/classroom/videos/{course}/{video}','App\Http\Controllers\classroom\TutorCourse\VideoController@destroy')->middleware('role:Admin');













/*---------------------------------all front public routes--------------------------------------*/

// front details routes
Route::get('/privacy', 'App\Http\Controllers\FrontController@privacy');
Route::get('/about-us', 'App\Http\Controllers\FrontController@about');
Route::get('/search','App\Http\Controllers\SearchController@search');
Route::get('/popular-courses', 'App\Http\Controllers\FrontController@popularcourse');
Route::get('/running-batches', 'App\Http\Controllers\FrontController@runningbatch');
Route::get('/free-videos', 'App\Http\Controllers\FrontController@freevideos');
Route::get('/notice', 'App\Http\Controllers\FrontController@notice');
Route::get('/contact', 'App\Http\Controllers\FrontController@contact');
Route::get('/tutors', 'App\Http\Controllers\FrontController@tutors');
Route::get('/syllabus', 'App\Http\Controllers\FrontController@syllabus');
Route::get('/study-materials', 'App\Http\Controllers\FrontController@materials');
Route::get('/enquiry', 'App\Http\Controllers\FrontController@enquiry');
Route::get('/enquiry/{courseslug}', 'App\Http\Controllers\FrontController@showCourseEnquiryForm');

Route::get('/category/{slug}', 'App\Http\Controllers\FrontController@courselist');
Route::get('/courses', 'App\Http\Controllers\FrontController@categorylist');
Route::get('/courses/{slug}', 'App\Http\Controllers\FrontController@coursedetails');
Route::get('/courses/{courseslug}/{batchslug}', 'App\Http\Controllers\FrontController@batchdetails');

// front manual booking
Route::get('/manual-booking', 'App\Http\Controllers\ManualBookingController@create');
Route::post('/manual-booking','App\Http\Controllers\ManualBookingController@store');
Route::get('/{id}/manual-booking', 'App\Http\Controllers\ManualBookingController@teamCreate');
Route::post('/{id}/manual-booking','App\Http\Controllers\ManualBookingController@teamStore');

// front blogs
Route::get('/blogs','App\Http\Controllers\Blog\BlogController@index');
Route::get('/blogs/{slug}','App\Http\Controllers\Blog\BlogController@show');
Route::post('/blogs/{blog}/comments/add','App\Http\Controllers\Blog\BlogController@addComments');

//front tutor mgmt
Route::get('/tutor/{slug}', 'App\Http\Controllers\FrontController@tutorDetails');
Route::post('/tutor/{tutor}/review/add', 'App\Http\Controllers\FrontController@saveReview');

//front tutor post controller
Route::get('/tutor-posts/{slug}', 'App\Http\Controllers\FrontTutorPostController@post');
Route::post('/tutor-posts/{post}/comments/add','App\Http\Controllers\student\StudentHomeController@addComments')->middleware('role:Student');

//front public exams mgmt
Route::get('/public-exams', 'App\Http\Controllers\PublicExamController@examlist');
Route::get('/public-exams/{examslug}', 'App\Http\Controllers\PublicExamController@examform');
Route::post('/public-exams/{examslug}/attempt', 'App\Http\Controllers\PublicExamController@examshow');
Route::post('/public-exams/{examslug}/save', 'App\Http\Controllers\PublicExamController@examsave');

//front public exams results
Route::get('/results', 'App\Http\Controllers\PublicExamController@resultlist');
Route::get('/results/{examslug}', 'App\Http\Controllers\PublicExamController@resultshow');

//front premium exams section
Route::get('/exam-hall/premium/{slug}', 'App\Http\Controllers\PublicExamController@premiumExamShow');

// front Korea-EPS Registration
Route::get('/eps-registration', 'App\Http\Controllers\EpsKoreaController@create');
Route::post('/eps-registration','App\Http\Controllers\EpsKoreaController@store');

//front ebooks
Route::get('/ebooks','App\Http\Controllers\FrontEbookController@ebookList');
Route::get('/ebooks/{slug}','App\Http\Controllers\FrontEbookController@ebookShow');

//front video course
Route::get('/video-courses','App\Http\Controllers\FrontVideoCourseController@allCourses');
Route::get('/video-courses/category/{slug}','App\Http\Controllers\FrontVideoCourseController@categoryCourses');
Route::get('/video-courses/video/{slug}','App\Http\Controllers\FrontVideoCourseController@videoShow');
Route::get('/video-courses/{slug}','App\Http\Controllers\FrontVideoCourseController@courseShow');

// front careers
Route::get('/careers','App\Http\Controllers\FrontCareerController@index');
Route::get('/careers/{slug}','App\Http\Controllers\FrontCareerController@show');
Route::get('/careers/apply/{slug}','App\Http\Controllers\FrontCareerController@showApplyForm');
Route::post('/careers/apply/{slug}','App\Http\Controllers\FrontCareerController@saveApplicant');

//front admin dynamic forms 
Route::get('/forms','App\Http\Controllers\FrontDynamicFormController@formList');
Route::get('/forms/{slug}','App\Http\Controllers\FrontDynamicFormController@showForm');
Route::post('/forms/{slug}','App\Http\Controllers\FrontDynamicFormController@saveApplicant');

//front vendor dynamic forms
Route::get('/vendor-forms/{slug}','App\Http\Controllers\FrontDynamicFormController@showVendorForm');
Route::post('/vendor-forms/{slug}','App\Http\Controllers\FrontDynamicFormController@saveVendorFormApplicant');


// user free live class
Route::post('/free-live-classes/join','App\Http\Controllers\FrontController@joinLiveClass');
