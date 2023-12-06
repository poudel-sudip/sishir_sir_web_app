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



// Route::get('/', function(){ return view('welcome'); });

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

// // admin course categories mgmt
// Route::get('/admin/categories', 'App\Http\Controllers\Admin\Courses\CategoryController@index')->middleware('role:Admin');
// Route::get('/admin/categories/create', 'App\Http\Controllers\Admin\Courses\CategoryController@create')->middleware('role:Admin');
// Route::get('/admin/categories/{category}/edit', 'App\Http\Controllers\Admin\Courses\CategoryController@edit')->middleware('role:Admin');
// Route::patch('/admin/categories/{category}', 'App\Http\Controllers\Admin\Courses\CategoryController@update')->middleware('role:Admin');
// Route::post('/admin/categories','App\Http\Controllers\Admin\Courses\CategoryController@store')->middleware('role:Admin');
// Route::delete('/admin/categories/{categories}','App\Http\Controllers\Admin\Courses\CategoryController@destroy')->middleware('role:Admin');

// //admin courses mgmt
// Route::get('/admin/courses','App\Http\Controllers\Admin\Courses\CoursesController@index')->middleware('role:Admin');
// Route::get('/admin/courses/create','App\Http\Controllers\Admin\Courses\CoursesController@create')->middleware('role:Admin');
// Route::get('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@show')->middleware('role:Admin');
// Route::get('/admin/courses/{course}/edit','App\Http\Controllers\Admin\Courses\CoursesController@edit')->middleware('role:Admin');
// Route::post('/admin/courses','App\Http\Controllers\Admin\Courses\CoursesController@store')->middleware('role:Admin');
// Route::patch('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@update')->middleware('role:Admin');
// Route::delete('/admin/courses/{course}','App\Http\Controllers\Admin\Courses\CoursesController@destroy')->middleware('role:Admin');

// // admin course featurs
// Route::get('/admin/courses/{course}/features','App\Http\Controllers\Admin\Courses\CourseFeaturesController@index')->middleware('role:Admin');
// Route::get('/admin/courses/{course}/features/create','App\Http\Controllers\Admin\Courses\CourseFeaturesController@create')->middleware('role:Admin');
// Route::post('/admin/courses/{course}/features','App\Http\Controllers\Admin\Courses\CourseFeaturesController@store')->middleware('role:Admin');
// Route::get('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@show')->middleware('role:Admin');
// Route::get('/admin/courses/{course}/features/{feature}/edit','App\Http\Controllers\Admin\Courses\CourseFeaturesController@edit')->middleware('role:Admin');
// Route::patch('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@update')->middleware('role:Admin');
// Route::delete('/admin/courses/{course}/features/{feature}','App\Http\Controllers\Admin\Courses\CourseFeaturesController@destroy')->middleware('role:Admin');

// //course batches
// Route::get('/admin/courses/{course}/batches','App\Http\Controllers\Admin\Courses\CourseBatchesController@index')->middleware('role:Admin');
// Route::get('/courses/{course}/batchnames','App\Http\Controllers\Admin\Courses\CourseBatchesController@display');

// //admin batches mgmt 
// Route::get('/admin/batches', 'App\Http\Controllers\Admin\Courses\BatchController@index')->middleware('role:Admin');
// Route::get('/admin/batches/create', 'App\Http\Controllers\Admin\Courses\BatchController@create')->middleware('role:Admin');
// Route::post('/admin/batches','App\Http\Controllers\Admin\Courses\BatchController@store')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@show')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}/edit', 'App\Http\Controllers\Admin\Courses\BatchController@edit')->middleware('role:Admin');
// Route::patch('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@update')->middleware('role:Admin');
// Route::delete('/admin/batches/{batch}','App\Http\Controllers\Admin\Courses\BatchController@destroy')->middleware('role:Admin');

// //classroom units admin
// Route::get('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@index')->middleware('role:Admin');
// Route::post('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@store')->middleware('role:Admin');
// Route::patch('/admin/batches/{batch}/units','App\Http\Controllers\classroom\UnitController@update')->middleware('role:Admin');
// Route::delete('/admin/batches/{batch}/units/{unit}','App\Http\Controllers\classroom\UnitController@destroy')->middleware('role:Admin');

// //admin single batch bookings
// Route::get('/admin/batches/{batch}/bookings','App\Http\Controllers\Admin\Courses\BatchBookingsController@index')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}/bookings/{booking}/edit','App\Http\Controllers\Admin\Courses\BatchBookingsController@edit')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@show')->middleware('role:Admin');
// Route::patch('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@update')->middleware('role:Admin');
// Route::delete('/admin/batches/{batch}/bookings/{booking}','App\Http\Controllers\Admin\Courses\BatchBookingsController@destroy')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}/verified','App\Http\Controllers\Admin\Courses\BatchBookingsController@verifiedstatus')->middleware('role:Admin');
// Route::get('/admin/batches/{batch}/unverified','App\Http\Controllers\Admin\Courses\BatchBookingsController@unverifiedstatus')->middleware('role:Admin');

// // admin course bookings
// Route::get('/admin/bookings','App\Http\Controllers\Admin\Courses\BookingsController@index')->middleware('role:Admin');
// Route::get('/admin/bookings/all','App\Http\Controllers\Admin\Courses\BookingsController@allBookings')->middleware('role:Admin');
// Route::get('/admin/bookings/create','App\Http\Controllers\Admin\Courses\BookingsController@create')->middleware('role:Admin');
// Route::get('/admin/bookings/verifylist','App\Http\Controllers\Admin\Courses\BookingsController@verifylist')->middleware('role:Admin');
// Route::get('/admin/bookings/duelist','App\Http\Controllers\Admin\Courses\BookingsController@duelist')->middleware('role:Admin');
// Route::get('/admin/bookings/unverifiedlist','App\Http\Controllers\Admin\Courses\BookingsController@unverifiedlist')->middleware('role:Admin');
// Route::get('/admin/bookings/suspendedlist','App\Http\Controllers\Admin\Courses\BookingsController@suspendedlist')->middleware('role:Admin');
// Route::post('/admin/bookings','App\Http\Controllers\Admin\Courses\BookingsController@store')->middleware('role:Admin');
// Route::get('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@show')->middleware('role:Admin');
// Route::get('/admin/bookings/{booking}/edit','App\Http\Controllers\Admin\Courses\BookingsController@edit')->middleware('role:Admin');
// Route::patch('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@update')->middleware('role:Admin');
// Route::delete('/admin/bookings/{booking}','App\Http\Controllers\Admin\Courses\BookingsController@destroy')->middleware('role:Admin');

// //final routes for course classroom section
// //classroom chat section
// Route::get('/classroom/chat/{batch}','App\Http\Controllers\classroom\ChatController@index');
// Route::post('/classroom/chat/{batch}','App\Http\Controllers\classroom\ChatController@store');

// //course classroom files section 
// Route::get('/classroom/files/{batch}/all','App\Http\Controllers\classroom\FileController@index');
// Route::get('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@fileUnits');
// Route::get('/classroom/files/{batch}/unit/{unit}','App\Http\Controllers\classroom\FileController@unitFiles');
// Route::post('/classroom/files/{batch}/unit/{unit}','App\Http\Controllers\classroom\FileController@saveUnitFile');
// Route::post('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@store');
// Route::get('/classroom/view/{id}','App\Http\Controllers\classroom\FileController@view');
// Route::delete('/classroom/files/{batch}/{file}','App\Http\Controllers\classroom\FileController@destroy')->middleware('role:Admin');
// Route::patch('/classroom/files/{batch}','App\Http\Controllers\classroom\FileController@update');

// //course classroom videos section 
// Route::get('/classroom/videos/{batch}/all','App\Http\Controllers\classroom\VideoController@index');
// Route::get('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@videoUnits');
// Route::get('/classroom/videos/{batch}/unit/{unit}','App\Http\Controllers\classroom\VideoController@videoUnitsVideos');
// Route::post('/classroom/videos/{batch}/unit/{unit}','App\Http\Controllers\classroom\VideoController@savevideoUnitsVideo');
// Route::post('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@store');
// Route::delete('/classroom/videos/{batch}/{video}','App\Http\Controllers\classroom\VideoController@destroy')->middleware('role:Admin');
// Route::patch('/classroom/videos/{batch}','App\Http\Controllers\classroom\VideoController@update');

// //common question collection (cqc) for course classroom
// Route::get('/classroom/cqcs/{batch}','App\Http\Controllers\classroom\CQCController@index');
// Route::post('/classroom/cqcs/{batch}','App\Http\Controllers\classroom\CQCController@store');
// Route::delete('/classroom/cqcs/{batch}/{question}','App\Http\Controllers\classroom\CQCController@destroy');

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
Route::get('/admin/exams/{exam}/questions/download','App\Http\Controllers\Admin\Exams\QuestionController@download')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions','App\Http\Controllers\Admin\Exams\QuestionController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}/edit','App\Http\Controllers\Admin\Exams\QuestionController@edit')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}','App\Http\Controllers\Admin\Exams\QuestionController@show')->middleware('role:Admin');
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
Route::get('/admin/ebook-bookings','App\Http\Controllers\Admin\Ebook\BookingController@index')->middleware('role:Admin');
Route::get('/admin/ebook-bookings/all','App\Http\Controllers\Admin\Ebook\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/ebook-bookings/create','App\Http\Controllers\Admin\Ebook\BookingController@create')->middleware('role:Admin');
Route::post('/admin/ebook-bookings','App\Http\Controllers\Admin\Ebook\BookingController@store')->middleware('role:Admin');
Route::get('/admin/ebook-bookings/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@show')->middleware('role:Admin');
Route::get('/admin/ebook-bookings/{booking}/edit','App\Http\Controllers\Admin\Ebook\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/ebook-bookings/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/ebook-bookings/{booking}','App\Http\Controllers\Admin\Ebook\BookingController@destroy')->middleware('role:Admin');

//admin merchant wise bookings
Route::get('/admin/booking-through-merchant','App\Http\Controllers\Admin\MerchantBookingController@index')->middleware('role:Admin');

// //admin notifications for students
// Route::get('/admin/notifications','App\Http\Controllers\Admin\NotificationController@index')->middleware('role:Admin');
// Route::get('/admin/notifications/create','App\Http\Controllers\Admin\NotificationController@create')->middleware('role:Admin');
// Route::post('/admin/notifications','App\Http\Controllers\Admin\NotificationController@store')->middleware('role:Admin');
// Route::get('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@show')->middleware('role:Admin');
// Route::get('/admin/notifications/{notification}/edit','App\Http\Controllers\Admin\NotificationController@edit')->middleware('role:Admin');
// Route::patch('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@update')->middleware('role:Admin');
// Route::delete('/admin/notifications/{notification}','App\Http\Controllers\Admin\NotificationController@destroy')->middleware('role:Admin');

// //routes for sms sections
// Route::get('/admin/sms','App\Http\Controllers\Admin\SMSController@index')->middleware('role:Admin');
// Route::get('/admin/sms/create','App\Http\Controllers\Admin\SMSController@create')->middleware('role:Admin');
// Route::post('/admin/sms','App\Http\Controllers\Admin\SMSController@store')->middleware('role:Admin');

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

//admin sliders mgmt
Route::get('/admin/sliders','App\Http\Controllers\Admin\SliderController@index')->middleware('role:Admin');
Route::get('/admin/sliders/create','App\Http\Controllers\Admin\SliderController@create')->middleware('role:Admin');
Route::post('/admin/sliders','App\Http\Controllers\Admin\SliderController@store')->middleware('role:Admin');
Route::get('/admin/sliders/{slider}/edit','App\Http\Controllers\Admin\SliderController@edit')->middleware('role:Admin');
Route::patch('/admin/sliders/{slider}','App\Http\Controllers\Admin\SliderController@update')->middleware('role:Admin');
Route::delete('/admin/sliders/{slider}','App\Http\Controllers\Admin\SliderController@destroy')->middleware('role:Admin');

//admin home pop up
Route::get('/admin/home-popup','App\Http\Controllers\Admin\HomePopupController@index')->middleware('role:Admin');
Route::get('/admin/home-popup/create','App\Http\Controllers\Admin\HomePopupController@create')->middleware('role:Admin');
Route::post('/admin/home-popup','App\Http\Controllers\Admin\HomePopupController@store')->middleware('role:Admin');
Route::get('/admin/home-popup/{popup}/edit','App\Http\Controllers\Admin\HomePopupController@edit')->middleware('role:Admin');
Route::patch('/admin/home-popup/{popup}','App\Http\Controllers\Admin\HomePopupController@update')->middleware('role:Admin');
Route::delete('/admin/home-popup/{popup}','App\Http\Controllers\Admin\HomePopupController@destroy')->middleware('role:Admin');

//admin testimonials management
Route::get('/admin/testimonials','App\Http\Controllers\Admin\TestimonialController@index')->middleware('role:Admin');
Route::get('/admin/testimonials/create','App\Http\Controllers\Admin\TestimonialController@create')->middleware('role:Admin');
Route::post('/admin/testimonials','App\Http\Controllers\Admin\TestimonialController@store')->middleware('role:Admin');
Route::get('/admin/testimonials/{testimonial}/edit','App\Http\Controllers\Admin\TestimonialController@edit')->middleware('role:Admin');
Route::patch('/admin/testimonials/{testimonial}','App\Http\Controllers\Admin\TestimonialController@update')->middleware('role:Admin');
Route::delete('/admin/testimonials/{testimonial}','App\Http\Controllers\Admin\TestimonialController@destroy')->middleware('role:Admin');

// admin leads and enquiries
Route::get('/leads/enquiries','App\Http\Controllers\Leads\EnquiryController@index')->middleware('role:Admin');
Route::post('/leads/enquiries/add','App\Http\Controllers\Leads\EnquiryController@store');
Route::get('/leads/enquiries/filter','App\Http\Controllers\Leads\EnquiryController@filterFormShow')->middleware('role:Admin');
Route::post('/leads/enquiries/filter','App\Http\Controllers\Leads\EnquiryController@filterResults')->middleware('role:Admin');
Route::get('/leads/enquiries/{enquiry}/edit','App\Http\Controllers\Leads\EnquiryController@edit')->middleware('role:Admin');
Route::patch('/leads/enquiries/{enquiry}','App\Http\Controllers\Leads\EnquiryController@update')->middleware('role:Admin');
Route::delete('/leads/enquiries/{enquiry}','App\Http\Controllers\Leads\EnquiryController@destroy')->middleware('role:Admin');

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

//admin uploads section management
//syllabus management admin
Route::resource('/admin/syllabus', App\Http\Controllers\Admin\SyllabusController::class)->middleware('role:Admin');
Route::get('/admin/syllabus/{id}/delete', [App\Http\Controllers\Admin\SyllabusController::class,'destroy']);

//study Materials management admin
Route::resource('/admin/studyMaterials', App\Http\Controllers\Admin\StudyMaterialController::class)->middleware('role:Admin');
Route::get('/admin/studyMaterials/{id}/delete', [App\Http\Controllers\Admin\StudyMaterialController::class,'destroy']);

// admin video uploads section
// Route::get('/admin/videos','App\Http\Controllers\Admin\VideoController@index')->middleware('role:Admin');
// Route::get('/admin/videos/upload','App\Http\Controllers\Admin\VideoController@upload')->middleware('role:Admin');
// Route::post('/admin/videos','App\Http\Controllers\Admin\VideoController@store')->middleware('role:Admin');
// Route::delete('/admin/videos/{video}','App\Http\Controllers\Admin\VideoController@destroy')->middleware('role:Admin');

//admin audio uploads categories
// Route::get('/admin/audios','App\Http\Controllers\Admin\Audio\CategoryController@index')->middleware('role:Admin');
// Route::get('/admin/audios/create','App\Http\Controllers\Admin\Audio\CategoryController@create')->middleware('role:Admin');
// Route::get('/admin/audios/{category}/edit','App\Http\Controllers\Admin\Audio\CategoryController@edit')->middleware('role:Admin');
// Route::post('/admin/audios','App\Http\Controllers\Admin\Audio\CategoryController@store')->middleware('role:Admin');
// Route::patch('/admin/audios/{category}','App\Http\Controllers\Admin\Audio\CategoryController@update')->middleware('role:Admin');
// Route::delete('/admin/audios/{category}','App\Http\Controllers\Admin\Audio\CategoryController@destroy')->middleware('role:Admin');

//admin audio files
// Route::get('/admin/audios/{category}/files','App\Http\Controllers\Admin\Audio\AudioController@index')->middleware('role:Admin');
// Route::get('/admin/audios/{category}/files/upload','App\Http\Controllers\Admin\Audio\AudioController@upload')->middleware('role:Admin');
// Route::post('/admin/audios/{category}/files','App\Http\Controllers\Admin\Audio\AudioController@store')->middleware('role:Admin');
// Route::delete('/admin/audios/{category}/files/{audio}','App\Http\Controllers\Admin\Audio\AudioController@destroy')->middleware('role:Admin');

//admin menu group mgmt
Route::get('/admin/menus','App\Http\Controllers\Admin\Menus\GroupController@index')->middleware('role:Admin');
Route::get('/admin/menus/create','App\Http\Controllers\Admin\Menus\GroupController@create')->middleware('role:Admin');
Route::post('/admin/menus','App\Http\Controllers\Admin\Menus\GroupController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/edit','App\Http\Controllers\Admin\Menus\GroupController@edit')->middleware('role:Admin');
Route::patch('/admin/menus/{group}','App\Http\Controllers\Admin\Menus\GroupController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}','App\Http\Controllers\Admin\Menus\GroupController@destroy')->middleware('role:Admin');

//admin menu sub group mgmt
Route::get('/admin/menus/{group}/sub-groups','App\Http\Controllers\Admin\Menus\SubGroupController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/create','App\Http\Controllers\Admin\Menus\SubGroupController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups','App\Http\Controllers\Admin\Menus\SubGroupController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/edit','App\Http\Controllers\Admin\Menus\SubGroupController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}','App\Http\Controllers\Admin\Menus\SubGroupController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}','App\Http\Controllers\Admin\Menus\SubGroupController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}','App\Http\Controllers\Admin\Menus\SubGroupController@destroy')->middleware('role:Admin');

//admin menu item category mgmt
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories','App\Http\Controllers\Admin\Menus\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/create','App\Http\Controllers\Admin\Menus\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories','App\Http\Controllers\Admin\Menus\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/edit','App\Http\Controllers\Admin\Menus\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}','App\Http\Controllers\Admin\Menus\CategoryController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}','App\Http\Controllers\Admin\Menus\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}','App\Http\Controllers\Admin\Menus\CategoryController@destroy')->middleware('role:Admin');


// admin menu item management 
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items','App\Http\Controllers\Admin\Menus\ItemController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/create','App\Http\Controllers\Admin\Menus\ItemController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items','App\Http\Controllers\Admin\Menus\ItemController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/edit','App\Http\Controllers\Admin\Menus\ItemController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}','App\Http\Controllers\Admin\Menus\ItemController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}','App\Http\Controllers\Admin\Menus\ItemController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}','App\Http\Controllers\Admin\Menus\ItemController@destroy')->middleware('role:Admin');

// admin menu sub-item management 
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items','App\Http\Controllers\Admin\Menus\SubItemController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/create','App\Http\Controllers\Admin\Menus\SubItemController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items','App\Http\Controllers\Admin\Menus\SubItemController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}/edit','App\Http\Controllers\Admin\Menus\SubItemController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}','App\Http\Controllers\Admin\Menus\SubItemController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}','App\Http\Controllers\Admin\Menus\SubItemController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}','App\Http\Controllers\Admin\Menus\SubItemController@destroy')->middleware('role:Admin');

// admin personal books management 

Route::get('/admin/books/publishers','App\Http\Controllers\Admin\Books\BookController@publisherIndex')->middleware('role:Admin');
Route::get('/admin/books/publishers/create','App\Http\Controllers\Admin\Books\BookController@publisherCreate')->middleware('role:Admin');
Route::post('/admin/books/publishers','App\Http\Controllers\Admin\Books\BookController@publisherStore')->middleware('role:Admin');
Route::get('/admin/books/publishers/{category}/edit','App\Http\Controllers\Admin\Books\BookController@publisherEdit')->middleware('role:Admin');
Route::patch('/admin/books/publishers/{category}','App\Http\Controllers\Admin\Books\BookController@publisherUpdate')->middleware('role:Admin');
Route::delete('/admin/books/publishers/{category}','App\Http\Controllers\Admin\Books\BookController@publisherDestroy')->middleware('role:Admin');
// Route::get('/admin/books/publishers/{category}/books','App\Http\Controllers\Admin\Books\BookController@publisherBooks')->middleware('role:Admin');

Route::get('/admin/books/publishers/{publisher}/categories','App\Http\Controllers\Admin\Books\BookController@publisherCategories')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/create','App\Http\Controllers\Admin\Books\BookController@categoryCreate')->middleware('role:Admin');
Route::post('/admin/books/publishers/{publisher}/categories','App\Http\Controllers\Admin\Books\BookController@categoryStore')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}/edit','App\Http\Controllers\Admin\Books\BookController@categoryEdit')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}','App\Http\Controllers\Admin\Books\BookController@categoryShow')->middleware('role:Admin');
Route::patch('/admin/books/publishers/{publisher}/categories/{category}','App\Http\Controllers\Admin\Books\BookController@categoryUpdate')->middleware('role:Admin');
Route::delete('/admin/books/publishers/{publisher}/categories/{category}','App\Http\Controllers\Admin\Books\BookController@categoryDestroy')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}/books','App\Http\Controllers\Admin\Books\BookController@categoryBooks')->middleware('role:Admin');

Route::get('/admin/books/publishers/{publisher}/categories/{category}/books/create','App\Http\Controllers\Admin\Books\BookController@create')->middleware('role:Admin');
Route::post('/admin/books/publishers/{publisher}/categories/{category}/books','App\Http\Controllers\Admin\Books\BookController@store')->middleware('role:Admin');

Route::get('/admin/books','App\Http\Controllers\Admin\Books\BookController@index')->middleware('role:Admin');
// Route::get('/admin/books/create','App\Http\Controllers\Admin\Books\BookController@create')->middleware('role:Admin');
// Route::post('/admin/books','App\Http\Controllers\Admin\Books\BookController@store')->middleware('role:Admin');
Route::get('/admin/books/{book}/edit','App\Http\Controllers\Admin\Books\BookController@edit')->middleware('role:Admin');
Route::get('/admin/books/{book}','App\Http\Controllers\Admin\Books\BookController@show')->middleware('role:Admin');
Route::patch('/admin/books/{book}','App\Http\Controllers\Admin\Books\BookController@update')->middleware('role:Admin');
Route::delete('/admin/books/{book}','App\Http\Controllers\Admin\Books\BookController@destroy')->middleware('role:Admin');

Route::get('/admin/books/{book}/reviews','App\Http\Controllers\Admin\Books\BookController@reviewList')->middleware('role:Admin');
Route::delete('/admin/books/{book}/reviews/{review}','App\Http\Controllers\Admin\Books\BookController@reviewDestroy')->middleware('role:Admin');

// admin avertisement management 
Route::get('/admin/advertisement','App\Http\Controllers\Admin\Advertisement\ADController@index')->middleware('role:Admin');
Route::get('/admin/advertisement/create','App\Http\Controllers\Admin\Advertisement\ADController@create')->middleware('role:Admin');
Route::post('/admin/advertisement','App\Http\Controllers\Admin\Advertisement\ADController@store')->middleware('role:Admin');
Route::delete('/admin/advertisement/{ad}','App\Http\Controllers\Admin\Advertisement\ADController@destroy')->middleware('role:Admin');

// admin material library Category management
Route::get('/admin/library','App\Http\Controllers\Admin\Library\CategoryController@index')->middleware('role:Admin');
// Route::get('/admin/library/create','App\Http\Controllers\Admin\Library\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/library','App\Http\Controllers\Admin\Library\CategoryController@store')->middleware('role:Admin');
// Route::get('/admin/library/{category}/edit','App\Http\Controllers\Admin\Library\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/library/{category}/directories','App\Http\Controllers\Admin\Library\CategoryController@getChilds')->middleware('role:Admin');
Route::patch('/admin/library','App\Http\Controllers\Admin\Library\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/library/{category}','App\Http\Controllers\Admin\Library\CategoryController@destroy')->middleware('role:Admin');

// admin material library items management
Route::get('/admin/library/{category}/materials','App\Http\Controllers\Admin\Library\MaterialController@index')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/create','App\Http\Controllers\Admin\Library\MaterialController@create')->middleware('role:Admin');
Route::post('/admin/library/{category}/materials','App\Http\Controllers\Admin\Library\MaterialController@store')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/{material}/edit','App\Http\Controllers\Admin\Library\MaterialController@edit')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/{material}','App\Http\Controllers\Admin\Library\MaterialController@show')->middleware('role:Admin');
Route::patch('/admin/library/{category}/materials/{material}','App\Http\Controllers\Admin\Library\MaterialController@update')->middleware('role:Admin');
Route::delete('/admin/library/{category}/materials/{material}','App\Http\Controllers\Admin\Library\MaterialController@destroy')->middleware('role:Admin');

// admin imp links management
Route::get('/admin/imp-links','App\Http\Controllers\Admin\LinksController@categoryIndex')->middleware('role:Admin');
Route::get('/admin/imp-links/create','App\Http\Controllers\Admin\LinksController@categoryCreate')->middleware('role:Admin');
Route::post('/admin/imp-links','App\Http\Controllers\Admin\LinksController@categoryStore')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/edit','App\Http\Controllers\Admin\LinksController@categoryEdit')->middleware('role:Admin');
Route::patch('/admin/imp-links/{category}','App\Http\Controllers\Admin\LinksController@categoryUpdate')->middleware('role:Admin');
Route::delete('/admin/imp-links/{category}','App\Http\Controllers\Admin\LinksController@categoryDestroy')->middleware('role:Admin');

Route::get('/admin/imp-links/{category}/links','App\Http\Controllers\Admin\LinksController@index')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/links/create','App\Http\Controllers\Admin\LinksController@create')->middleware('role:Admin');
Route::post('/admin/imp-links/{category}/links','App\Http\Controllers\Admin\LinksController@store')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/links/{link}/edit','App\Http\Controllers\Admin\LinksController@edit')->middleware('role:Admin');
Route::patch('/admin/imp-links/{category}/links/{link}','App\Http\Controllers\Admin\LinksController@update')->middleware('role:Admin');
Route::delete('/admin/imp-links/{category}/links/{link}','App\Http\Controllers\Admin\LinksController@destroy')->middleware('role:Admin');

//admin dynamic form group mgmt
Route::get('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\FormGroupController@index')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\FormGroupController@store')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/groups','App\Http\Controllers\Admin\Forms\FormGroupController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/groups/{group}','App\Http\Controllers\Admin\Forms\FormGroupController@destroy')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/forms','App\Http\Controllers\Admin\Forms\FormGroupController@forms')->middleware('role:Admin');

//admin dynamic forms mgmt
Route::get('/admin/dynamic-forms','App\Http\Controllers\Admin\Forms\FormController@formLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/create','App\Http\Controllers\Admin\Forms\FormController@createForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms','App\Http\Controllers\Admin\Forms\FormController@saveForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}','App\Http\Controllers\Admin\Forms\FormController@showForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/edit','App\Http\Controllers\Admin\Forms\FormController@editForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/reset','App\Http\Controllers\Admin\Forms\FormController@resetForm')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/{vform}','App\Http\Controllers\Admin\Forms\FormController@updateForm')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/{vform}','App\Http\Controllers\Admin\Forms\FormController@destroyForm')->middleware('role:Admin');

//admin dynamic form applicants mgmt
Route::get('/admin/dynamic-forms/{vform}/applicants','App\Http\Controllers\Admin\Forms\FormController@applicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/upload','App\Http\Controllers\Admin\Forms\FormController@uploadApplicantListForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/export','App\Http\Controllers\Admin\Forms\FormController@exportApplicantLists')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/applicants/import','App\Http\Controllers\Admin\Forms\FormController@importApplicantLists')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/applicants/filter','App\Http\Controllers\Admin\Forms\FormController@filteredApplicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/export/{query}','App\Http\Controllers\Admin\Forms\FormController@exportFilteredApplicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\FormController@showApplicant')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\FormController@updateApplicant')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/{vform}/applicants/{applicant}','App\Http\Controllers\Admin\Forms\FormController@destroyApplicant')->middleware('role:Admin');

// // admin free videos
Route::get('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@index')->middleware('role:Admin');
Route::get('/admin/free-videos/create','App\Http\Controllers\Admin\FreeVideoController@create')->middleware('role:Admin');
Route::post('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@store')->middleware('role:Admin');
Route::delete('/admin/free-videos/{video}','App\Http\Controllers\Admin\FreeVideoController@destroy')->middleware('role:Admin');

Route::get('/admin/qr-books','App\Http\Controllers\Admin\Books\QRBookController@index')->middleware('role:Admin');
Route::get('/admin/qr-books/create','App\Http\Controllers\Admin\Books\QRBookController@create')->middleware('role:Admin');
Route::post('/admin/qr-books','App\Http\Controllers\Admin\Books\QRBookController@store')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/edit','App\Http\Controllers\Admin\Books\QRBookController@edit')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/show','App\Http\Controllers\Admin\Books\QRBookController@show')->middleware('role:Admin');
Route::patch('/admin/qr-books/{book}','App\Http\Controllers\Admin\Books\QRBookController@update')->middleware('role:Admin');
Route::delete('/admin/qr-books/{book}','App\Http\Controllers\Admin\Books\QRBookController@destroy')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/scans','App\Http\Controllers\Admin\Books\QRBookController@scanMembers')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/scans/export','App\Http\Controllers\Admin\Books\QRBookController@scanMembersExport')->middleware('role:Admin');

Route::get('/admin/qr-books/{book}/winners','App\Http\Controllers\Admin\Books\QRBookController@winnerMembers')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/winners/create','App\Http\Controllers\Admin\Books\QRBookController@winnerCreate')->middleware('role:Admin');
Route::post('/admin/qr-books/{book}/winners','App\Http\Controllers\Admin\Books\QRBookController@winnerStore')->middleware('role:Admin');














/*------------------------------------all student section routes---------------------------*/

//final routes for students panel section
Route::get('/student/home', 'App\Http\Controllers\Student\StudentHomeController@index')->middleware('role:Student');

// //student notifications
// Route::get('/student/notifications', 'App\Http\Controllers\Student\NotificationController@index')->middleware('role:Student');
// Route::get('/student/notifications/{notification}', 'App\Http\Controllers\Student\NotificationController@show')->middleware('role:Student');

// //student course bookings
// Route::get('/student/course-bookings', 'App\Http\Controllers\Student\Course\BookingsController@index')->middleware('role:Student');
// Route::get('/student/course-bookings/create', 'App\Http\Controllers\Student\Course\BookingsController@create')->middleware('role:Student');
// Route::post('/student/course-bookings', 'App\Http\Controllers\Student\Course\BookingsController@store')->middleware('role:Student');
// Route::get('/student/course-bookings/{booking}/edit', 'App\Http\Controllers\Student\Course\BookingsController@edit')->middleware('role:Student');
// Route::any('/student/course-bookings/{booking}/esewaSuccess','App\Http\Controllers\Student\Course\BookingsController@esewaSuccess')->middleware('role:Student');
// Route::post('/student/course-bookings/{booking}/khaltiSuccess','App\Http\Controllers\Student\Course\BookingsController@khaltiSuccess')->middleware('role:Student');
// Route::any('/student/course-bookings/{booking}/payment-failed','App\Http\Controllers\Student\Course\BookingsController@paymentFailed')->middleware('role:Student');
// Route::get('/student/course-bookings/{booking}', 'App\Http\Controllers\Student\Course\BookingsController@show')->middleware('role:Student');
// Route::patch('/student/course-bookings/{booking}','App\Http\Controllers\Student\Course\BookingsController@update')->middleware('role:Student');
// Route::delete('/student/course-bookings/{booking}', 'App\Http\Controllers\Student\Course\BookingsController@destroy')->middleware('role:Student');

// Route::get('/student/course-classroom', 'App\Http\Controllers\Student\Course\BookingsController@classroom')->middleware('role:Student');

// //classroom batch exams
// Route::get('/student/classroom/exams/{batch}','App\Http\Controllers\Student\Course\ExamController@index');
// Route::get('/student/classroom/exams/{batch}/mcq-exams/{exam}/attempt','App\Http\Controllers\Student\Course\ExamController@takeExam');
// Route::post('/student/classroom/exams/{batch}/mcq-exams/{exam}/result','App\Http\Controllers\Student\Course\ExamController@store')->middleware('role:Student');
// Route::get('/student/classroom/exams/{batch}/mcq-exams/{exam}/view','App\Http\Controllers\Student\Course\ExamController@show');
// Route::delete('/student/classroom/exams/{batch}/mcq-exams/{exam}/reset','App\Http\Controllers\Student\Course\ExamController@reset')->middleware('role:Student');

//student ebook booking
Route::get('/student/ebook-bookings','App\Http\Controllers\Student\Ebook\BookingController@index')->middleware('role:Student');
Route::get('/student/ebook-bookings/create','App\Http\Controllers\Student\Ebook\BookingController@create')->middleware('role:Student');
Route::post('/student/ebook-bookings','App\Http\Controllers\Student\Ebook\BookingController@store')->middleware('role:Student');
Route::get('/student/ebook-bookings/{booking}/edit','App\Http\Controllers\Student\Ebook\BookingController@edit')->middleware('role:Student');
Route::get('/student/ebook-bookings/{booking}/esewaSuccess','App\Http\Controllers\Student\Ebook\BookingController@esewaSuccess')->middleware('role:Student');
Route::post('/student/ebook-bookings/{booking}/khaltiSuccess','App\Http\Controllers\Student\Ebook\BookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/ebook-bookings/{booking}/payment-failed','App\Http\Controllers\Student\Ebook\BookingController@paymentFailed')->middleware('role:Student');
Route::patch('/student/ebook-bookings/{booking}','App\Http\Controllers\Student\Ebook\BookingController@update')->middleware('role:Student');
Route::delete('/student/ebook-bookings/{booking}','App\Http\Controllers\Student\Ebook\BookingController@destroy')->middleware('role:Student');

//student ebook chapters
Route::get('/student/ebook-bookings/{booking}/chapters','App\Http\Controllers\Student\Ebook\ChapterController@index')->middleware('role:Student');
Route::get('/student/ebook-bookings/{booking}/chapters/{chapter}','App\Http\Controllers\Student\Ebook\ChapterController@show')->middleware('role:Student');

//student section exam set booking section
Route::get('/student/exam-bookings','App\Http\Controllers\Student\ExamHall\ExamBookingController@index')->middleware('role:Student');
Route::get('/student/exam-bookings/create','App\Http\Controllers\Student\ExamHall\ExamBookingController@enroll')->middleware('role:Student');
Route::post('/student/exam-bookings','App\Http\Controllers\Student\ExamHall\ExamBookingController@store')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/edit','App\Http\Controllers\Student\ExamHall\ExamBookingController@edit')->middleware('role:Student');
Route::patch('/student/exam-bookings/{booking}','App\Http\Controllers\Student\ExamHall\ExamBookingController@manualVerify')->middleware('role:Student');
Route::delete('/student/exam-bookings/{booking}','App\Http\Controllers\Student\ExamHall\ExamBookingController@destroy')->middleware('role:Student');

Route::get('/student/exam-bookings/{booking}/esewaSuccess','App\Http\Controllers\Student\ExamHall\ExamBookingController@esewaSuccess')->middleware('role:Student');
Route::post('/student/exam-bookings/{booking}/khaltiSuccess','App\Http\Controllers\Student\ExamHall\ExamBookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/payment-failed','App\Http\Controllers\Student\ExamHall\ExamBookingController@paymentFailed')->middleware('role:Student');

Route::get('/student/exam-bookings/{category}/exams','App\Http\Controllers\Student\ExamHall\ExamController@index')->middleware('role:Student');
Route::get('/student/exam-bookings/{category}/exams/{exam}/attempt','App\Http\Controllers\Student\ExamHall\ExamController@takeExam')->middleware('role:Student');
Route::post('/student/exam-bookings/{category}/exams/{exam}/save','App\Http\Controllers\Student\ExamHall\ExamController@store')->middleware('role:Student');
Route::get('/student/exam-bookings/{category}/exams/{exam}/view','App\Http\Controllers\Student\ExamHall\ExamController@show')->middleware('role:Student');
Route::delete('/student/exam-bookings/{category}/exams/{exam}/reset','App\Http\Controllers\Student\ExamHall\ExamController@resetExam')->middleware('role:Student');

//exam hall cqc student section
Route::get('/student/exam-bookings/{category}/cqc','App\Http\Controllers\Student\ExamHall\CQCController@index');
Route::post('/student/exam-bookings/{category}/cqc','App\Http\Controllers\Student\ExamHall\CQCController@store');







// //student messenger
// Route::get('/student/messenger', 'App\Http\Controllers\student\MessengerController@index')->middleware('role:Student');
// Route::get('/student/messenger/{id}/chat', 'App\Http\Controllers\student\MessengerController@chatShow')->middleware('role:Student');
// Route::post('/student/messenger/{id}/chat', 'App\Http\Controllers\student\MessengerController@chatSave')->middleware('role:Student');

// //student video course bookings
// Route::get('/student/video-course','App\Http\Controllers\student\Video\BookingController@index')->middleware('role:Student');
// Route::get('/student/video-course/enroll','App\Http\Controllers\student\Video\BookingController@create')->middleware('role:Student');
// Route::post('/student/video-course','App\Http\Controllers\student\Video\BookingController@store')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/edit','App\Http\Controllers\student\Video\BookingController@edit')->middleware('role:Student');
// Route::patch('/student/video-course/{booking}','App\Http\Controllers\student\Video\BookingController@update')->middleware('role:Student');
// Route::delete('/student/video-course/{booking}','App\Http\Controllers\student\Video\BookingController@destroy')->middleware('role:Student');

// Route::get('/student/video-course/{booking}/esewaSuccess','App\Http\Controllers\student\Video\BookingController@esewaSuccess')->middleware('role:Student');
// Route::post('/student/video-course/{booking}/khaltiSuccess','App\Http\Controllers\student\Video\BookingController@khaltiSuccess')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/payment-failed','App\Http\Controllers\student\Video\BookingController@paymentFailed')->middleware('role:Student');

// //student video course and chapters
// Route::get('/student/video-course/{booking}/chapters','App\Http\Controllers\student\Video\CourseController@chapters')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/chapters/{chapter}/videos','App\Http\Controllers\student\Video\CourseController@videos')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/chapters/{chapter}/videos/{video}','App\Http\Controllers\student\Video\CourseController@show')->middleware('role:Student');

// //student video course cqc
// Route::get('/student/video-course/{booking}/cqc','App\Http\Controllers\student\Video\CQCController@index')->middleware('role:Student');
// Route::post('/student/video-course/{booking}/cqc','App\Http\Controllers\student\Video\CQCController@store')->middleware('role:Student');

// //student video course exams
// Route::get('/student/video-course/{booking}/exams','App\Http\Controllers\student\Video\ExamController@index')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/exams/{exam}/attempt','App\Http\Controllers\student\Video\ExamController@takeExam')->middleware('role:Student');
// Route::post('/student/video-course/{booking}/exams/{exam}/save','App\Http\Controllers\student\Video\ExamController@saveExam')->middleware('role:Student');
// Route::get('/student/video-course/{booking}/exams/{exam}/view','App\Http\Controllers\student\Video\ExamController@viewExam')->middleware('role:Student');
// Route::delete('/student/video-course/{booking}/exams/{exam}/reset','App\Http\Controllers\student\Video\ExamController@resetExam')->middleware('role:Student');


// //student free orientation class mgmt
// Route::get('/student/free-orientations','App\Http\Controllers\student\StudentHomeController@orientations')->middleware('role:Student');













// //admin manual bookings
// Route::get('/admin/manual-booking','App\Http\Controllers\ManualBookingController@index')->middleware('role:Admin');
// Route::get('/admin/manual-booking/{mbooking}/edit','App\Http\Controllers\ManualBookingController@edit')->middleware('role:Admin');
// Route::patch('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@update')->middleware('role:Admin');
// Route::delete('/admin/manual-booking/{mbooking}','App\Http\Controllers\ManualBookingController@destroy')->middleware('role:Admin');
// Route::get('/admin/manual-booking/{id}','App\Http\Controllers\ManualBookingController@view')->middleware('role:Admin');

// // admin tutors routes
// Route::get('/admin/tutors', 'App\Http\Controllers\Admin\tutors\TutorController@index')->middleware('role:Admin');
// Route::get('/admin/tutors/create', 'App\Http\Controllers\Admin\tutors\TutorController@create')->middleware('role:Admin');
// Route::post('/admin/tutors', 'App\Http\Controllers\Admin\tutors\TutorController@store')->middleware('role:Admin');
// Route::get('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@show')->middleware('role:Admin');
// Route::get('/admin/tutors/{tutor}/edit', 'App\Http\Controllers\Admin\tutors\TutorController@edit')->middleware('role:Admin');
// Route::patch('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@update')->middleware('role:Admin');
// Route::delete('/admin/tutors/{tutor}', 'App\Http\Controllers\Admin\tutors\TutorController@destroy')->middleware('role:Admin');
// Route::get('/admin/tutors/{tutor}/reviews', 'App\Http\Controllers\Admin\tutors\TutorController@getReviews')->middleware('role:Admin');
// Route::patch('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\Admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
// Route::put('/admin/tutors/{tutor}/review/{review}/{status}','App\Http\Controllers\Admin\tutors\TutorController@updateReviews')->middleware('role:Admin');
// Route::delete('/admin/tutors/{tutor}/review/{review}/delete','App\Http\Controllers\Admin\tutors\TutorController@destroyReview')->middleware('role:Admin');


// Route::get('/admin/enquiry-form','App\Http\Controllers\Leads\EnquiryController@getEnquiryFormList')->middleware('role:Admin');
// Route::post('/admin/enquiry-form','App\Http\Controllers\Leads\EnquiryController@saveEnquiryForm')->middleware('role:Admin');
// Route::delete('/admin/enquiry-form/{form}','App\Http\Controllers\Leads\EnquiryController@deleteEnquiryForm')->middleware('role:Admin');


// // admin free videos
// Route::get('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@index')->middleware('role:Admin');
// Route::get('/admin/free-videos/create','App\Http\Controllers\Admin\FreeVideoController@create')->middleware('role:Admin');
// Route::post('/admin/free-videos','App\Http\Controllers\Admin\FreeVideoController@store')->middleware('role:Admin');
// Route::delete('/admin/free-videos/{video}','App\Http\Controllers\Admin\FreeVideoController@destroy')->middleware('role:Admin');


// //admin video course categories
// Route::get('/admin/video-category','App\Http\Controllers\Admin\Video\CategoryController@index')->middleware('role:Admin');
// Route::get('/admin/video-category/create','App\Http\Controllers\Admin\Video\CategoryController@create')->middleware('role:Admin');
// Route::post('/admin/video-category','App\Http\Controllers\Admin\Video\CategoryController@store')->middleware('role:Admin');
// Route::get('/admin/video-category/{category}/edit','App\Http\Controllers\Admin\Video\CategoryController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-category/{category}','App\Http\Controllers\Admin\Video\CategoryController@update')->middleware('role:Admin');
// Route::delete('/admin/video-category/{category}','App\Http\Controllers\Admin\Video\CategoryController@destroy')->middleware('role:Admin');

// //admin video courses
// Route::get('/admin/video-course','App\Http\Controllers\Admin\Video\CourseController@index')->middleware('role:Admin');
// Route::get('/admin/video-course/create','App\Http\Controllers\Admin\Video\CourseController@create')->middleware('role:Admin');
// Route::post('/admin/video-course','App\Http\Controllers\Admin\Video\CourseController@store')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@show')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/edit','App\Http\Controllers\Admin\Video\CourseController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@update')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}','App\Http\Controllers\Admin\Video\CourseController@destroy')->middleware('role:Admin');

// Route::get('/admin/video-course/{course}/booking','App\Http\Controllers\Admin\Video\CourseController@booking')->middleware('role:Admin');

// //admin video course chapters
// Route::get('/admin/video-course/{course}/chapters','App\Http\Controllers\Admin\Video\ChapterController@index')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/chapters/create','App\Http\Controllers\Admin\Video\ChapterController@create')->middleware('role:Admin');
// Route::post('/admin/video-course/{course}/chapters','App\Http\Controllers\Admin\Video\ChapterController@store')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/chapters/{chapter}/edit','App\Http\Controllers\Admin\Video\ChapterController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\Admin\Video\ChapterController@update')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}/chapters/{chapter}','App\Http\Controllers\Admin\Video\ChapterController@destroy')->middleware('role:Admin');

// //admin video course chapters video posts
// Route::get('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\Admin\Video\VideoController@index')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/create','App\Http\Controllers\Admin\Video\VideoController@create')->middleware('role:Admin');
// Route::post('/admin/video-course/{course}/chapters/{chapter}/videos','App\Http\Controllers\Admin\Video\VideoController@store')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@show')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/chapters/{chapter}/videos/{video}/edit','App\Http\Controllers\Admin\Video\VideoController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@update')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}/chapters/{chapter}/videos/{video}','App\Http\Controllers\Admin\Video\VideoController@destroy')->middleware('role:Admin');

// //admin video course bookings
// Route::get('/admin/video-booking','App\Http\Controllers\Admin\Video\BookingController@index')->middleware('role:Admin');
// Route::get('/admin/video-booking/all','App\Http\Controllers\Admin\Video\BookingController@allBookings')->middleware('role:Admin');
// Route::get('/admin/video-booking/create','App\Http\Controllers\Admin\Video\BookingController@create')->middleware('role:Admin');
// Route::post('/admin/video-booking','App\Http\Controllers\Admin\Video\BookingController@store')->middleware('role:Admin');
// Route::get('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@show')->middleware('role:Admin');
// Route::get('/admin/video-booking/{booking}/edit','App\Http\Controllers\Admin\Video\BookingController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@update')->middleware('role:Admin');
// Route::delete('/admin/video-booking/{booking}','App\Http\Controllers\Admin\Video\BookingController@destroy')->middleware('role:Admin');

// //admin video course mcq exams
// Route::get('/admin/video-course/{course}/exams','App\Http\Controllers\Admin\Video\ExamController@index')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/exams/create','App\Http\Controllers\Admin\Video\ExamController@create')->middleware('role:Admin');
// Route::post('/admin/video-course/{course}/exams','App\Http\Controllers\Admin\Video\ExamController@store')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}/exams/{exam}','App\Http\Controllers\Admin\Video\ExamController@destroy')->middleware('role:Admin');

// // admin video course exam results
// Route::get('/admin/video-course/{course}/exams/{exam}/results','App\Http\Controllers\Admin\Video\ExamController@results')->middleware('role:Admin');


// //admin video course cqq/cqc
// Route::get('/admin/video-course/{course}/cqc','App\Http\Controllers\Admin\Video\CQCController@index')->middleware('role:Admin');
// Route::post('/admin/video-course/{course}/cqc','App\Http\Controllers\Admin\Video\CQCController@store')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}/cqc/{cqc}','App\Http\Controllers\Admin\Video\CQCController@destroy')->middleware('role:Admin');

// //admin video course tutors
// Route::get('/admin/video-course/{course}/tutors','App\Http\Controllers\Admin\Video\TutorController@index')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/tutors/create','App\Http\Controllers\Admin\Video\TutorController@create')->middleware('role:Admin');
// Route::post('/admin/video-course/{course}/tutors','App\Http\Controllers\Admin\Video\TutorController@store')->middleware('role:Admin');
// Route::get('/admin/video-course/{course}/tutors/{tutor}/edit','App\Http\Controllers\Admin\Video\TutorController@edit')->middleware('role:Admin');
// Route::patch('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\Admin\Video\TutorController@update')->middleware('role:Admin');
// Route::delete('/admin/video-course/{course}/tutors/{tutor}','App\Http\Controllers\Admin\Video\TutorController@destroy')->middleware('role:Admin');




// //admin orientation management
// Route::get('/admin/orientations','App\Http\Controllers\Admin\Orientation\OrientationController@index')->middleware('role:Admin');
// Route::get('/admin/orientations/create','App\Http\Controllers\Admin\Orientation\OrientationController@create')->middleware('role:Admin');
// Route::post('/admin/orientations','App\Http\Controllers\Admin\Orientation\OrientationController@store')->middleware('role:Admin');
// Route::get('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@show')->middleware('role:Admin');
// Route::get('/admin/orientations/{orientation}/edit','App\Http\Controllers\Admin\Orientation\OrientationController@edit')->middleware('role:Admin');
// Route::patch('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@update')->middleware('role:Admin');
// Route::delete('/admin/orientations/{orientation}','App\Http\Controllers\Admin\Orientation\OrientationController@destroy')->middleware('role:Admin');

// //admin orientation participants management
// Route::get('/admin/orientations/{orientation}/participants','App\Http\Controllers\Admin\Orientation\ParticipantController@index')->middleware('role:Admin');
// Route::delete('/admin/orientations/{orientation}/participants/{participant}','App\Http\Controllers\Admin\Orientation\ParticipantController@destroy')->middleware('role:Admin');





/********************************************************************************************************************************************************************************************** */
/*--------------------------Front Routes -----------------------------------------------------*/

Route::get('/', 'App\Http\Controllers\FrontController@index');
Route::get('/about-us', 'App\Http\Controllers\FrontController@about');
Route::get('/enquiry', 'App\Http\Controllers\FrontController@enquiry');
Route::get('/enquiry/{courseslug}', 'App\Http\Controllers\FrontController@showCourseEnquiryForm');
Route::get('/free-videos', 'App\Http\Controllers\FrontController@allFreeVideos');
Route::get('/free-videos/{video}', 'App\Http\Controllers\FrontController@playFreeVideo');
Route::get('/page-counter-increment', 'App\Http\Controllers\FrontController@pageCounterIncrement');

// front blogs
Route::get('/blogs','App\Http\Controllers\Blog\BlogController@index');
Route::get('/blogs/{slug}','App\Http\Controllers\Blog\BlogController@show');
Route::post('/blogs/{blog}/comments/add','App\Http\Controllers\Blog\BlogController@addComments');

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

//front ebooks
Route::get('/books','App\Http\Controllers\FrontController@books');
Route::post('/books/{slug}/review/add','App\Http\Controllers\FrontController@addBookReview');
Route::get('/books/{slug}','App\Http\Controllers\FrontController@singleBook');
Route::get('/book-publishers/{slug}/all-books','App\Http\Controllers\FrontController@publisherAllBooks');
Route::get('/book-publishers/{pslug}/category/{cslug}','App\Http\Controllers\FrontController@publisherCategoryBooks');
Route::get('/book-publishers/{slug}','App\Http\Controllers\FrontController@publisherBookCategories');

Route::get('/qr-book-scans/{bslug}/{bsn}','App\Http\Controllers\FrontController@qrBookScanForm');
Route::post('/qr-book-scans/{book}/{member}','App\Http\Controllers\FrontController@qrBookScanMemberStore');

//front library materials
Route::get('/library','App\Http\Controllers\FrontController@getLibrary');
Route::get('/library/{catslug}','App\Http\Controllers\FrontController@getLibraryContents');
Route::get('/library/{catslug}/{matslug}','App\Http\Controllers\FrontController@getLibraryContentDetail');

//front search mgmt
Route::get('/search','App\Http\Controllers\FrontController@search');

//front testimonials
Route::get('/testimonials','App\Http\Controllers\FrontController@getTestimonials');
Route::post('/testimonials/add','App\Http\Controllers\FrontController@addTestimonials');

//front dynamic forms
Route::get('/dynamic-forms/{slug}','App\Http\Controllers\FrontDynamicFormController@showDynamicForm');
Route::post('/dynamic-forms/{slug}','App\Http\Controllers\FrontDynamicFormController@saveDynamicFormApplicant');


//front menu details
Route::get('/{groupslug}/{menuslug}','App\Http\Controllers\FrontController@getMenuCategories');
Route::get('/{groupslug}/{menuslug}/{catslug}','App\Http\Controllers\FrontController@getMenuItems');
Route::get('/{groupslug}/{menuslug}/{catslug}/{itemslug}','App\Http\Controllers\FrontController@getMenuItemDetail');
Route::get('/{groupslug}/{menuslug}/{catslug}/{itemslug}/{subitemslug}','App\Http\Controllers\FrontController@getMenuSubItemDetail');



/******************************************************************************************************************************* */