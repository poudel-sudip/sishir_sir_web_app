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



Route::get('/', function(){ return view('welcome'); });



/*-------------------------------special routes section---------------------------*/

Auth::routes();

Route::get('change-password', 'App\Http\Controllers\Auth\ChangePasswordController@index');
Route::post('change-password', 'App\Http\Controllers\Auth\ChangePasswordController@store')->name('change.password');
Route::get('/profile', 'App\Http\Controllers\profile\ProfileController@index');
Route::get('/profile/edit', 'App\Http\Controllers\profile\ProfileController@edit');
Route::patch('/profile', 'App\Http\Controllers\profile\ProfileController@update');









/*-------------------------------all admin section routes---------------------------*/

//final routes for admin section
Route::get('/admin/home', 'App\Http\Controllers\Admin\AdminHomeController@index')->middleware('role:Admin');

//admin user mgmt
Route::get('/admin/users','App\Http\Controllers\Admin\Users\UsersController@index')->middleware('role:Admin');
Route::get('/admin/users/create','App\Http\Controllers\Admin\Users\UsersController@create')->middleware('role:Admin');
Route::post('/admin/users','App\Http\Controllers\Admin\Users\UsersController@store')->middleware('role:Admin');
Route::get('/admin/users/{user}','App\Http\Controllers\Admin\Users\UsersController@show')->middleware('role:Admin');
Route::get('/admin/users/{user}/edit','App\Http\Controllers\Admin\Users\UsersController@edit')->middleware('role:Admin');
Route::patch('/admin/users/{user}','App\Http\Controllers\Admin\Users\UsersController@update')->middleware('role:Admin');
Route::delete('/admin/users/{user}','App\Http\Controllers\Admin\Users\UsersController@destroy')->middleware('role:Admin');

// admin course categories mgmt
Route::get('/admin/categories', 'App\Http\Controllers\Admin\Courses\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/categories/create', 'App\Http\Controllers\Admin\Courses\CategoryController@create')->middleware('role:Admin');
Route::get('/admin/categories/{category}/edit', 'App\Http\Controllers\Admin\Courses\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/categories/{category}', 'App\Http\Controllers\Admin\Courses\CategoryController@update')->middleware('role:Admin');
Route::post('/admin/categories','App\Http\Controllers\Admin\Courses\CategoryController@store')->middleware('role:Admin');
Route::delete('/admin/categories/{categories}','App\Http\Controllers\Admin\Courses\CategoryController@destroy')->middleware('role:Admin');

//admin courses mgmt
Route::get('/admin/courses','App\Http\Controllers\Admin\Courses\CoursesController@index')->middleware('role:Admin');
Route::get('/admin/courses/create','App\Http\Controllers\Admin\Courses\CoursesController@create')->middleware('role:Admin');
Route::get('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@show')->middleware('role:Admin');
Route::get('/admin/courses/{course}/edit','App\Http\Controllers\Admin\Courses\CoursesController@edit')->middleware('role:Admin');
Route::post('/admin/courses','App\Http\Controllers\Admin\Courses\CoursesController@store')->middleware('role:Admin');
Route::patch('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@update')->middleware('role:Admin');
Route::delete('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@destroy')->middleware('role:Admin');

// admin course featurs
Route::get('/admin/courses/{course}/features','App\Http\Controllers\Admin\Courses\CourseFeaturesController@index')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/create','App\Http\Controllers\Admin\Courses\CourseFeaturesController@create')->middleware('role:Admin');
Route::post('/admin/courses/{course}/features','App\Http\Controllers\Admin\Courses\CourseFeaturesController@store')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@show')->middleware('role:Admin');
Route::get('/admin/courses/{course}/features/{feature}/edit','App\Http\Controllers\Admin\Courses\CourseFeaturesController@edit')->middleware('role:Admin');
Route::patch('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@update')->middleware('role:Admin');
Route::delete('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@destroy')->middleware('role:Admin');

//course batches
Route::get('/admin/courses/{course}/batches','App\Http\Controllers\Admin\Courses\CourseBatchesController@index')->middleware('role:Admin');
Route::get('/courses/{course}/batchnames','App\Http\Controllers\Admin\Courses\CourseBatchesController@display');

//admin batches mgmt 
Route::get('/admin/batches', 'App\Http\Controllers\Admin\Courses\BatchController@index')->middleware('role:Admin');
Route::get('/admin/batches/create', 'App\Http\Controllers\Admin\Courses\BatchController@create')->middleware('role:Admin');
Route::post('/admin/batches','App\Http\Controllers\Admin\Courses\BatchController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@show')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/edit', 'App\Http\Controllers\Admin\Courses\BatchController@edit')->middleware('role:Admin');
Route::patch('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@update')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@destroy')->middleware('role:Admin');

//admin single batch bookings
Route::get('/admin/batches/{batch}/bookings','App\Http\Controllers\Admin\Courses\BatchBookingsController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/bookings/{booking}/edit','App\Http\Controllers\Admin\Courses\BatchBookingsController@edit')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@show')->middleware('role:Admin');
Route::patch('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@update')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@destroy')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/Verified','App\Http\Controllers\Admin\Courses\BatchBookingsController@verifiedstatus')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/Unverified','App\Http\Controllers\Admin\Courses\BatchBookingsController@unverifiedstatus')->middleware('role:Admin');

Route::get('/admin/bookings','App\Http\Controllers\Admin\Courses\BookingsController@index')->middleware('role:Admin');
Route::get('/admin/bookings/all','App\Http\Controllers\Admin\Courses\BookingsController@allBookings')->middleware('role:Admin');
Route::get('/admin/bookings/create','App\Http\Controllers\Admin\Courses\BookingsController@create')->middleware('role:Admin');
Route::get('/admin/bookings/verifylist','App\Http\Controllers\Admin\Courses\BookingsController@verifylist')->middleware('role:Admin');
Route::get('/admin/bookings/duelist','App\Http\Controllers\Admin\Courses\BookingsController@duelist')->middleware('role:Admin');
Route::get('/admin/bookings/unverifiedlist','App\Http\Controllers\Admin\Courses\BookingsController@unverifiedlist')->middleware('role:Admin');
Route::get('/admin/bookings/suspendedlist','App\Http\Controllers\Admin\Courses\BookingsController@suspendedlist')->middleware('role:Admin');
Route::post('/admin/bookings','App\Http\Controllers\Admin\Courses\BookingsController@store')->middleware('role:Admin');
Route::get('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@show')->middleware('role:Admin');
Route::get('/admin/bookings/{booking}/edit','App\Http\Controllers\Admin\Courses\BookingsController@edit')->middleware('role:Admin');
Route::patch('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@update')->middleware('role:Admin');
Route::delete('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@destroy')->middleware('role:Admin');

//admin mcq exam category
Route::get('/admin/exam-category','App\Http\Controllers\Admin\Exams\ExamCategoryController@index')->middleware('role:Admin');
Route::get('/admin/exam-category/create','App\Http\Controllers\Admin\Exams\ExamCategoryController@create')->middleware('role:Admin');
Route::post('/admin/exam-category','App\Http\Controllers\Admin\Exams\ExamCategoryController@store')->middleware('role:Admin');
Route::delete('/admin/exam-category/{category}','App\Http\Controllers\Admin\Exams\ExamCategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/exams','App\Http\Controllers\Admin\Exams\ExamCategoryController@exams')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/getexams','App\Http\Controllers\Admin\Exams\ExamCategoryController@catExams')->middleware('role:Admin');

//admin mcq exam mgmt
Route::get('/admin/exams','App\Http\Controllers\Admin\Exams\ExamController@index')->middleware('role:Admin');
Route::get('/admin/exams/create','App\Http\Controllers\Admin\Exams\ExamController@create')->middleware('role:Admin');
Route::post('/admin/exams','App\Http\Controllers\Admin\Exams\ExamController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}','App\Http\Controllers\Admin\Exams\ExamController@show')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/edit','App\Http\Controllers\Admin\Exams\ExamController@edit')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}','App\Http\Controllers\Admin\Exams\ExamController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}','App\Http\Controllers\Admin\Exams\ExamController@destroy')->middleware('role:Admin');

// admin mcq exam questions
Route::get('/admin/exams/{exam}/questions','App\Http\Controllers\Admin\Exams\QuestionController@index')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/create','App\Http\Controllers\Admin\Exams\QuestionController@create')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/upload','App\Http\Controllers\Admin\Exams\QuestionController@upload')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions/import','App\Http\Controllers\Admin\Exams\QuestionController@import')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions','App\Http\Controllers\Admin\Exams\QuestionController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}/edit','App\Http\Controllers\Admin\Exams\QuestionController@edit')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}/questions/{question}','App\Http\Controllers\Admin\Exams\QuestionController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}/questions/{question}','App\Http\Controllers\Admin\Exams\QuestionController@destroy')->middleware('role:Admin');

//mcq exams associated with batch admin
Route::get('/admin/batches/{batch}/exams','App\Http\Controllers\Admin\Exams\BatchExamController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/create','App\Http\Controllers\Admin\Exams\BatchExamController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/exams','App\Http\Controllers\Admin\Exams\BatchExamController@store')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/exams/{exam}','App\Http\Controllers\Admin\Exams\BatchExamController@destroy')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/{exam}/results','App\Http\Controllers\Admin\Exams\BatchExamController@results')->middleware('role:Admin');

//open mcq exams admin
Route::get('/admin/open-exams','App\Http\Controllers\Admin\Exams\OpenExamController@index')->middleware('role:Admin');
Route::get('/admin/open-exams/create','App\Http\Controllers\Admin\Exams\OpenExamController@create')->middleware('role:Admin');
Route::post('/admin/open-exams','App\Http\Controllers\Admin\Exams\OpenExamController@store')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}','App\Http\Controllers\Admin\Exams\OpenExamController@show')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/edit','App\Http\Controllers\Admin\Exams\OpenExamController@edit')->middleware('role:Admin');
Route::patch('/admin/open-exams/{exam}','App\Http\Controllers\Admin\Exams\OpenExamController@update')->middleware('role:Admin');
Route::delete('/admin/open-exams/{exam}','App\Http\Controllers\Admin\Exams\OpenExamController@destroy')->middleware('role:Admin');

//open mcq exams results admin
Route::get('/admin/open-exams/{exam}/results','App\Http\Controllers\Admin\Exams\OpenExamController@results')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/results/export','App\Http\Controllers\Admin\Exams\OpenExamController@export')->middleware('role:Admin');

//routes for exam hall admin section
Route::get('/admin/exam-hall','App\Http\Controllers\Admin\ExamHall\ExamHallController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/create','App\Http\Controllers\Admin\ExamHall\ExamHallController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall','App\Http\Controllers\Admin\ExamHall\ExamHallController@store')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/edit','App\Http\Controllers\Admin\ExamHall\ExamHallController@edit')->middleware('role:Admin');
Route::patch('/admin/exam-hall/{category}','App\Http\Controllers\Admin\ExamHall\ExamHallController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}','App\Http\Controllers\Admin\ExamHall\ExamHallController@destroy')->middleware('role:Admin');

Route::get('/admin/exam-hall/{category}/exams','App\Http\Controllers\Admin\ExamHall\ExamHallExamController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/create','App\Http\Controllers\Admin\ExamHall\ExamHallExamController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/exams','App\Http\Controllers\Admin\ExamHall\ExamHallExamController@store')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/exams/{exam}','App\Http\Controllers\Admin\ExamHall\ExamHallExamController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/{exam}/results','App\Http\Controllers\Admin\ExamHall\ExamHallExamController@results')->middleware('role:Admin');

//admin section exam hall booking
Route::get('/admin/exam-hall/bookings','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/all','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/create','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@create')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/bookings','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@setBookings')->middleware('role:Admin');
Route::post('/admin/exam-hall/bookings','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@store')->middleware('role:Admin');

Route::get('/admin/exam-hall/bookings/{booking}/edit','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@edit')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@show')->middleware('role:Admin');
Route::patch('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/bookings/{booking}','App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@destroy')->middleware('role:Admin');

//exam hall cqc admin section
Route::get('/admin/exam-hall/{category}/cqc','App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcindex')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/cqc','App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcstore')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/cqc/{cqc}','App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcdestroy')->middleware('role:Admin');






Route::get('/admin/sliders','App\Http\Controllers\Admin\SliderController@index')->middleware('role:Admin');
Route::get('/admin/sliders/create','App\Http\Controllers\Admin\SliderController@create')->middleware('role:Admin');
Route::post('/admin/sliders','App\Http\Controllers\Admin\SliderController@store')->middleware('role:Admin');
Route::get('/admin/sliders/{slider}/edit','App\Http\Controllers\Admin\SliderController@edit')->middleware('role:Admin');
Route::patch('/admin/sliders/{slider}','App\Http\Controllers\Admin\SliderController@update')->middleware('role:Admin');
Route::delete('/admin/sliders/{slider}','App\Http\Controllers\Admin\SliderController@destroy')->middleware('role:Admin');

Route::get('/admin/testimonials','App\Http\Controllers\Admin\TestimonialController@index')->middleware('role:Admin');
Route::get('/admin/testimonials/create','App\Http\Controllers\Admin\TestimonialController@create')->middleware('role:Admin');
Route::post('/admin/testimonials','App\Http\Controllers\Admin\TestimonialController@store')->middleware('role:Admin');
Route::get('/admin/testimonials/{testimonial}/edit','App\Http\Controllers\Admin\TestimonialController@edit')->middleware('role:Admin');
Route::patch('/admin/testimonials/{testimonial}','App\Http\Controllers\Admin\TestimonialController@update')->middleware('role:Admin');
Route::delete('/admin/testimonials/{testimonial}','App\Http\Controllers\Admin\TestimonialController@destroy')->middleware('role:Admin');

Route::get('/admin/notifications','App\Http\Controllers\Admin\NotificationController@index')->middleware('role:Admin');
Route::get('/admin/notifications/create','App\Http\Controllers\Admin\NotificationController@create')->middleware('role:Admin');
Route::post('/admin/notifications','App\Http\Controllers\Admin\NotificationController@store')->middleware('role:Admin');
Route::get('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@show')->middleware('role:Admin');
Route::get('/admin/notifications/{notification}/edit','App\Http\Controllers\Admin\NotificationController@edit')->middleware('role:Admin');
Route::patch('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@update')->middleware('role:Admin');
Route::delete('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@destroy')->middleware('role:Admin');

Route::get('/admin/videos','App\Http\Controllers\Admin\VideoController@index')->middleware('role:Admin');
Route::get('/admin/videos/upload','App\Http\Controllers\Admin\VideoController@upload')->middleware('role:Admin');
Route::post('/admin/videos','App\Http\Controllers\Admin\VideoController@store')->middleware('role:Admin');
Route::delete('/admin/videos/{video}','App\Http\Controllers\Admin\VideoController@destroy')->middleware('role:Admin');

Route::get('/admin/reports','App\Http\Controllers\Admin\Report\ReportController@index')->middleware('role:Admin');

Route::get('/admin/reports/course','App\Http\Controllers\Admin\Report\CourseReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/course/all','App\Http\Controllers\Admin\Report\CourseReportController@courseReport')->middleware('role:Admin');
Route::get('/admin/reports/course/all/export','App\Http\Controllers\Admin\Report\CourseReportController@exportCategoryCourses')->middleware('role:Admin');
Route::get('/admin/reports/course/{course}','App\Http\Controllers\Admin\Report\CourseReportController@courseBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/course/{course}/export','App\Http\Controllers\Admin\Report\CourseReportController@exportCourseBatches')->middleware('role:Admin');

Route::get('/admin/reports/batch','App\Http\Controllers\Admin\Report\BatchReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/all','App\Http\Controllers\Admin\Report\BatchReportController@batchReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/all/export','App\Http\Controllers\Admin\Report\BatchReportController@exportBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/pending','App\Http\Controllers\Admin\Report\BatchReportController@batchPendingReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/pending/export','App\Http\Controllers\Admin\Report\BatchReportController@exportBatchPendingReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/verified','App\Http\Controllers\Admin\Report\BatchReportController@batchVerifiedReport')->middleware('role:Admin');
Route::get('/admin/reports/batch/{batch}/verified/export','App\Http\Controllers\Admin\Report\BatchReportController@exportBatchVerifiedReport')->middleware('role:Admin');

Route::get('/admin/reports/user','App\Http\Controllers\Admin\Report\UserReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/user/all','App\Http\Controllers\Admin\Report\UserReportController@userReport')->middleware('role:Admin');
Route::get('/admin/reports/user/all/export','App\Http\Controllers\Admin\Report\UserReportController@exportUsers')->middleware('role:Admin');

Route::post('/admin/reports/user/filterbydate','App\Http\Controllers\Admin\Report\UserReportController@filterUsersDate')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbydistrict','App\Http\Controllers\Admin\Report\UserReportController@filterUsersDistrict')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbyprovience','App\Http\Controllers\Admin\Report\UserReportController@filterUsersProvience')->middleware('role:Admin');
Route::post('/admin/reports/user/filterbycourse','App\Http\Controllers\Admin\Report\UserReportController@filterUsersCourse')->middleware('role:Admin');
Route::get('/admin/reports/user/filter/{key}/{value}/download','App\Http\Controllers\Admin\Report\UserReportController@filteredUsersDownload')->middleware('role:Admin');


Route::get('/admin/reports/tutor','App\Http\Controllers\Admin\Report\TutorReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/tutor/all','App\Http\Controllers\Admin\Report\TutorReportController@tutorReport')->middleware('role:Admin');
Route::get('/admin/reports/tutor/all/export','App\Http\Controllers\Admin\Report\TutorReportController@exportTutors')->middleware('role:Admin');
Route::get('/admin/reports/tutor/{tutor}/batches','App\Http\Controllers\Admin\Report\TutorReportController@tutorBatchReport')->middleware('role:Admin');
Route::get('/admin/reports/tutor/{tutor}/batches/export','App\Http\Controllers\Admin\Report\TutorReportController@exportTutorBatches')->middleware('role:Admin');

Route::get('/admin/reports/booking','App\Http\Controllers\Admin\Report\BookingReportController@index')->middleware('role:Admin');
Route::get('/admin/reports/booking/all','App\Http\Controllers\Admin\Report\BookingReportController@bookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/all/export','App\Http\Controllers\Admin\Report\BookingReportController@exportBookings')->middleware('role:Admin');
Route::post('/admin/reports/booking/daily','App\Http\Controllers\Admin\Report\BookingReportController@dailyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/daily/{date}/export','App\Http\Controllers\Admin\Report\BookingReportController@dailyBookingsExport')->middleware('role:Admin');
Route::post('/admin/reports/booking/monthly','App\Http\Controllers\Admin\Report\BookingReportController@monthlyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/monthly/{date}/export','App\Http\Controllers\Admin\Report\BookingReportController@monthlyBookingsExport')->middleware('role:Admin');
Route::post('/admin/reports/booking/yearly','App\Http\Controllers\Admin\Report\BookingReportController@yearlyBookingReport')->middleware('role:Admin');
Route::get('/admin/reports/booking/yearly/{date}/export','App\Http\Controllers\Admin\Report\BookingReportController@YearlyBookingsExport')->middleware('role:Admin');

Route::get('/admin/followup','App\Http\Controllers\Admin\FollowupController@index')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/all','App\Http\Controllers\Admin\FollowupController@followupAll')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/batch','App\Http\Controllers\Admin\FollowupController@followupBatch')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/followed','App\Http\Controllers\Admin\FollowupController@followupFollowed')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/all/download','App\Http\Controllers\Admin\FollowupController@downloadFollowupAll')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/batch/download','App\Http\Controllers\Admin\FollowupController@downloadFollowupBatch')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/followup/followed/download','App\Http\Controllers\Admin\FollowupController@downloadFollowupFollowed')->middleware('role:Admin');
Route::get('/admin/batch/{batch}/{user}/followup','App\Http\Controllers\Admin\FollowupController@edit')->middleware('role:Admin');
Route::patch('/admin/batch/{batch}/{user}/followup','App\Http\Controllers\Admin\FollowupController@update')->middleware('role:Admin');

//admin manual bookings
Route::get('/admin/manual-booking','App\Http\Controllers\ManualBookingController@index')->middleware('role:Admin');
Route::get('/admin/manual-booking/{mbooking}/edit','App\Http\Controllers\ManualBookingController@edit')->middleware('role:Admin');
Route::patch('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@update')->middleware('role:Admin');
Route::delete('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@destroy')->middleware('role:Admin');
Route::get('/admin/manual-booking/{id}','App\Http\Controllers\ManualBookingController@view')->middleware('role:Admin');

// admin tutors routes
Route::get('/admin/tutors', 'App\Http\Controllers\Admin\tutors\TutorController@index')->middleware('role:Admin');
Route::get('/admin/tutors/create', 'App\Http\Controllers\Admin\tutors\TutorController@create')->middleware('role:Admin');
Route::post('/admin/tutors', 'App\Http\Controllers\Admin\tutors\TutorController@store')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/edit', 'App\Http\Controllers\Admin\tutors\TutorController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@destroy')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/reviews', 'App\Http\Controllers\Admin\tutors\TutorController@getReviews')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\Admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
Route::put('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\Admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/review/{review}/delete','App\Http\Controllers\Admin\tutors\TutorController@destroyReview')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses', 'App\Http\Controllers\Admin\tutors\TutorCourseController@index')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\Admin\tutors\TutorCourseController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/edit', 'App\Http\Controllers\Admin\tutors\TutorCourseController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\Admin\tutors\TutorCourseController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/courses/{course}', 'App\Http\Controllers\Admin\tutors\TutorCourseController@destroy')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses/{course}/bookings', 'App\Http\Controllers\Admin\tutors\TutorCourseBookingController@index')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\Admin\tutors\TutorCourseBookingController@show')->middleware('role:Admin');
Route::get('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}/edit', 'App\Http\Controllers\Admin\tutors\TutorCourseBookingController@edit')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\Admin\tutors\TutorCourseBookingController@update')->middleware('role:Admin');
Route::delete('/admin/tutors/{tutor}/courses/{course}/bookings/{booking}', 'App\Http\Controllers\Admin\tutors\TutorCourseBookingController@destroy')->middleware('role:Admin');

Route::get('/admin/tutors/{tutor}/courses/{course}/payments', 'App\Http\Controllers\Admin\tutors\TutorPaymentController@index')->middleware('role:Admin');
Route::patch('/admin/tutors/{tutor}/courses/{course}/payments/{pay}', 'App\Http\Controllers\Admin\tutors\TutorPaymentController@update')->middleware('role:Admin');

//blogs managing by admin
Route::get('/admin/blogs','App\Http\Controllers\Admin\Blog\BlogController@index')->middleware('role:Admin');
Route::get('/admin/blogs/create','App\Http\Controllers\Admin\Blog\BlogController@create')->middleware('role:Admin');
Route::post('/admin/blogs','App\Http\Controllers\Admin\Blog\BlogController@store')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}','App\Http\Controllers\Admin\Blog\BlogController@show')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/edit','App\Http\Controllers\Admin\Blog\BlogController@edit')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}','App\Http\Controllers\Admin\Blog\BlogController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}','App\Http\Controllers\Admin\Blog\BlogController@destroy')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/comments','App\Http\Controllers\Admin\Blog\CommentController@index')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}/comment/{comment}/{status}','App\Http\Controllers\Admin\Blog\CommentController@update')->middleware('role:Admin');
Route::put('/admin/blogs/{blog}/comment/{comment}/{status}','App\Http\Controllers\Admin\Blog\CommentController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}/comment/{comment}/delete','App\Http\Controllers\Admin\Blog\CommentController@destroy')->middleware('role:Admin');

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
Route::get('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@index')->middleware('role:Admin');
Route::get('/admin/free-videos/create','App\Http\Controllers\Admin\FreeVideoController@create')->middleware('role:Admin');
Route::post('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@store')->middleware('role:Admin');
Route::delete('/admin/free-videos/{video}','App\Http\Controllers\Admin\FreeVideoController@destroy')->middleware('role:Admin');

//admin zoom meetings management
Route::get('/admin/zoom/meetings','App\Http\Controllers\Zoom\MeetingController@list')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/create','App\Http\Controllers\Zoom\MeetingController@add')->middleware('role:Admin');
Route::post('/admin/zoom/meetings','App\Http\Controllers\Zoom\MeetingController@create')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@get')->middleware('role:Admin');
Route::get('/admin/zoom/meetings/{id}/edit','App\Http\Controllers\Zoom\MeetingController@edit')->middleware('role:Admin');
Route::patch('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@update')->middleware('role:Admin');
Route::delete('/admin/zoom/meetings/{id}','App\Http\Controllers\Zoom\MeetingController@delete')->middleware('role:Admin');


//assignment admin mgmt
Route::get('/admin/batches/{batch}/assignments','App\Http\Controllers\Admin\AssignmentController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/create','App\Http\Controllers\Admin\AssignmentController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/assignments','App\Http\Controllers\Admin\AssignmentController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/{assignment}/answers','App\Http\Controllers\Admin\AssignmentController@answers')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/assignments/{assignment}/answers/{answer}','App\Http\Controllers\Admin\AssignmentController@answerview')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/assignments/{assignment}/answers/{answer}','App\Http\Controllers\Admin\AssignmentController@remarks')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/assignments/{assignment}','App\Http\Controllers\Admin\AssignmentController@destroy')->middleware('role:Admin');


//written exams admin
Route::get('/admin/batches/{batch}/written-exams','App\Http\Controllers\Admin\Exams\WrittenExamController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/create','App\Http\Controllers\Admin\Exams\WrittenExamController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/written-exams','App\Http\Controllers\Admin\Exams\WrittenExamController@store')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/{exam}/solutions','App\Http\Controllers\Admin\Exams\WrittenExamController@solutions')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/written-exams/{exam}/solutions/{solution}','App\Http\Controllers\Admin\Exams\WrittenExamController@solutionview')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/written-exams/{exam}/solutions/{solution}','App\Http\Controllers\Admin\Exams\WrittenExamController@remarks')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/written-exams/{exam}','App\Http\Controllers\Admin\Exams\WrittenExamController@destroy')->middleware('role:Admin');

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



//syllabus management admin
Route::resource('/admin/syllabus', App\Http\Controllers\Admin\SyllabusController::class)->middleware('role:Admin');
Route::get('/admin/syllabus/{id}/delete', [App\Http\Controllers\Admin\SyllabusController::class,'destroy']);

//study Materials management admin
Route::resource('/admin/studyMaterials', App\Http\Controllers\Admin\StudyMaterialController::class)->middleware('role:Admin');
Route::get('/admin/studyMaterials/{id}/delete', [App\Http\Controllers\Admin\StudyMaterialController::class,'destroy']);


//admin accounts mgmt
Route::get('/admin/accounts/incomes','App\Http\Controllers\Admin\Accounts\IncomeController@index')->middleware('role:Admin');
Route::get('/admin/accounts/incomes/courses/add','App\Http\Controllers\Admin\Accounts\IncomeController@addCourseIncome')->middleware('role:Admin');
Route::get('/admin/accounts/incomes/others/add','App\Http\Controllers\Admin\Accounts\IncomeController@addOtherIncome')->middleware('role:Admin');
Route::post('/admin/accounts/incomes/courses','App\Http\Controllers\Admin\Accounts\IncomeController@storeCourseIncome')->middleware('role:Admin');
Route::post('/admin/accounts/incomes/others','App\Http\Controllers\Admin\Accounts\IncomeController@storeOtherIncome')->middleware('role:Admin');
Route::delete('/admin/accounts/incomes/{income}','App\Http\Controllers\Admin\Accounts\IncomeController@destroy')->middleware('role:Admin');

Route::get('/admin/accounts/expenses','App\Http\Controllers\Admin\Accounts\ExpenseController@index')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/tutor','App\Http\Controllers\Admin\Accounts\ExpenseController@addTutorSalary')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/tutor','App\Http\Controllers\Admin\Accounts\ExpenseController@storeTutorSalary')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/staff','App\Http\Controllers\Admin\Accounts\ExpenseController@addStaffSalary')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/staff','App\Http\Controllers\Admin\Accounts\ExpenseController@storeStaffSalary')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/refund','App\Http\Controllers\Admin\Accounts\ExpenseController@addRefund')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/refund','App\Http\Controllers\Admin\Accounts\ExpenseController@storeRefund')->middleware('role:Admin');
Route::get('/admin/accounts/expenses/others','App\Http\Controllers\Admin\Accounts\ExpenseController@addOtherExpenses')->middleware('role:Admin');
Route::post('/admin/accounts/expenses/others','App\Http\Controllers\Admin\Accounts\ExpenseController@storeOtherExpenses')->middleware('role:Admin');
Route::delete('/admin/accounts/expenses/{expense}','App\Http\Controllers\Admin\Accounts\ExpenseController@destroy')->middleware('role:Admin');

Route::get('/admin/accounts/reports','App\Http\Controllers\Admin\Accounts\ReportController@index')->middleware('role:Admin');

Route::get('/admin/accounts/reports/incomes','App\Http\Controllers\Admin\Accounts\IncomeReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/course','App\Http\Controllers\Admin\Accounts\IncomeReportController@courseIncomeReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/incomes/others','App\Http\Controllers\Admin\Accounts\IncomeReportController@otherIncomeReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/daily','App\Http\Controllers\Admin\Accounts\IncomeReportController@dailyIncomeReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/incomes/monthly','App\Http\Controllers\Admin\Accounts\IncomeReportController@monthlyIncomeReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/incomes/deleted','App\Http\Controllers\Admin\Accounts\IncomeReportController@deletedIncomeReport')->middleware('role:Admin');
Route::patch('/admin/accounts/reports/incomes/deleted/{income}','App\Http\Controllers\Admin\Accounts\IncomeReportController@restoreIncomeReport')->middleware('role:Admin');

Route::get('/admin/accounts/reports/expenses','App\Http\Controllers\Admin\Accounts\ExpenseReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/tutor','App\Http\Controllers\Admin\Accounts\ExpenseReportController@tutorExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/course','App\Http\Controllers\Admin\Accounts\ExpenseReportController@courseExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/staff','App\Http\Controllers\Admin\Accounts\ExpenseReportController@staffExpenseReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/expenses/others','App\Http\Controllers\Admin\Accounts\ExpenseReportController@otherExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/daily','App\Http\Controllers\Admin\Accounts\ExpenseReportController@dailyExpenseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/expenses/monthly','App\Http\Controllers\Admin\Accounts\ExpenseReportController@monthlyExpenseReport')->middleware('role:Admin');
Route::get('/admin/accounts/reports/expenses/deleted','App\Http\Controllers\Admin\Accounts\ExpenseReportController@deletedExpenseReport')->middleware('role:Admin');
Route::patch('/admin/accounts/reports/expenses/deleted/{expense}','App\Http\Controllers\Admin\Accounts\ExpenseReportController@restoreExpenseReport')->middleware('role:Admin');

Route::get('/admin/accounts/reports/gross','App\Http\Controllers\Admin\Accounts\GrossReportController@index')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/course','App\Http\Controllers\Admin\Accounts\GrossReportController@courseReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/daily','App\Http\Controllers\Admin\Accounts\GrossReportController@dailyReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/monthly','App\Http\Controllers\Admin\Accounts\GrossReportController@monthlyReport')->middleware('role:Admin');
Route::post('/admin/accounts/reports/gross/yearly','App\Http\Controllers\Admin\Accounts\GrossReportController@yearlyReport')->middleware('role:Admin');

//admin collections 
Route::get('/admin/accounts/collections','App\Http\Controllers\Admin\Accounts\ReportController@collections')->middleware('role:Admin');

//routes for sms sections
Route::get('/admin/sms','App\Http\Controllers\Admin\SMSController@index')->middleware('role:Admin');
Route::get('/admin/sms/create','App\Http\Controllers\Admin\SMSController@create')->middleware('role:Admin');
Route::post('/admin/sms','App\Http\Controllers\Admin\SMSController@store')->middleware('role:Admin');

//admin vendor routes
Route::get('/admin/vendor','App\Http\Controllers\Admin\Vendors\VendorController@index')->middleware('role:Admin');
Route::get('/admin/vendor/create','App\Http\Controllers\Admin\Vendors\VendorController@create')->middleware('role:Admin');
Route::post('/admin/vendor','App\Http\Controllers\Admin\Vendors\VendorController@store')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}','App\Http\Controllers\Admin\Vendors\VendorController@show')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/edit','App\Http\Controllers\Admin\Vendors\VendorController@edit')->middleware('role:Admin');
Route::patch('/admin/vendor/{vendor}','App\Http\Controllers\Admin\Vendors\VendorController@update')->middleware('role:Admin');
Route::delete('/admin/vendor/{vendor}','App\Http\Controllers\Admin\Vendors\VendorController@destroy')->middleware('role:Admin');

//admin vendor bookings
Route::get('/admin/vendor/{vendor}/bookings/course','App\Http\Controllers\Admin\Vendors\BookingController@courseBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/exam','App\Http\Controllers\Admin\Vendors\BookingController@examBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/video','App\Http\Controllers\Admin\Vendors\BookingController@videoBookings')->middleware('role:Admin');
Route::get('/admin/vendor/{vendor}/bookings/ebook','App\Http\Controllers\Admin\Vendors\BookingController@ebookBookings')->middleware('role:Admin');

//admin vendor users
Route::get('/admin/vendor/{vendor}/students','App\Http\Controllers\Admin\Vendors\VendorController@students')->middleware('role:Admin');


//admin video course categories
Route::get('/admin/video-category','App\Http\Controllers\Admin\Video\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/video-category/create','App\Http\Controllers\Admin\Video\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/video-category','App\Http\Controllers\Admin\Video\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/video-category/{category}/edit','App\Http\Controllers\Admin\Video\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/video-category/{category}','App\Http\Controllers\Admin\Video\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/video-category/{category}','App\Http\Controllers\Admin\Video\CategoryController@destroy')->middleware('role:Admin');

//admin video courses
Route::get('/admin/video-course','App\Http\Controllers\Admin\Video\CourseController@index')->middleware('role:Admin');
Route::get('/admin/video-course/create','App\Http\Controllers\Admin\Video\CourseController@create')->middleware('role:Admin');
Route::post('/admin/video-course','App\Http\Controllers\Admin\Video\CourseController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@show')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/edit','App\Http\Controllers\Admin\Video\CourseController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@destroy')->middleware('role:Admin');

Route::get('/admin/video-course/{course}/booking','App\Http\Controllers\Admin\Video\CourseController@booking')->middleware('role:Admin');

//admin video course chapters
Route::get('/admin/video-course/{course}/chapters','App\Http\Controllers\Admin\Video\ChapterController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/create','App\Http\Controllers\Admin\Video\ChapterController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/chapters','App\Http\Controllers\Admin\Video\ChapterController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/edit','App\Http\Controllers\Admin\Video\ChapterController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\Admin\Video\ChapterController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\Admin\Video\ChapterController@destroy')->middleware('role:Admin');

//admin video course chapters video posts
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\Admin\Video\VideoController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/create','App\Http\Controllers\Admin\Video\VideoController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\Admin\Video\VideoController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@show')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}/edit','App\Http\Controllers\Admin\Video\VideoController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@destroy')->middleware('role:Admin');

//admin video course bookings
Route::get('/admin/video-booking','App\Http\Controllers\Admin\Video\BookingController@index')->middleware('role:Admin');
Route::get('/admin/video-booking/all','App\Http\Controllers\Admin\Video\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/video-booking/create','App\Http\Controllers\Admin\Video\BookingController@create')->middleware('role:Admin');
Route::post('/admin/video-booking','App\Http\Controllers\Admin\Video\BookingController@store')->middleware('role:Admin');
Route::get('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@show')->middleware('role:Admin');
Route::get('/admin/video-booking/{booking}/edit','App\Http\Controllers\Admin\Video\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@destroy')->middleware('role:Admin');

//admin video course mcq exams
Route::get('/admin/video-course/{course}/exams','App\Http\Controllers\Admin\Video\ExamController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/exams/create','App\Http\Controllers\Admin\Video\ExamController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/exams','App\Http\Controllers\Admin\Video\ExamController@store')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/exams/{exam}','App\Http\Controllers\Admin\Video\ExamController@destroy')->middleware('role:Admin');

// admin video course exam results
Route::get('/admin/video-course/{course}/exams/{exam}/results','App\Http\Controllers\Admin\Video\ExamController@results')->middleware('role:Admin');


//admin video course cqq/cqc
Route::get('/admin/video-course/{course}/cqc','App\Http\Controllers\Admin\Video\CQCController@index')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/cqc','App\Http\Controllers\Admin\Video\CQCController@store')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/cqc/{cqc}','App\Http\Controllers\Admin\Video\CQCController@destroy')->middleware('role:Admin');

//admin video course tutors
Route::get('/admin/video-course/{course}/tutors','App\Http\Controllers\Admin\Video\TutorController@index')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/tutors/create','App\Http\Controllers\Admin\Video\TutorController@create')->middleware('role:Admin');
Route::post('/admin/video-course/{course}/tutors','App\Http\Controllers\Admin\Video\TutorController@store')->middleware('role:Admin');
Route::get('/admin/video-course/{course}/tutors/{tutor}/edit','App\Http\Controllers\Admin\Video\TutorController@edit')->middleware('role:Admin');
Route::patch('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\Admin\Video\TutorController@update')->middleware('role:Admin');
Route::delete('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\Admin\Video\TutorController@destroy')->middleware('role:Admin');


//admin ebooks categories
Route::get('/admin/ebook/categories','App\Http\Controllers\Admin\Ebook\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/ebook/categories/create','App\Http\Controllers\Admin\Ebook\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/ebook/categories','App\Http\Controllers\Admin\Ebook\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/ebook/categories/{category}/edit','App\Http\Controllers\Admin\Ebook\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/categories/{category}','App\Http\Controllers\Admin\Ebook\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/categories/{category}','App\Http\Controllers\Admin\Ebook\CategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/ebook/categories/{category}/books','App\Http\Controllers\Admin\Ebook\CategoryController@ebooks')->middleware('role:Admin');


//admin ebooks 
Route::get('/admin/ebook/books','App\Http\Controllers\Admin\Ebook\BookController@index')->middleware('role:Admin');
Route::get('/admin/ebook/books/create','App\Http\Controllers\Admin\Ebook\BookController@create')->middleware('role:Admin');
Route::post('/admin/ebook/books','App\Http\Controllers\Admin\Ebook\BookController@store')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}','App\Http\Controllers\Admin\Ebook\BookController@show')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/edit','App\Http\Controllers\Admin\Ebook\BookController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/books/{book}','App\Http\Controllers\Admin\Ebook\BookController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}','App\Http\Controllers\Admin\Ebook\BookController@destroy')->middleware('role:Admin');

Route::get('/admin/ebook/books/{book}/bookings','App\Http\Controllers\Admin\Ebook\BookController@bookings')->middleware('role:Admin');

//admin ebooks chapters
Route::get('/admin/ebook/books/{book}/chapters','App\Http\Controllers\Admin\Ebook\ChapterController@index')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/create','App\Http\Controllers\Admin\Ebook\ChapterController@create')->middleware('role:Admin');
Route::post('/admin/ebook/books/{book}/chapters','App\Http\Controllers\Admin\Ebook\ChapterController@store')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\Admin\Ebook\ChapterController@show')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/edit','App\Http\Controllers\Admin\Ebook\ChapterController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\Admin\Ebook\ChapterController@update')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}/chapters/{chapter}','App\Http\Controllers\Admin\Ebook\ChapterController@destroy')->middleware('role:Admin');

//admin ebooks chapters files
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/files','App\Http\Controllers\Admin\Ebook\ChapterController@fileindex')->middleware('role:Admin');
Route::get('/admin/ebook/books/{book}/chapters/{chapter}/files/create','App\Http\Controllers\Admin\Ebook\ChapterController@filecreate')->middleware('role:Admin');
Route::post('/admin/ebook/books/{book}/chapters/{chapter}/files','App\Http\Controllers\Admin\Ebook\ChapterController@filestore')->middleware('role:Admin');
Route::delete('/admin/ebook/books/{book}/chapters/{chapter}/files/{chapterfiles}','App\Http\Controllers\Admin\Ebook\ChapterController@filedestroy')->middleware('role:Admin');

//admin ebooks bookings
Route::get('/admin/ebook-booking','App\Http\Controllers\Admin\Ebook\BookingController@index')->middleware('role:Admin');
Route::get('/admin/ebook-booking/all','App\Http\Controllers\Admin\Ebook\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/ebook-booking/create','App\Http\Controllers\Admin\Ebook\BookingController@create')->middleware('role:Admin');
Route::post('/admin/ebook-booking','App\Http\Controllers\Admin\Ebook\BookingController@store')->middleware('role:Admin');
Route::get('/admin/ebook-booking/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@show')->middleware('role:Admin');
Route::get('/admin/ebook-booking/{booking}/edit','App\Http\Controllers\Admin\Ebook\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook-booking/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/ebook-booking/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@destroy')->middleware('role:Admin');

//admin home pop up
Route::get('/admin/home-popup','App\Http\Controllers\Admin\HomePopupController@index')->middleware('role:Admin');
Route::get('/admin/home-popup/create','App\Http\Controllers\Admin\HomePopupController@create')->middleware('role:Admin');
Route::post('/admin/home-popup','App\Http\Controllers\Admin\HomePopupController@store')->middleware('role:Admin');
Route::get('/admin/home-popup/{popup}/edit','App\Http\Controllers\Admin\HomePopupController@edit')->middleware('role:Admin');
Route::patch('/admin/home-popup/{popup}','App\Http\Controllers\Admin\HomePopupController@update')->middleware('role:Admin');
Route::delete('/admin/home-popup/{popup}','App\Http\Controllers\Admin\HomePopupController@destroy')->middleware('role:Admin');

//admin audio uploads categories
Route::get('/admin/audios','App\Http\Controllers\Admin\Audio\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/audios/create','App\Http\Controllers\Admin\Audio\CategoryController@create')->middleware('role:Admin');
Route::get('/admin/audios/{category}/edit','App\Http\Controllers\Admin\Audio\CategoryController@edit')->middleware('role:Admin');
Route::post('/admin/audios','App\Http\Controllers\Admin\Audio\CategoryController@store')->middleware('role:Admin');
Route::patch('/admin/audios/{category}','App\Http\Controllers\Admin\Audio\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/audios/{category}','App\Http\Controllers\Admin\Audio\CategoryController@destroy')->middleware('role:Admin');

//admin audio files
Route::get('/admin/audios/{category}/files','App\Http\Controllers\Admin\Audio\AudioController@index')->middleware('role:Admin');
Route::get('/admin/audios/{category}/files/upload','App\Http\Controllers\Admin\Audio\AudioController@upload')->middleware('role:Admin');
Route::post('/admin/audios/{category}/files','App\Http\Controllers\Admin\Audio\AudioController@store')->middleware('role:Admin');
Route::delete('/admin/audios/{category}/files/{audio}','App\Http\Controllers\Admin\Audio\AudioController@destroy')->middleware('role:Admin');

//admin provience mgmt
Route::get('/admin/provience','App\Http\Controllers\Admin\Provience\ProvienceController@provienceList')->middleware('role:Admin');
Route::get('/admin/provience/create','App\Http\Controllers\Admin\Provience\ProvienceController@createProvience')->middleware('role:Admin');
Route::post('/admin/provience','App\Http\Controllers\Admin\Provience\ProvienceController@saveProvience')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/edit','App\Http\Controllers\Admin\Provience\ProvienceController@editProvience')->middleware('role:Admin');
Route::patch('/admin/provience/{provience}','App\Http\Controllers\Admin\Provience\ProvienceController@updateProvience')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}','App\Http\Controllers\Admin\Provience\ProvienceController@destroyProvience')->middleware('role:Admin');

//admin provience district/city mgmt
Route::get('/admin/provience/{provience}/district-city','App\Http\Controllers\Admin\Provience\DistrictCityController@index')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/district-city/create','App\Http\Controllers\Admin\Provience\DistrictCityController@create')->middleware('role:Admin');
Route::post('/admin/provience/{provience}/district-city','App\Http\Controllers\Admin\Provience\DistrictCityController@store')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}/district-city/{city}','App\Http\Controllers\Admin\Provience\DistrictCityController@destroy')->middleware('role:Admin');

Route::get('/admin/branches','App\Http\Controllers\Admin\Branch\BranchController@index')->middleware('role:Admin');
Route::get('/admin/branches/create','App\Http\Controllers\Admin\Branch\BranchController@create')->middleware('role:Admin');
Route::post('/admin/branches','App\Http\Controllers\Admin\Branch\BranchController@store')->middleware('role:Admin');
Route::get('/admin/branches/{branch}','App\Http\Controllers\Admin\Branch\BranchController@show')->middleware('role:Admin');
Route::get('/admin/branches/{branch}/edit','App\Http\Controllers\Admin\Branch\BranchController@edit')->middleware('role:Admin');
Route::patch('/admin/branches/{branch}','App\Http\Controllers\Admin\Branch\BranchController@update')->middleware('role:Admin');
Route::delete('/admin/branches/{branch}','App\Http\Controllers\Admin\Branch\BranchController@destroy')->middleware('role:Admin');

//vendor wise bookings in admin
Route::get('/admin/vendor-course-bookings','App\Http\Controllers\Admin\Vendors\BookingController@allVendorsCourseBookings')->middleware('role:Admin');
Route::get('/admin/vendor-video-bookings','App\Http\Controllers\Admin\Vendors\BookingController@allVendorsVideoBookings')->middleware('role:Admin');
Route::get('/admin/vendor-ebook-bookings','App\Http\Controllers\Admin\Vendors\BookingController@allVendorsEbookBookings')->middleware('role:Admin');
Route::get('/admin/vendor-exam-bookings','App\Http\Controllers\Admin\Vendors\BookingController@allVendorsExamBookings')->middleware('role:Admin');

//admin publisher mgmt 
Route::get('/admin/publishers','App\Http\Controllers\Admin\Publisher\PublisherController@index')->middleware('role:Admin');
Route::get('/admin/publishers/create','App\Http\Controllers\Admin\Publisher\PublisherController@create')->middleware('role:Admin');
Route::post('/admin/publishers','App\Http\Controllers\Admin\Publisher\PublisherController@store')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}','App\Http\Controllers\Admin\Publisher\PublisherController@show')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}/edit','App\Http\Controllers\Admin\Publisher\PublisherController@edit')->middleware('role:Admin');
Route::patch('/admin/publishers/{publisher}','App\Http\Controllers\Admin\Publisher\PublisherController@update')->middleware('role:Admin');
Route::delete('/admin/publishers/{publisher}','App\Http\Controllers\Admin\Publisher\PublisherController@destroy')->middleware('role:Admin');

//admin publisher book mgmt
Route::get('/admin/publishers/{publisher}/books','App\Http\Controllers\Admin\Publisher\BookController@index')->middleware('role:Admin');
Route::get('/admin/publishers/{publisher}/books/{ebook}','App\Http\Controllers\Admin\Publisher\BookController@show')->middleware('role:Admin');
Route::delete('/admin/publishers/{publisher}/books/{ebook}','App\Http\Controllers\Admin\Publisher\BookController@destroy')->middleware('role:Admin');

//admin career mgmt
Route::get('/admin/careers','App\Http\Controllers\Admin\Career\VaccancyController@index')->middleware('role:Admin');
Route::get('/admin/careers/create','App\Http\Controllers\Admin\Career\VaccancyController@create')->middleware('role:Admin');
Route::post('/admin/careers','App\Http\Controllers\Admin\Career\VaccancyController@store')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}','App\Http\Controllers\Admin\Career\VaccancyController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/edit','App\Http\Controllers\Admin\Career\VaccancyController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}','App\Http\Controllers\Admin\Career\VaccancyController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}','App\Http\Controllers\Admin\Career\VaccancyController@destroy')->middleware('role:Admin');

//career applicants mgmt
Route::get('/admin/careers/{vaccancy}/applicants','App\Http\Controllers\Admin\Career\ApplicantController@index')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\Admin\Career\ApplicantController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}/edit','App\Http\Controllers\Admin\Career\ApplicantController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\Admin\Career\ApplicantController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}/applicants/{applicant}','App\Http\Controllers\Admin\Career\ApplicantController@destroy')->middleware('role:Admin');

//admin dynamic form category mgmt
Route::get('/admin/dynamic-forms/categories','App\Http\Controllers\Admin\Forms\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/create','App\Http\Controllers\Admin\Forms\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories','App\Http\Controllers\Admin\Forms\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/edit','App\Http\Controllers\Admin\Forms\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\Admin\Forms\CategoryController@show')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/reset','App\Http\Controllers\Admin\Forms\CategoryController@reset')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\Admin\Forms\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}','App\Http\Controllers\Admin\Forms\CategoryController@destroy')->middleware('role:Admin');

//admin dynamic form sub category mgmt
Route::get('/admin/dynamic-forms/categories/{category}/sub-categories','App\Http\Controllers\Admin\Forms\SubCategoryController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/sub-categories/create','App\Http\Controllers\Admin\Forms\SubCategoryController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/sub-categories','App\Http\Controllers\Admin\Forms\SubCategoryController@store')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/sub-categories/{subCategory}','App\Http\Controllers\Admin\Forms\SubCategoryController@destroy')->middleware('role:Admin');

// //admin dynamic form applicants
Route::get('/admin/dynamic-forms/categories/{category}/applicants','App\Http\Controllers\Admin\Forms\ApplicantController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/upload','App\Http\Controllers\Admin\Forms\ApplicantController@uploadForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/applicants/filter','App\Http\Controllers\Admin\Forms\ApplicantController@filterApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/export/{query}','App\Http\Controllers\Admin\Forms\ApplicantController@exportFilteredApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/export','App\Http\Controllers\Admin\Forms\ApplicantController@exportApplicants')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/applicants/import','App\Http\Controllers\Admin\Forms\ApplicantController@importApplicants')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\ApplicantController@show')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\ApplicantController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\ApplicantController@destroy')->middleware('role:Admin');

// //admin team assign for dynamic form applicants
Route::get('/admin/dynamic-forms/categories/{category}/team-assign','App\Http\Controllers\Admin\Forms\TeamAssignController@index')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/categories/{category}/team-assign/create','App\Http\Controllers\Admin\Forms\TeamAssignController@create')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/categories/{category}/team-assign','App\Http\Controllers\Admin\Forms\TeamAssignController@store')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/categories/{category}/team-assign/{assign}','App\Http\Controllers\Admin\Forms\TeamAssignController@destroy')->middleware('role:Admin');

//admin dynamic forms groups
Route::get('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\GroupController@index')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\GroupController@store')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\GroupController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/groups/{group}','App\Http\Controllers\Admin\Forms\GroupController@destroy')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/forms','App\Http\Controllers\Admin\Forms\GroupController@forms')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/applicants','App\Http\Controllers\Admin\Forms\GroupController@applicants')->middleware('role:Admin');


//admin orientation management
Route::get('/admin/orientations','App\Http\Controllers\Admin\Orientation\OrientationController@index')->middleware('role:Admin');
Route::get('/admin/orientations/create','App\Http\Controllers\Admin\Orientation\OrientationController@create')->middleware('role:Admin');
Route::post('/admin/orientations','App\Http\Controllers\Admin\Orientation\OrientationController@store')->middleware('role:Admin');
Route::get('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@show')->middleware('role:Admin');
Route::get('/admin/orientations/{orientation}/edit','App\Http\Controllers\Admin\Orientation\OrientationController@edit')->middleware('role:Admin');
Route::patch('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@update')->middleware('role:Admin');
Route::delete('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@destroy')->middleware('role:Admin');

//admin orientation participants management
Route::get('/admin/orientations/{orientation}/participants','App\Http\Controllers\Admin\Orientation\ParticipantController@index')->middleware('role:Admin');
Route::delete('/admin/orientations/{orientation}/participants/{participant}','App\Http\Controllers\Admin\Orientation\ParticipantController@destroy')->middleware('role:Admin');

//admin teams mgmt
Route::get('/admin/teams','App\Http\Controllers\Admin\Teams\TeamController@index')->middleware('role:Admin');
Route::get('/admin/teams/create','App\Http\Controllers\Admin\Teams\TeamController@create')->middleware('role:Admin');
Route::post('/admin/teams','App\Http\Controllers\Admin\Teams\TeamController@store')->middleware('role:Admin');
Route::get('/admin/teams/{team}','App\Http\Controllers\Admin\Teams\TeamController@show')->middleware('role:Admin');
Route::get('/admin/teams/{team}/edit','App\Http\Controllers\Admin\Teams\TeamController@edit')->middleware('role:Admin');
Route::patch('/admin/teams/{team}','App\Http\Controllers\Admin\Teams\TeamController@update')->middleware('role:Admin');
Route::delete('/admin/teams/{team}','App\Http\Controllers\Admin\Teams\TeamController@destroy')->middleware('role:Admin');

//admin merchant wise bookings
Route::get('/admin/booking-through-merchant','App\Http\Controllers\Admin\MerchantBookingController@index')->middleware('role:Admin');
















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


