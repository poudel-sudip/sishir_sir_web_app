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
    // Artisan::call('clear-compiled');
    // Artisan::call('auth:clear-resets');
    // Artisan::call('cache:clear');
    // Artisan::call('config:clear');
    // Artisan::call('event:clear');
    // Artisan::call('route:clear');
    // Artisan::call('view:clear');

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


// google and facebook authentication

Route::get('auth/google', 'App\Http\Controllers\Auth\SocialAuthController@redirectToGoogle');
Route::get('auth/google/callback', 'App\Http\Controllers\Auth\SocialAuthController@handleGoogleCallback');

Route::get('auth/facebook', 'App\Http\Controllers\Auth\SocialAuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'App\Http\Controllers\Auth\SocialAuthController@handleFacebookCallback');


/*-------------------------------all admin section routes---------------------------*/

//final routes for admin section
Route::get('/admin/home', 'App\Http\Controllers\Admin\AdminHomeController@index')->middleware('role:Admin');

//admin user mgmt
Route::get('/admin/users', 'App\Http\Controllers\Admin\Users\UsersController@index')->middleware('role:Admin');
Route::get('/admin/users/create', 'App\Http\Controllers\Admin\Users\UsersController@create')->middleware('role:Admin');
Route::post('/admin/users', 'App\Http\Controllers\Admin\Users\UsersController@store')->middleware('role:Admin');
Route::get('/admin/users/{user}', 'App\Http\Controllers\Admin\Users\UsersController@show')->middleware('role:Admin');
Route::get('/admin/users/{user}/edit', 'App\Http\Controllers\Admin\Users\UsersController@edit')->middleware('role:Admin');
Route::patch('/admin/users/{user}', 'App\Http\Controllers\Admin\Users\UsersController@update')->middleware('role:Admin');
Route::delete('/admin/users/{user}', 'App\Http\Controllers\Admin\Users\UsersController@destroy')->middleware('role:Admin');


//admin mcq exam category
Route::get('/admin/exam-category', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@index')->middleware('role:Admin');
Route::get('/admin/exam-category/create', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@create')->middleware('role:Admin');
Route::post('/admin/exam-category', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@store')->middleware('role:Admin');
Route::patch('/admin/exam-category', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@update')->middleware('role:Admin');
Route::delete('/admin/exam-category/{category}', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/exams', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@exams')->middleware('role:Admin');
Route::get('/admin/exam-category/{category}/getexams', 'App\Http\Controllers\Admin\Exams\ExamCategoryController@catExams')->middleware('role:Admin');

//admin mcq exam mgmt
Route::get('/admin/exams', 'App\Http\Controllers\Admin\Exams\ExamController@index')->middleware('role:Admin');
Route::get('/admin/exams/create', 'App\Http\Controllers\Admin\Exams\ExamController@create')->middleware('role:Admin');
Route::post('/admin/exams', 'App\Http\Controllers\Admin\Exams\ExamController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}', 'App\Http\Controllers\Admin\Exams\ExamController@show')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/edit', 'App\Http\Controllers\Admin\Exams\ExamController@edit')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}', 'App\Http\Controllers\Admin\Exams\ExamController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}', 'App\Http\Controllers\Admin\Exams\ExamController@destroy')->middleware('role:Admin');

// admin mcq exam questions
Route::get('/admin/exams/{exam}/questions', 'App\Http\Controllers\Admin\Exams\QuestionController@index')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/create', 'App\Http\Controllers\Admin\Exams\QuestionController@create')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/upload', 'App\Http\Controllers\Admin\Exams\QuestionController@upload')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions/import', 'App\Http\Controllers\Admin\Exams\QuestionController@import')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/pdf-download', 'App\Http\Controllers\Admin\Exams\QuestionController@pdfDownload')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/download', 'App\Http\Controllers\Admin\Exams\QuestionController@download')->middleware('role:Admin');
Route::post('/admin/exams/{exam}/questions', 'App\Http\Controllers\Admin\Exams\QuestionController@store')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}/edit', 'App\Http\Controllers\Admin\Exams\QuestionController@edit')->middleware('role:Admin');
Route::get('/admin/exams/{exam}/questions/{question}', 'App\Http\Controllers\Admin\Exams\QuestionController@show')->middleware('role:Admin');
Route::patch('/admin/exams/{exam}/questions/{question}', 'App\Http\Controllers\Admin\Exams\QuestionController@update')->middleware('role:Admin');
Route::delete('/admin/exams/{exam}/questions/{question}', 'App\Http\Controllers\Admin\Exams\QuestionController@destroy')->middleware('role:Admin');

//mcq exams associated with batch admin
Route::get('/admin/batches/{batch}/exams', 'App\Http\Controllers\Admin\Exams\BatchExamController@index')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/create', 'App\Http\Controllers\Admin\Exams\BatchExamController@create')->middleware('role:Admin');
Route::post('/admin/batches/{batch}/exams', 'App\Http\Controllers\Admin\Exams\BatchExamController@store')->middleware('role:Admin');
Route::delete('/admin/batches/{batch}/exams/{exam}', 'App\Http\Controllers\Admin\Exams\BatchExamController@destroy')->middleware('role:Admin');
Route::get('/admin/batches/{batch}/exams/{exam}/results', 'App\Http\Controllers\Admin\Exams\BatchExamController@results')->middleware('role:Admin');

//open mcq exams admin
Route::get('/admin/open-exams', 'App\Http\Controllers\Admin\Exams\OpenExamController@index')->middleware('role:Admin');
Route::get('/admin/open-exams/create', 'App\Http\Controllers\Admin\Exams\OpenExamController@create')->middleware('role:Admin');
Route::post('/admin/open-exams', 'App\Http\Controllers\Admin\Exams\OpenExamController@store')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}', 'App\Http\Controllers\Admin\Exams\OpenExamController@show')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/edit', 'App\Http\Controllers\Admin\Exams\OpenExamController@edit')->middleware('role:Admin');
Route::patch('/admin/open-exams/{exam}', 'App\Http\Controllers\Admin\Exams\OpenExamController@update')->middleware('role:Admin');
Route::delete('/admin/open-exams/{exam}', 'App\Http\Controllers\Admin\Exams\OpenExamController@destroy')->middleware('role:Admin');

//open mcq exams results admin
Route::get('/admin/open-exams/{exam}/results', 'App\Http\Controllers\Admin\Exams\OpenExamController@results')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/results/export', 'App\Http\Controllers\Admin\Exams\OpenExamController@export')->middleware('role:Admin');
Route::get('/admin/open-exams/{exam}/results/delete-dublicates', 'App\Http\Controllers\Admin\Exams\OpenExamController@deleteDublicate')->middleware('role:Admin');
Route::delete('/admin/open-exams/{exam}/results/{result}', 'App\Http\Controllers\Admin\Exams\OpenExamController@resultDelete')->middleware('role:Admin');

// admin exam hall exam groups management
Route::get('/admin/exam-hall/groups', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupIndex')->middleware('role:Admin');
Route::get('/admin/exam-hall/groups/create', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupCreate')->middleware('role:Admin');
Route::post('/admin/exam-hall/groups', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupStore')->middleware('role:Admin');
Route::get('/admin/exam-hall/groups/{group}/edit', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupEdit')->middleware('role:Admin');
Route::patch('/admin/exam-hall/groups/{group}', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupUpdate')->middleware('role:Admin');
Route::delete('/admin/exam-hall/groups/{group}', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupDestroy')->middleware('role:Admin');
Route::get('/admin/exam-hall/groups/{group}/exam-sets', 'App\Http\Controllers\Admin\ExamHall\ExamGroupController@groupExamSets')->middleware('role:Admin');

//routes for exam hall admin section
Route::get('/admin/exam-hall', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/create', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@store')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/edit', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@edit')->middleware('role:Admin');
Route::patch('/admin/exam-hall/{category}', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@destroy')->middleware('role:Admin');

Route::get('/admin/exam-hall/{category}/exams', 'App\Http\Controllers\Admin\ExamHall\ExamHallExamController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/create', 'App\Http\Controllers\Admin\ExamHall\ExamHallExamController@create')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/exams', 'App\Http\Controllers\Admin\ExamHall\ExamHallExamController@store')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/exams/{exam}', 'App\Http\Controllers\Admin\ExamHall\ExamHallExamController@destroy')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/exams/{exam}/results', 'App\Http\Controllers\Admin\ExamHall\ExamHallExamController@results')->middleware('role:Admin');

//admin section exam hall booking
Route::get('/admin/exam-hall/bookings', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@index')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/all', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/create', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@create')->middleware('role:Admin');
Route::get('/admin/exam-hall/{category}/bookings', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@setBookings')->middleware('role:Admin');
Route::post('/admin/exam-hall/bookings', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@store')->middleware('role:Admin');

Route::get('/admin/exam-hall/bookings/{booking}/edit', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@edit')->middleware('role:Admin');
Route::get('/admin/exam-hall/bookings/{booking}', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@show')->middleware('role:Admin');
Route::patch('/admin/exam-hall/bookings/{booking}', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@update')->middleware('role:Admin');
Route::delete('/admin/exam-hall/bookings/{booking}', 'App\Http\Controllers\Admin\ExamHall\ExamHallBookingController@destroy')->middleware('role:Admin');

//exam hall cqc admin section
Route::get('/admin/exam-hall/{category}/cqc', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcindex')->middleware('role:Admin');
Route::post('/admin/exam-hall/{category}/cqc', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcstore')->middleware('role:Admin');
Route::delete('/admin/exam-hall/{category}/cqc/{cqc}', 'App\Http\Controllers\Admin\ExamHall\ExamHallController@cqcdestroy')->middleware('role:Admin');

// admin pdf bank categories
Route::get('/admin/pdf-bank/categories', 'App\Http\Controllers\Admin\PdfBank\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/pdf-bank/categories/create', 'App\Http\Controllers\Admin\PdfBank\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/pdf-bank/categories', 'App\Http\Controllers\Admin\PdfBank\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/pdf-bank/categories/{category}/edit', 'App\Http\Controllers\Admin\PdfBank\CategoryController@edit')->middleware('role:Admin');
Route::patch('/admin/pdf-bank/categories/{category}', 'App\Http\Controllers\Admin\PdfBank\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/pdf-bank/categories/{category}', 'App\Http\Controllers\Admin\PdfBank\CategoryController@destroy')->middleware('role:Admin');
Route::get('/admin/pdf-bank/categories/{category}/groups', 'App\Http\Controllers\Admin\PdfBank\CategoryController@groups')->middleware('role:Admin');
Route::get('/admin/pdf-bank/categories/{category}/singles', 'App\Http\Controllers\Admin\PdfBank\CategoryController@singles')->middleware('role:Admin');

//admin pdf bank groups 
Route::get('/admin/pdf-bank/pdf-groups', 'App\Http\Controllers\Admin\PdfBank\GroupController@index')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/create', 'App\Http\Controllers\Admin\PdfBank\GroupController@create')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-groups', 'App\Http\Controllers\Admin\PdfBank\GroupController@store')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}', 'App\Http\Controllers\Admin\PdfBank\GroupController@show')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/edit', 'App\Http\Controllers\Admin\PdfBank\GroupController@edit')->middleware('role:Admin');
Route::patch('/admin/pdf-bank/pdf-groups/{group}', 'App\Http\Controllers\Admin\PdfBank\GroupController@update')->middleware('role:Admin');
Route::delete('/admin/pdf-bank/pdf-groups/{group}', 'App\Http\Controllers\Admin\PdfBank\GroupController@destroy')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/bookings', 'App\Http\Controllers\Admin\PdfBank\GroupController@bookings')->middleware('role:Admin');

//admin pdf bank singles 
Route::get('/admin/pdf-bank/pdf-singles', 'App\Http\Controllers\Admin\PdfBank\SingleController@index')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-singles/import', 'App\Http\Controllers\Admin\PdfBank\SingleController@importForm')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-singles/copy', 'App\Http\Controllers\Admin\PdfBank\SingleController@copyPdfFromLibrary')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-singles/create', 'App\Http\Controllers\Admin\PdfBank\SingleController@create')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-singles', 'App\Http\Controllers\Admin\PdfBank\SingleController@store')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-singles/{single}', 'App\Http\Controllers\Admin\PdfBank\SingleController@show')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-singles/{single}/edit', 'App\Http\Controllers\Admin\PdfBank\SingleController@edit')->middleware('role:Admin');
Route::patch('/admin/pdf-bank/pdf-singles/{single}', 'App\Http\Controllers\Admin\PdfBank\SingleController@update')->middleware('role:Admin');
Route::delete('/admin/pdf-bank/pdf-singles/{single}', 'App\Http\Controllers\Admin\PdfBank\SingleController@destroy')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-singles/{single}/bookings', 'App\Http\Controllers\Admin\PdfBank\SingleController@bookings')->middleware('role:Admin');


// admin pdf bank contents
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@index')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files/create', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@create')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-groups/{group}/pdf-files', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@store')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files/import-library', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@importLibraryForm')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-groups/{group}/pdf-files/copy-library', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@copyPdfFromLibrary')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files/import-singles', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@importSinglesForm')->middleware('role:Admin');
Route::post('/admin/pdf-bank/pdf-groups/{group}/pdf-files/copy-singles', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@copyPdfFromSingles')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files/{content}', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@show')->middleware('role:Admin');
Route::get('/admin/pdf-bank/pdf-groups/{group}/pdf-files/{content}/edit', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@edit')->middleware('role:Admin');
Route::patch('/admin/pdf-bank/pdf-groups/{group}/pdf-files/{content}', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@update')->middleware('role:Admin');
Route::delete('/admin/pdf-bank/pdf-groups/{group}/pdf-files/{content}', 'App\Http\Controllers\Admin\PdfBank\ContentFileController@destroy')->middleware('role:Admin');

//admin pdf bank bookings
Route::get('/admin/pdf-bank-bookings', 'App\Http\Controllers\Admin\PdfBank\BookingController@index')->middleware('role:Admin');
Route::get('/admin/pdf-bank-bookings/all', 'App\Http\Controllers\Admin\PdfBank\BookingController@allBookings')->middleware('role:Admin');
Route::get('/admin/pdf-bank-bookings/create', 'App\Http\Controllers\Admin\PdfBank\BookingController@create')->middleware('role:Admin');
Route::post('/admin/pdf-bank-bookings', 'App\Http\Controllers\Admin\PdfBank\BookingController@store')->middleware('role:Admin');
Route::get('/admin/pdf-bank-bookings/{booking}', 'App\Http\Controllers\Admin\PdfBank\BookingController@show')->middleware('role:Admin');
Route::get('/admin/pdf-bank-bookings/{booking}/edit', 'App\Http\Controllers\Admin\PdfBank\BookingController@edit')->middleware('role:Admin');
Route::patch('/admin/pdf-bank-bookings/{booking}', 'App\Http\Controllers\Admin\PdfBank\BookingController@update')->middleware('role:Admin');
Route::delete('/admin/pdf-bank-bookings/{booking}', 'App\Http\Controllers\Admin\PdfBank\BookingController@destroy')->middleware('role:Admin');

//admin merchant wise bookings
Route::get('/admin/booking-through-merchant', 'App\Http\Controllers\Admin\MerchantBookingController@index')->middleware('role:Admin');

//blogs managing by admin
Route::get('/admin/blogs', 'App\Http\Controllers\Admin\Blog\BlogController@index')->middleware('role:Admin');
Route::get('/admin/blogs/create', 'App\Http\Controllers\Admin\Blog\BlogController@create')->middleware('role:Admin');
Route::post('/admin/blogs', 'App\Http\Controllers\Admin\Blog\BlogController@store')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}', 'App\Http\Controllers\Admin\Blog\BlogController@show')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/edit', 'App\Http\Controllers\Admin\Blog\BlogController@edit')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}', 'App\Http\Controllers\Admin\Blog\BlogController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}', 'App\Http\Controllers\Admin\Blog\BlogController@destroy')->middleware('role:Admin');
Route::get('/admin/blogs/{blog}/comments', 'App\Http\Controllers\Admin\Blog\CommentController@index')->middleware('role:Admin');
Route::patch('/admin/blogs/{blog}/comment/{comment}/{status}', 'App\Http\Controllers\Admin\Blog\CommentController@update')->middleware('role:Admin');
Route::put('/admin/blogs/{blog}/comment/{comment}/{status}', 'App\Http\Controllers\Admin\Blog\CommentController@update')->middleware('role:Admin');
Route::delete('/admin/blogs/{blog}/comment/{comment}/delete', 'App\Http\Controllers\Admin\Blog\CommentController@destroy')->middleware('role:Admin');

//admin sliders mgmt
Route::get('/admin/sliders', 'App\Http\Controllers\Admin\SliderController@index')->middleware('role:Admin');
Route::get('/admin/sliders/create', 'App\Http\Controllers\Admin\SliderController@create')->middleware('role:Admin');
Route::post('/admin/sliders', 'App\Http\Controllers\Admin\SliderController@store')->middleware('role:Admin');
Route::get('/admin/sliders/{slider}/edit', 'App\Http\Controllers\Admin\SliderController@edit')->middleware('role:Admin');
Route::patch('/admin/sliders/{slider}', 'App\Http\Controllers\Admin\SliderController@update')->middleware('role:Admin');
Route::delete('/admin/sliders/{slider}', 'App\Http\Controllers\Admin\SliderController@destroy')->middleware('role:Admin');

//admin home pop up
Route::get('/admin/home-popup', 'App\Http\Controllers\Admin\HomePopupController@index')->middleware('role:Admin');
Route::get('/admin/home-popup/create', 'App\Http\Controllers\Admin\HomePopupController@create')->middleware('role:Admin');
Route::post('/admin/home-popup', 'App\Http\Controllers\Admin\HomePopupController@store')->middleware('role:Admin');
Route::get('/admin/home-popup/{popup}/edit', 'App\Http\Controllers\Admin\HomePopupController@edit')->middleware('role:Admin');
Route::patch('/admin/home-popup/{popup}', 'App\Http\Controllers\Admin\HomePopupController@update')->middleware('role:Admin');
Route::delete('/admin/home-popup/{popup}', 'App\Http\Controllers\Admin\HomePopupController@destroy')->middleware('role:Admin');

//admin testimonials management
Route::get('/admin/testimonials', 'App\Http\Controllers\Admin\TestimonialController@index')->middleware('role:Admin');
Route::get('/admin/testimonials/create', 'App\Http\Controllers\Admin\TestimonialController@create')->middleware('role:Admin');
Route::post('/admin/testimonials', 'App\Http\Controllers\Admin\TestimonialController@store')->middleware('role:Admin');
Route::get('/admin/testimonials/{testimonial}/edit', 'App\Http\Controllers\Admin\TestimonialController@edit')->middleware('role:Admin');
Route::patch('/admin/testimonials/{testimonial}', 'App\Http\Controllers\Admin\TestimonialController@update')->middleware('role:Admin');
Route::delete('/admin/testimonials/{testimonial}', 'App\Http\Controllers\Admin\TestimonialController@destroy')->middleware('role:Admin');

// admin leads and enquiries
Route::get('/leads/enquiries', 'App\Http\Controllers\Leads\EnquiryController@index')->middleware('role:Admin');
Route::post('/leads/enquiries/add', 'App\Http\Controllers\Leads\EnquiryController@store');
Route::get('/leads/enquiries/filter', 'App\Http\Controllers\Leads\EnquiryController@filterFormShow')->middleware('role:Admin');
Route::post('/leads/enquiries/filter', 'App\Http\Controllers\Leads\EnquiryController@filterResults')->middleware('role:Admin');
Route::get('/leads/enquiries/{enquiry}/edit', 'App\Http\Controllers\Leads\EnquiryController@edit')->middleware('role:Admin');
Route::patch('/leads/enquiries/{enquiry}', 'App\Http\Controllers\Leads\EnquiryController@update')->middleware('role:Admin');
Route::delete('/leads/enquiries/{enquiry}', 'App\Http\Controllers\Leads\EnquiryController@destroy')->middleware('role:Admin');

//admin career vaccancy mgmt
Route::get('/admin/careers', 'App\Http\Controllers\Admin\Career\VaccancyController@index')->middleware('role:Admin');
Route::get('/admin/careers/create', 'App\Http\Controllers\Admin\Career\VaccancyController@create')->middleware('role:Admin');
Route::post('/admin/careers', 'App\Http\Controllers\Admin\Career\VaccancyController@store')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}', 'App\Http\Controllers\Admin\Career\VaccancyController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/edit', 'App\Http\Controllers\Admin\Career\VaccancyController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}', 'App\Http\Controllers\Admin\Career\VaccancyController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}', 'App\Http\Controllers\Admin\Career\VaccancyController@destroy')->middleware('role:Admin');

//admin carrier vaccancy tags
Route::get('/admin/careers-tag', 'App\Http\Controllers\Admin\Career\TagController@index')->middleware('role:Admin');
Route::get('/admin/careers-tag/create', 'App\Http\Controllers\Admin\Career\TagController@create')->middleware('role:Admin');
Route::post('/admin/careers-tag', 'App\Http\Controllers\Admin\Career\TagController@store')->middleware('role:Admin');
Route::patch('/admin/careers-tag', 'App\Http\Controllers\Admin\Career\TagController@update')->middleware('role:Admin');
Route::delete('/admin/careers-tag/{tag}', 'App\Http\Controllers\Admin\Career\TagController@destroy')->middleware('role:Admin');
Route::get('/admin/careers-tag/{tag}/vaccancies', 'App\Http\Controllers\Admin\Career\TagController@vaccancies')->middleware('role:Admin');


//career applicants mgmt
Route::get('/admin/careers/{vaccancy}/applicants', 'App\Http\Controllers\Admin\Career\ApplicantController@index')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}', 'App\Http\Controllers\Admin\Career\ApplicantController@show')->middleware('role:Admin');
Route::get('/admin/careers/{vaccancy}/applicants/{applicant}/edit', 'App\Http\Controllers\Admin\Career\ApplicantController@edit')->middleware('role:Admin');
Route::patch('/admin/careers/{vaccancy}/applicants/{applicant}', 'App\Http\Controllers\Admin\Career\ApplicantController@update')->middleware('role:Admin');
Route::delete('/admin/careers/{vaccancy}/applicants/{applicant}', 'App\Http\Controllers\Admin\Career\ApplicantController@destroy')->middleware('role:Admin');

//admin provience mgmt
Route::get('/admin/provience', 'App\Http\Controllers\Admin\Provience\ProvienceController@provienceList')->middleware('role:Admin');
Route::get('/admin/provience/create', 'App\Http\Controllers\Admin\Provience\ProvienceController@createProvience')->middleware('role:Admin');
Route::post('/admin/provience', 'App\Http\Controllers\Admin\Provience\ProvienceController@saveProvience')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/edit', 'App\Http\Controllers\Admin\Provience\ProvienceController@editProvience')->middleware('role:Admin');
Route::patch('/admin/provience/{provience}', 'App\Http\Controllers\Admin\Provience\ProvienceController@updateProvience')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}', 'App\Http\Controllers\Admin\Provience\ProvienceController@destroyProvience')->middleware('role:Admin');

//admin provience district/city mgmt
Route::get('/admin/provience/{provience}/district-city', 'App\Http\Controllers\Admin\Provience\DistrictCityController@index')->middleware('role:Admin');
Route::get('/admin/provience/{provience}/district-city/create', 'App\Http\Controllers\Admin\Provience\DistrictCityController@create')->middleware('role:Admin');
Route::post('/admin/provience/{provience}/district-city', 'App\Http\Controllers\Admin\Provience\DistrictCityController@store')->middleware('role:Admin');
Route::delete('/admin/provience/{provience}/district-city/{city}', 'App\Http\Controllers\Admin\Provience\DistrictCityController@destroy')->middleware('role:Admin');

//admin uploads section management
//syllabus management admin
Route::resource('/admin/syllabus', App\Http\Controllers\Admin\SyllabusController::class)->middleware('role:Admin');
Route::get('/admin/syllabus/{id}/delete', [App\Http\Controllers\Admin\SyllabusController::class, 'destroy']);

//study Materials management admin
Route::resource('/admin/studyMaterials', App\Http\Controllers\Admin\StudyMaterialController::class)->middleware('role:Admin');
Route::get('/admin/studyMaterials/{id}/delete', [App\Http\Controllers\Admin\StudyMaterialController::class, 'destroy']);

//admin menu group mgmt
Route::get('/admin/menus', 'App\Http\Controllers\Admin\Menus\GroupController@index')->middleware('role:Admin');
Route::get('/admin/menus/create', 'App\Http\Controllers\Admin\Menus\GroupController@create')->middleware('role:Admin');
Route::post('/admin/menus', 'App\Http\Controllers\Admin\Menus\GroupController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/edit', 'App\Http\Controllers\Admin\Menus\GroupController@edit')->middleware('role:Admin');
Route::patch('/admin/menus/{group}', 'App\Http\Controllers\Admin\Menus\GroupController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}', 'App\Http\Controllers\Admin\Menus\GroupController@destroy')->middleware('role:Admin');

//admin menu sub group mgmt
Route::get('/admin/menus/{group}/sub-groups', 'App\Http\Controllers\Admin\Menus\SubGroupController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/create', 'App\Http\Controllers\Admin\Menus\SubGroupController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups', 'App\Http\Controllers\Admin\Menus\SubGroupController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/edit', 'App\Http\Controllers\Admin\Menus\SubGroupController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}', 'App\Http\Controllers\Admin\Menus\SubGroupController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}', 'App\Http\Controllers\Admin\Menus\SubGroupController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}', 'App\Http\Controllers\Admin\Menus\SubGroupController@destroy')->middleware('role:Admin');

//admin menu item category mgmt
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories', 'App\Http\Controllers\Admin\Menus\CategoryController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/create', 'App\Http\Controllers\Admin\Menus\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories', 'App\Http\Controllers\Admin\Menus\CategoryController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/edit', 'App\Http\Controllers\Admin\Menus\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}', 'App\Http\Controllers\Admin\Menus\CategoryController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}', 'App\Http\Controllers\Admin\Menus\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}', 'App\Http\Controllers\Admin\Menus\CategoryController@destroy')->middleware('role:Admin');


// admin menu item management 
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items', 'App\Http\Controllers\Admin\Menus\ItemController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/create', 'App\Http\Controllers\Admin\Menus\ItemController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items', 'App\Http\Controllers\Admin\Menus\ItemController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/edit', 'App\Http\Controllers\Admin\Menus\ItemController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}', 'App\Http\Controllers\Admin\Menus\ItemController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}', 'App\Http\Controllers\Admin\Menus\ItemController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}', 'App\Http\Controllers\Admin\Menus\ItemController@destroy')->middleware('role:Admin');

// admin menu sub-item management 
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items', 'App\Http\Controllers\Admin\Menus\SubItemController@index')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/create', 'App\Http\Controllers\Admin\Menus\SubItemController@create')->middleware('role:Admin');
Route::post('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items', 'App\Http\Controllers\Admin\Menus\SubItemController@store')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}/edit', 'App\Http\Controllers\Admin\Menus\SubItemController@edit')->middleware('role:Admin');
Route::get('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}', 'App\Http\Controllers\Admin\Menus\SubItemController@show')->middleware('role:Admin');
Route::patch('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}', 'App\Http\Controllers\Admin\Menus\SubItemController@update')->middleware('role:Admin');
Route::delete('/admin/menus/{group}/sub-groups/{subgroup}/categories/{category}/items/{item}/sub-items/{subitem}', 'App\Http\Controllers\Admin\Menus\SubItemController@destroy')->middleware('role:Admin');

// admin personal books management 

Route::get('/admin/books/publishers', 'App\Http\Controllers\Admin\Books\BookController@publisherIndex')->middleware('role:Admin');
Route::get('/admin/books/publishers/create', 'App\Http\Controllers\Admin\Books\BookController@publisherCreate')->middleware('role:Admin');
Route::post('/admin/books/publishers', 'App\Http\Controllers\Admin\Books\BookController@publisherStore')->middleware('role:Admin');
Route::get('/admin/books/publishers/{category}/edit', 'App\Http\Controllers\Admin\Books\BookController@publisherEdit')->middleware('role:Admin');
Route::patch('/admin/books/publishers/{category}', 'App\Http\Controllers\Admin\Books\BookController@publisherUpdate')->middleware('role:Admin');
Route::delete('/admin/books/publishers/{category}', 'App\Http\Controllers\Admin\Books\BookController@publisherDestroy')->middleware('role:Admin');
// Route::get('/admin/books/publishers/{category}/books','App\Http\Controllers\Admin\Books\BookController@publisherBooks')->middleware('role:Admin');

Route::get('/admin/books/publishers/{publisher}/categories', 'App\Http\Controllers\Admin\Books\BookController@publisherCategories')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/create', 'App\Http\Controllers\Admin\Books\BookController@categoryCreate')->middleware('role:Admin');
Route::post('/admin/books/publishers/{publisher}/categories', 'App\Http\Controllers\Admin\Books\BookController@categoryStore')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}/edit', 'App\Http\Controllers\Admin\Books\BookController@categoryEdit')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}', 'App\Http\Controllers\Admin\Books\BookController@categoryShow')->middleware('role:Admin');
Route::patch('/admin/books/publishers/{publisher}/categories/{category}', 'App\Http\Controllers\Admin\Books\BookController@categoryUpdate')->middleware('role:Admin');
Route::delete('/admin/books/publishers/{publisher}/categories/{category}', 'App\Http\Controllers\Admin\Books\BookController@categoryDestroy')->middleware('role:Admin');
Route::get('/admin/books/publishers/{publisher}/categories/{category}/books', 'App\Http\Controllers\Admin\Books\BookController@categoryBooks')->middleware('role:Admin');

Route::get('/admin/books/publishers/{publisher}/categories/{category}/books/create', 'App\Http\Controllers\Admin\Books\BookController@create')->middleware('role:Admin');
Route::post('/admin/books/publishers/{publisher}/categories/{category}/books', 'App\Http\Controllers\Admin\Books\BookController@store')->middleware('role:Admin');

Route::get('/admin/books', 'App\Http\Controllers\Admin\Books\BookController@index')->middleware('role:Admin');
// Route::get('/admin/books/create','App\Http\Controllers\Admin\Books\BookController@create')->middleware('role:Admin');
// Route::post('/admin/books','App\Http\Controllers\Admin\Books\BookController@store')->middleware('role:Admin');
Route::get('/admin/books/{book}/edit', 'App\Http\Controllers\Admin\Books\BookController@edit')->middleware('role:Admin');
Route::get('/admin/books/{book}', 'App\Http\Controllers\Admin\Books\BookController@show')->middleware('role:Admin');
Route::patch('/admin/books/{book}', 'App\Http\Controllers\Admin\Books\BookController@update')->middleware('role:Admin');
Route::delete('/admin/books/{book}', 'App\Http\Controllers\Admin\Books\BookController@destroy')->middleware('role:Admin');

Route::get('/admin/books/{book}/reviews', 'App\Http\Controllers\Admin\Books\BookController@reviewList')->middleware('role:Admin');
Route::delete('/admin/books/{book}/reviews/{review}', 'App\Http\Controllers\Admin\Books\BookController@reviewDestroy')->middleware('role:Admin');

// admin avertisement management 
Route::get('/admin/advertisement', 'App\Http\Controllers\Admin\Advertisement\ADController@index')->middleware('role:Admin');
Route::get('/admin/advertisement/create', 'App\Http\Controllers\Admin\Advertisement\ADController@create')->middleware('role:Admin');
Route::post('/admin/advertisement', 'App\Http\Controllers\Admin\Advertisement\ADController@store')->middleware('role:Admin');
Route::get('/admin/advertisement/{ad}/edit', 'App\Http\Controllers\Admin\Advertisement\ADController@edit')->middleware('role:Admin');
Route::patch('/admin/advertisement/{ad}', 'App\Http\Controllers\Admin\Advertisement\ADController@update')->middleware('role:Admin');
Route::delete('/admin/advertisement/{ad}', 'App\Http\Controllers\Admin\Advertisement\ADController@destroy')->middleware('role:Admin');

// admin material library Category management
Route::get('/admin/library', 'App\Http\Controllers\Admin\Library\CategoryController@index')->middleware('role:Admin');
// Route::get('/admin/library/create','App\Http\Controllers\Admin\Library\CategoryController@create')->middleware('role:Admin');
Route::post('/admin/library', 'App\Http\Controllers\Admin\Library\CategoryController@store')->middleware('role:Admin');
// Route::get('/admin/library/{category}/edit','App\Http\Controllers\Admin\Library\CategoryController@edit')->middleware('role:Admin');
Route::get('/admin/library/{category}/get-sub-materials', 'App\Http\Controllers\Admin\Library\CategoryController@getSubMaterialsJson')->middleware('role:Admin');
Route::get('/admin/library/{category}/directories', 'App\Http\Controllers\Admin\Library\CategoryController@getChilds')->middleware('role:Admin');
Route::patch('/admin/library', 'App\Http\Controllers\Admin\Library\CategoryController@update')->middleware('role:Admin');
Route::delete('/admin/library/{category}', 'App\Http\Controllers\Admin\Library\CategoryController@destroy')->middleware('role:Admin');

// admin material library items management
Route::get('/admin/library/{category}/materials', 'App\Http\Controllers\Admin\Library\MaterialController@index')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/create', 'App\Http\Controllers\Admin\Library\MaterialController@create')->middleware('role:Admin');
Route::post('/admin/library/{category}/materials', 'App\Http\Controllers\Admin\Library\MaterialController@store')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/import', 'App\Http\Controllers\Admin\Library\MaterialController@importForm')->middleware('role:Admin');
Route::patch('/admin/library/{category}/materials/import', 'App\Http\Controllers\Admin\Library\MaterialController@importFile')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/{material}/edit', 'App\Http\Controllers\Admin\Library\MaterialController@edit')->middleware('role:Admin');
Route::get('/admin/library/{category}/materials/{material}', 'App\Http\Controllers\Admin\Library\MaterialController@show')->middleware('role:Admin');
Route::patch('/admin/library/{category}/materials/{material}', 'App\Http\Controllers\Admin\Library\MaterialController@update')->middleware('role:Admin');
Route::delete('/admin/library/{category}/materials/{material}', 'App\Http\Controllers\Admin\Library\MaterialController@destroy')->middleware('role:Admin');

// admin imp links management
Route::get('/admin/imp-links', 'App\Http\Controllers\Admin\LinksController@categoryIndex')->middleware('role:Admin');
Route::get('/admin/imp-links/create', 'App\Http\Controllers\Admin\LinksController@categoryCreate')->middleware('role:Admin');
Route::post('/admin/imp-links', 'App\Http\Controllers\Admin\LinksController@categoryStore')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/edit', 'App\Http\Controllers\Admin\LinksController@categoryEdit')->middleware('role:Admin');
Route::patch('/admin/imp-links/{category}', 'App\Http\Controllers\Admin\LinksController@categoryUpdate')->middleware('role:Admin');
Route::delete('/admin/imp-links/{category}', 'App\Http\Controllers\Admin\LinksController@categoryDestroy')->middleware('role:Admin');

Route::get('/admin/imp-links/{category}/links', 'App\Http\Controllers\Admin\LinksController@index')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/links/create', 'App\Http\Controllers\Admin\LinksController@create')->middleware('role:Admin');
Route::post('/admin/imp-links/{category}/links', 'App\Http\Controllers\Admin\LinksController@store')->middleware('role:Admin');
Route::get('/admin/imp-links/{category}/links/{link}/edit', 'App\Http\Controllers\Admin\LinksController@edit')->middleware('role:Admin');
Route::patch('/admin/imp-links/{category}/links/{link}', 'App\Http\Controllers\Admin\LinksController@update')->middleware('role:Admin');
Route::delete('/admin/imp-links/{category}/links/{link}', 'App\Http\Controllers\Admin\LinksController@destroy')->middleware('role:Admin');

//admin dynamic form group mgmt
Route::get('/admin/dynamic-forms/groups', 'App\Http\Controllers\Admin\Forms\FormGroupController@index')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/groups', 'App\Http\Controllers\Admin\Forms\FormGroupController@store')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/groups', 'App\Http\Controllers\Admin\Forms\FormGroupController@update')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/groups/{group}', 'App\Http\Controllers\Admin\Forms\FormGroupController@destroy')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/groups/{group}/forms', 'App\Http\Controllers\Admin\Forms\FormGroupController@forms')->middleware('role:Admin');

//admin dynamic forms mgmt
Route::get('/admin/dynamic-forms', 'App\Http\Controllers\Admin\Forms\FormController@formLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/create', 'App\Http\Controllers\Admin\Forms\FormController@createForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms', 'App\Http\Controllers\Admin\Forms\FormController@saveForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}', 'App\Http\Controllers\Admin\Forms\FormController@showForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/edit', 'App\Http\Controllers\Admin\Forms\FormController@editForm')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/reset', 'App\Http\Controllers\Admin\Forms\FormController@resetForm')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/{vform}', 'App\Http\Controllers\Admin\Forms\FormController@updateForm')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/{vform}', 'App\Http\Controllers\Admin\Forms\FormController@destroyForm')->middleware('role:Admin');

//admin dynamic form applicants mgmt
Route::get('/admin/dynamic-forms/{vform}/applicants', 'App\Http\Controllers\Admin\Forms\FormController@applicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/upload', 'App\Http\Controllers\Admin\Forms\FormController@uploadApplicantListForm')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/export', 'App\Http\Controllers\Admin\Forms\FormController@exportApplicantLists')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/applicants/import', 'App\Http\Controllers\Admin\Forms\FormController@importApplicantLists')->middleware('role:Admin');
Route::post('/admin/dynamic-forms/{vform}/applicants/filter', 'App\Http\Controllers\Admin\Forms\FormController@filteredApplicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/export/{query}', 'App\Http\Controllers\Admin\Forms\FormController@exportFilteredApplicantLists')->middleware('role:Admin');
Route::get('/admin/dynamic-forms/{vform}/applicants/{applicant}', 'App\Http\Controllers\Admin\Forms\FormController@showApplicant')->middleware('role:Admin');
Route::patch('/admin/dynamic-forms/{vform}/applicants/{applicant}', 'App\Http\Controllers\Admin\Forms\FormController@updateApplicant')->middleware('role:Admin');
Route::delete('/admin/dynamic-forms/{vform}/applicants/{applicant}', 'App\Http\Controllers\Admin\Forms\FormController@destroyApplicant')->middleware('role:Admin');

// // admin free videos
Route::get('/admin/free-videos', 'App\Http\Controllers\Admin\FreeVideoController@index')->middleware('role:Admin');
Route::get('/admin/free-videos/create', 'App\Http\Controllers\Admin\FreeVideoController@create')->middleware('role:Admin');
Route::post('/admin/free-videos', 'App\Http\Controllers\Admin\FreeVideoController@store')->middleware('role:Admin');
Route::delete('/admin/free-videos/{video}', 'App\Http\Controllers\Admin\FreeVideoController@destroy')->middleware('role:Admin');

Route::get('/admin/qr-books', 'App\Http\Controllers\Admin\Books\QRBookController@index')->middleware('role:Admin');
Route::get('/admin/qr-books/create', 'App\Http\Controllers\Admin\Books\QRBookController@create')->middleware('role:Admin');
Route::post('/admin/qr-books', 'App\Http\Controllers\Admin\Books\QRBookController@store')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/edit', 'App\Http\Controllers\Admin\Books\QRBookController@edit')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/show', 'App\Http\Controllers\Admin\Books\QRBookController@show')->middleware('role:Admin');
Route::patch('/admin/qr-books/{book}', 'App\Http\Controllers\Admin\Books\QRBookController@update')->middleware('role:Admin');
Route::delete('/admin/qr-books/{book}', 'App\Http\Controllers\Admin\Books\QRBookController@destroy')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/scans', 'App\Http\Controllers\Admin\Books\QRBookController@scanMembers')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/scans/export', 'App\Http\Controllers\Admin\Books\QRBookController@scanMembersExport')->middleware('role:Admin');

Route::get('/admin/qr-books/{book}/winners', 'App\Http\Controllers\Admin\Books\QRBookController@winnerMembers')->middleware('role:Admin');
Route::get('/admin/qr-books/{book}/winners/create', 'App\Http\Controllers\Admin\Books\QRBookController@winnerCreate')->middleware('role:Admin');
Route::post('/admin/qr-books/{book}/winners', 'App\Http\Controllers\Admin\Books\QRBookController@winnerStore')->middleware('role:Admin');

// admin dsaily mcq questions
Route::get('/admin/daily-mcq-questions', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@index')->middleware('role:Admin');
Route::get('/admin/daily-mcq-questions/create', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@create')->middleware('role:Admin');
Route::get('/admin/daily-mcq-questions/upload', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@upload')->middleware('role:Admin');
Route::post('/admin/daily-mcq-questions/import', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@import')->middleware('role:Admin');
Route::get('/admin/daily-mcq-questions/download', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@download')->middleware('role:Admin');
Route::post('/admin/daily-mcq-questions', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@store')->middleware('role:Admin');
Route::get('/admin/daily-mcq-questions/{question}/edit', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@edit')->middleware('role:Admin');

Route::get('/admin/daily-mcq-questions/{question}/comments', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@comments')->middleware('role:Admin');
Route::get('/admin/daily-mcq-questions/{question}', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@show')->middleware('role:Admin');
Route::patch('/admin/daily-mcq-questions/{question}', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@update')->middleware('role:Admin');
Route::delete('/admin/daily-mcq-questions/{question}', 'App\Http\Controllers\Admin\Exams\DailyQuestionController@destroy')->middleware('role:Admin');

//admin image gallery mgmt
Route::get('/admin/image-gallery', 'App\Http\Controllers\Admin\ImageGalleryController@index')->middleware('role:Admin');
Route::post('/admin/image-gallery', 'App\Http\Controllers\Admin\ImageGalleryController@store')->middleware('role:Admin');
Route::patch('/admin/image-gallery', 'App\Http\Controllers\Admin\ImageGalleryController@update')->middleware('role:Admin');
Route::delete('/admin/image-gallery/{img}', 'App\Http\Controllers\Admin\ImageGalleryController@destroy')->middleware('role:Admin');

Route::get('/admin/physical-book-orders', 'App\Http\Controllers\Admin\Books\PhysicalBookOrderController@index')->middleware('role:Admin');
Route::delete('/admin/physical-book-orders/{order}', 'App\Http\Controllers\Admin\Books\PhysicalBookOrderController@destroy')->middleware('role:Admin');
Route::get('/admin/physical-book-orders/{order}/show', 'App\Http\Controllers\Admin\Books\PhysicalBookOrderController@show')->middleware('role:Admin');

//admin wallet collection mgmt
Route::get('/admin/wallet-collection', 'App\Http\Controllers\Admin\WalletCollectionController@index')->middleware('role:Admin');
Route::get('/admin/wallet-collection/booking-type/exam', 'App\Http\Controllers\Admin\WalletCollectionController@bookingTypeExamCollection')->middleware('role:Admin');
Route::get('/admin/wallet-collection/booking-type/exam/filter', 'App\Http\Controllers\Admin\WalletCollectionController@bookingTypeExamCollectionFilter')->middleware('role:Admin');
Route::get('/admin/wallet-collection/booking-type/pdf-bank', 'App\Http\Controllers\Admin\WalletCollectionController@bookingTypePdfBankCollection')->middleware('role:Admin');
Route::get('/admin/wallet-collection/booking-type/pdf-bank/filter', 'App\Http\Controllers\Admin\WalletCollectionController@bookingTypePdfBankCollectionFilter')->middleware('role:Admin');

// admin booking coupons management
Route::get('/admin/booking-coupons', 'App\Http\Controllers\Admin\BookingCouponController@index')->middleware('role:Admin');
Route::post('/admin/booking-coupons', 'App\Http\Controllers\Admin\BookingCouponController@store')->middleware('role:Admin');
Route::get('/admin/booking-coupons/used', 'App\Http\Controllers\Admin\BookingCouponController@usedCoupons')->middleware('role:Admin');
Route::delete('/admin/booking-coupons/{coupon}', 'App\Http\Controllers\Admin\BookingCouponController@destroy')->middleware('role:Admin');

// admin user ticket management
Route::get('/admin/user-tickets/open', 'App\Http\Controllers\Admin\UserTicketController@openTicketList')->middleware('role:Admin');
Route::get('/admin/user-tickets/closed', 'App\Http\Controllers\Admin\UserTicketController@closedTicketList')->middleware('role:Admin');
Route::get('/admin/user-tickets/{ticket}/mark-closed', 'App\Http\Controllers\Admin\UserTicketController@closeTicket')->middleware('role:Admin');
Route::delete('/admin/user-tickets/{ticket}', 'App\Http\Controllers\Admin\UserTicketController@destroyTicket')->middleware('role:Admin');
Route::get('/admin/user-tickets/{ticket}/contents', 'App\Http\Controllers\Admin\UserTicketController@ticketMessageList')->middleware('role:Admin');
Route::post('/admin/user-tickets/{ticket}/contents', 'App\Http\Controllers\Admin\UserTicketController@ticketMessageStore')->middleware('role:Admin');
Route::delete('/admin/user-tickets/{ticket}/contents', 'App\Http\Controllers\Admin\UserTicketController@ticketMessageDestroy')->middleware('role:Admin');

//admin highlight mgmt
Route::get('/admin/highlights', 'App\Http\Controllers\Admin\HighlightController@index')->middleware('role:Admin');
Route::post('/admin/highlights', 'App\Http\Controllers\Admin\HighlightController@store')->middleware('role:Admin');
Route::patch('/admin/highlights', 'App\Http\Controllers\Admin\HighlightController@update')->middleware('role:Admin');
Route::delete('/admin/highlights/{highlight}', 'App\Http\Controllers\Admin\HighlightController@destroy')->middleware('role:Admin');



















/*------------------------------------all moderator panel section routes---------------------------*/

//final routes for moderator panel section
Route::get('/moderator/home', 'App\Http\Controllers\Moderator\HomeController@index')->middleware('role:Moderator');

//blogs managing by moderator
Route::get('/moderator/blogs', 'App\Http\Controllers\Moderator\BlogController@index')->middleware('role:Moderator');
Route::get('/moderator/blogs/create', 'App\Http\Controllers\Moderator\BlogController@create')->middleware('role:Moderator');
Route::post('/moderator/blogs', 'App\Http\Controllers\Moderator\BlogController@store')->middleware('role:Moderator');
Route::get('/moderator/blogs/{blog}', 'App\Http\Controllers\Moderator\BlogController@show')->middleware('role:Moderator');
Route::get('/moderator/blogs/{blog}/edit', 'App\Http\Controllers\Moderator\BlogController@edit')->middleware('role:Moderator');
Route::patch('/moderator/blogs/{blog}', 'App\Http\Controllers\Moderator\BlogController@update')->middleware('role:Moderator');
Route::delete('/moderator/blogs/{blog}', 'App\Http\Controllers\Moderator\BlogController@destroy')->middleware('role:Moderator');
Route::get('/moderator/blogs/{blog}/comments', 'App\Http\Controllers\Moderator\BlogController@indexComment')->middleware('role:Moderator');
Route::patch('/moderator/blogs/{blog}/comment/{comment}/{status}', 'App\Http\Controllers\Moderator\BlogController@updateComment')->middleware('role:Moderator');
Route::put('/moderator/blogs/{blog}/comment/{comment}/{status}', 'App\Http\Controllers\Moderator\BlogController@updateComment')->middleware('role:Moderator');
Route::delete('/moderator/blogs/{blog}/comment/{comment}/delete', 'App\Http\Controllers\Moderator\BlogController@destroyComment')->middleware('role:Moderator');

//moderator mcq exam category
Route::get('/moderator/exam-category', 'App\Http\Controllers\Moderator\ExamController@categoryIndex')->middleware('role:Moderator');
Route::get('/moderator/exam-category/create', 'App\Http\Controllers\Moderator\ExamController@categoryCreate')->middleware('role:Moderator');
Route::post('/moderator/exam-category', 'App\Http\Controllers\Moderator\ExamController@categoryStore')->middleware('role:Moderator');
Route::delete('/moderator/exam-category/{category}', 'App\Http\Controllers\Moderator\ExamController@categoryDestroy')->middleware('role:Moderator');
Route::get('/moderator/exam-category/{category}/exams', 'App\Http\Controllers\Moderator\ExamController@categoryExams')->middleware('role:Moderator');
Route::get('/moderator/exam-category/{category}/getexams', 'App\Http\Controllers\Moderator\ExamController@categoryGetExams')->middleware('role:Moderator');

//moderator mcq exam mgmt
Route::get('/moderator/exams', 'App\Http\Controllers\Moderator\ExamController@examIndex')->middleware('role:Moderator');
Route::get('/moderator/exams/create', 'App\Http\Controllers\Moderator\ExamController@examCreate')->middleware('role:Moderator');
Route::post('/moderator/exams', 'App\Http\Controllers\Moderator\ExamController@examStore')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@examShow')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/edit', 'App\Http\Controllers\Moderator\ExamController@examEdit')->middleware('role:Moderator');
Route::patch('/moderator/exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@examUpdate')->middleware('role:Moderator');
Route::delete('/moderator/exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@examDestroy')->middleware('role:Moderator');

// moderator mcq exam questions
Route::get('/moderator/exams/{exam}/questions', 'App\Http\Controllers\Moderator\ExamController@questionIndex')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/create', 'App\Http\Controllers\Moderator\ExamController@questionCreate')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/upload', 'App\Http\Controllers\Moderator\ExamController@questionUpload')->middleware('role:Moderator');
Route::post('/moderator/exams/{exam}/questions/import', 'App\Http\Controllers\Moderator\ExamController@questionImport')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/download-excel', 'App\Http\Controllers\Moderator\ExamController@questionDownloadExcel')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/download-pdf', 'App\Http\Controllers\Moderator\ExamController@questionDownloadPdf')->middleware('role:Moderator');
Route::post('/moderator/exams/{exam}/questions', 'App\Http\Controllers\Moderator\ExamController@questionStore')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/{question}/edit', 'App\Http\Controllers\Moderator\ExamController@questionEdit')->middleware('role:Moderator');
Route::get('/moderator/exams/{exam}/questions/{question}', 'App\Http\Controllers\Moderator\ExamController@questionShow')->middleware('role:Moderator');
Route::patch('/moderator/exams/{exam}/questions/{question}', 'App\Http\Controllers\Moderator\ExamController@questionUpdate')->middleware('role:Moderator');
Route::delete('/moderator/exams/{exam}/questions/{question}', 'App\Http\Controllers\Moderator\ExamController@questionDestroy')->middleware('role:Moderator');

//open mcq exams moderator
Route::get('/moderator/open-exams', 'App\Http\Controllers\Moderator\ExamController@openExamIndex')->middleware('role:Moderator');
Route::get('/moderator/open-exams/create', 'App\Http\Controllers\Moderator\ExamController@openExamCreate')->middleware('role:Moderator');
Route::post('/moderator/open-exams', 'App\Http\Controllers\Moderator\ExamController@openExamStore')->middleware('role:Moderator');
Route::get('/moderator/open-exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@openExamShow')->middleware('role:Moderator');
Route::get('/moderator/open-exams/{exam}/edit', 'App\Http\Controllers\Moderator\ExamController@openExamEdit')->middleware('role:Moderator');
Route::patch('/moderator/open-exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@openExamUpdate')->middleware('role:Moderator');
Route::delete('/moderator/open-exams/{exam}', 'App\Http\Controllers\Moderator\ExamController@openExamDestroy')->middleware('role:Moderator');

//open mcq exams results moderator
Route::get('/moderator/open-exams/{exam}/results', 'App\Http\Controllers\Moderator\ExamController@openExamResults')->middleware('role:Moderator');
Route::get('/moderator/open-exams/{exam}/results/export', 'App\Http\Controllers\Moderator\ExamController@openExamExport')->middleware('role:Moderator');

//routes for exam hall moderator section
Route::get('/moderator/exam-hall', 'App\Http\Controllers\Moderator\ExamHallController@index')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/create', 'App\Http\Controllers\Moderator\ExamHallController@create')->middleware('role:Moderator');
Route::post('/moderator/exam-hall', 'App\Http\Controllers\Moderator\ExamHallController@store')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/{category}/edit', 'App\Http\Controllers\Moderator\ExamHallController@edit')->middleware('role:Moderator');
Route::patch('/moderator/exam-hall/{category}', 'App\Http\Controllers\Moderator\ExamHallController@update')->middleware('role:Moderator');
Route::delete('/moderator/exam-hall/{category}', 'App\Http\Controllers\Moderator\ExamHallController@destroy')->middleware('role:Moderator');

Route::get('/moderator/exam-hall/{category}/exams', 'App\Http\Controllers\Moderator\ExamHallController@examindex')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/{category}/exams/create', 'App\Http\Controllers\Moderator\ExamHallController@examcreate')->middleware('role:Moderator');
Route::post('/moderator/exam-hall/{category}/exams', 'App\Http\Controllers\Moderator\ExamHallController@examstore')->middleware('role:Moderator');
Route::delete('/moderator/exam-hall/{category}/exams/{exam}', 'App\Http\Controllers\Moderator\ExamHallController@examdestroy')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/{category}/exams/{exam}/results', 'App\Http\Controllers\Moderator\ExamHallController@examresults')->middleware('role:Moderator');

//exam hall cqc moderator section
Route::get('/moderator/exam-hall/{category}/cqc', 'App\Http\Controllers\Moderator\ExamHallController@cqcindex')->middleware('role:Moderator');
Route::post('/moderator/exam-hall/{category}/cqc', 'App\Http\Controllers\Moderator\ExamHallController@cqcstore')->middleware('role:Moderator');
Route::delete('/moderator/exam-hall/{category}/cqc/{cqc}', 'App\Http\Controllers\Moderator\ExamHallController@cqcdestroy')->middleware('role:Moderator');

//moderator section exam hall booking
Route::get('/moderator/exam-hall/bookings', 'App\Http\Controllers\Moderator\ExamHallController@bookingindex')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/bookings/all', 'App\Http\Controllers\Moderator\ExamHallController@allBookings')->middleware('role:Moderator');
// Route::get('/moderator/exam-hall/bookings/create','App\Http\Controllers\Moderator\ExamHallController@bookingcreate')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/{category}/bookings', 'App\Http\Controllers\Moderator\ExamHallController@setBookings')->middleware('role:Moderator');
// Route::post('/moderator/exam-hall/bookings','App\Http\Controllers\Moderator\ExamHallController@bookingstore')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/bookings/{booking}/edit', 'App\Http\Controllers\Moderator\ExamHallController@bookingedit')->middleware('role:Moderator');
Route::get('/moderator/exam-hall/bookings/{booking}', 'App\Http\Controllers\Moderator\ExamHallController@bookingshow')->middleware('role:Moderator');
Route::patch('/moderator/exam-hall/bookings/{booking}', 'App\Http\Controllers\Moderator\ExamHallController@bookingupdate')->middleware('role:Moderator');
// Route::delete('/moderator/exam-hall/bookings/{booking}','App\Http\Controllers\Moderator\ExamHallController@bookingdestroy')->middleware('role:Moderator');























/*------------------------------------all student section routes---------------------------*/

//final routes for students panel section
Route::get('/student/home', 'App\Http\Controllers\Student\StudentHomeController@index')->middleware('role:Student');


//student section exam set booking section
Route::get('/student/exam-bookings', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@index')->middleware('role:Student');
Route::get('/student/exam-bookings/create', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@enroll')->middleware('role:Student');
Route::post('/student/exam-bookings', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@store')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/edit', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@edit')->middleware('role:Student');
Route::delete('/student/exam-bookings/{booking}', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@destroy')->middleware('role:Student');

Route::patch('/student/exam-bookings/{booking}/manual-pay', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@manualVerify')->middleware('role:Student');
Route::patch('/student/exam-bookings/{booking}/coupon-pay', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@couponVerify')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/esewaSuccess', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@esewaSuccess')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/fonepaySuccess', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@fonepaySuccess')->middleware('role:Student');
// Route::post('/student/exam-bookings/{booking}/khaltiSuccess','App\Http\Controllers\Student\ExamHall\ExamBookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/exam-bookings/{booking}/payment-failed', 'App\Http\Controllers\Student\ExamHall\ExamBookingController@paymentFailed')->middleware('role:Student');

Route::get('/student/exam-bookings/{category}/exams', 'App\Http\Controllers\Student\ExamHall\ExamController@index')->middleware('role:Student');
Route::get('/student/exam-bookings/{category}/exams/{exam}/attempt', 'App\Http\Controllers\Student\ExamHall\ExamController@takeExam')->middleware('role:Student');
Route::post('/student/exam-bookings/{category}/exams/{exam}/save', 'App\Http\Controllers\Student\ExamHall\ExamController@store')->middleware('role:Student');
Route::get('/student/exam-bookings/{category}/exams/{exam}/view', 'App\Http\Controllers\Student\ExamHall\ExamController@show')->middleware('role:Student');
Route::get('/student/exam-bookings/{category}/exams/{exam}/download', 'App\Http\Controllers\Student\ExamHall\ExamController@downloadQuestionPdf')->middleware('role:Student');
Route::delete('/student/exam-bookings/{category}/exams/{exam}/reset', 'App\Http\Controllers\Student\ExamHall\ExamController@resetExam')->middleware('role:Student');

//exam hall cqc student section
Route::get('/student/exam-bookings/{category}/cqc', 'App\Http\Controllers\Student\ExamHall\CQCController@index');
Route::post('/student/exam-bookings/{category}/cqc', 'App\Http\Controllers\Student\ExamHall\CQCController@store');

//student pdf bank bookings
Route::get('/student/pdf-bank-bookings', 'App\Http\Controllers\Student\PdfBank\BookingController@index')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/create', 'App\Http\Controllers\Student\PdfBank\BookingController@create')->middleware('role:Student');
Route::post('/student/pdf-bank-bookings', 'App\Http\Controllers\Student\PdfBank\BookingController@store')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/{booking}/edit', 'App\Http\Controllers\Student\PdfBank\BookingController@edit')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/{booking}/esewaSuccess', 'App\Http\Controllers\Student\PdfBank\BookingController@esewaSuccess')->middleware('role:Student');
// Route::post('/student/pdf-bank-bookings/{booking}/khaltiSuccess','App\Http\Controllers\Student\PdfBank\BookingController@khaltiSuccess')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/{booking}/fonepaySuccess', 'App\Http\Controllers\Student\PdfBank\BookingController@fonepaySuccess')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/{booking}/payment-failed', 'App\Http\Controllers\Student\PdfBank\BookingController@paymentFailed')->middleware('role:Student');
Route::patch('/student/pdf-bank-bookings/{booking}/manual-pay', 'App\Http\Controllers\Student\PdfBank\BookingController@manualPay')->middleware('role:Student');
Route::patch('/student/pdf-bank-bookings/{booking}/coupon-pay', 'App\Http\Controllers\Student\PdfBank\BookingController@couponPay')->middleware('role:Student');
Route::delete('/student/pdf-bank-bookings/{booking}', 'App\Http\Controllers\Student\PdfBank\BookingController@destroy')->middleware('role:Student');

//student pdf bank contents
Route::get('/student/pdf-bank-bookings/{booking}/pdf-contents', 'App\Http\Controllers\Student\PdfBank\PdfContentController@index')->middleware('role:Student');
Route::get('/student/pdf-bank-bookings/{booking}/pdf-contents/{content}', 'App\Http\Controllers\Student\PdfBank\PdfContentController@show')->middleware('role:Student');


Route::get('/student/tickets', 'App\Http\Controllers\Student\TicketController@index')->middleware('role:Student');
Route::get('/student/tickets/create', 'App\Http\Controllers\Student\TicketController@create')->middleware('role:Student');
Route::post('/student/tickets', 'App\Http\Controllers\Student\TicketController@store')->middleware('role:Student');
Route::get('/student/tickets/{ticket}/mark-closed', 'App\Http\Controllers\Student\TicketController@closeTicket')->middleware('role:Student');
Route::delete('/student/tickets/{ticket}', 'App\Http\Controllers\Student\TicketController@destroyTicket')->middleware('role:Student');
Route::get('/student/tickets/{ticket}/contents', 'App\Http\Controllers\Student\TicketController@ticketMessageList')->middleware('role:Student');
Route::post('/student/tickets/{ticket}/contents', 'App\Http\Controllers\Student\TicketController@ticketMessageStore')->middleware('role:Student');
Route::delete('/student/tickets/{ticket}/contents', 'App\Http\Controllers\Student\TicketController@ticketMessageDestroy')->middleware('role:Student');

//student vaccancy management
Route::get('/student/vaccancies', 'App\Http\Controllers\Student\VaccancyController@index')->middleware('role:Student');
Route::get('/student/vaccancies-tag/{tag}', 'App\Http\Controllers\Student\VaccancyController@tagVaccancies')->middleware('role:Student');
Route::get('/student/vaccancies/create', 'App\Http\Controllers\Student\VaccancyController@create')->middleware('role:Student');
Route::post('/student/vaccancies', 'App\Http\Controllers\Student\VaccancyController@store')->middleware('role:Student');
Route::get('/student/vaccancies/{vaccancy}', 'App\Http\Controllers\Student\VaccancyController@show')->middleware('role:Student');

Route::get('/student/free-exams', 'App\Http\Controllers\Student\StudentHomeController@freeExamList')->middleware('role:Student');


















/********************************************************************************************************************************************************************************************** */
/*--------------------------Front Routes -----------------------------------------------------*/

Route::get('/', 'App\Http\Controllers\FrontController@index');
Route::get('/about-us', 'App\Http\Controllers\FrontController@about');
Route::get('/enquiry', 'App\Http\Controllers\FrontController@enquiry');
Route::get('/enquiry/{courseslug}', 'App\Http\Controllers\FrontController@showCourseEnquiryForm');
Route::get('/free-videos', 'App\Http\Controllers\FrontController@allFreeVideos');
Route::get('/free-videos/{video}', 'App\Http\Controllers\FrontController@playFreeVideo');
Route::get('/page-counter-increment', 'App\Http\Controllers\FrontController@pageCounterIncrement');
Route::get('/bmi-calculator', 'App\Http\Controllers\FrontController@bmiCalculator');
Route::get('/health-ingos', 'App\Http\Controllers\FrontController@healthIngo');
Route::get('/palika-bibaran', 'App\Http\Controllers\FrontController@palikaBibaran');
Route::get('/web-policy', 'App\Http\Controllers\FrontController@webPolicy');

//discussion forum
Route::get('/discussion-forum', 'App\Http\Controllers\FrontController@discussionForum')->middleware('auth');
Route::post('/discussion-forum', 'App\Http\Controllers\FrontController@discussionForumStore')->middleware('auth');
Route::delete('/discussion-forum', 'App\Http\Controllers\FrontController@discussionForumDestroy')->middleware('auth');

Route::get('/image-gallery', 'App\Http\Controllers\FrontController@imageGallery');


// front blogs
Route::get('/blogs', 'App\Http\Controllers\Blog\BlogController@index');
Route::get('/blogs/{bid}', 'App\Http\Controllers\Blog\BlogController@show');
Route::post('/blogs/{blog}/comments/add', 'App\Http\Controllers\Blog\BlogController@addComments');

//front public exams mgmt
Route::get('/public-exams', 'App\Http\Controllers\PublicExamController@examlist');
Route::get('/public-exams/{eid}', 'App\Http\Controllers\PublicExamController@examform');
Route::post('/public-exams/{eid}/attempt', 'App\Http\Controllers\PublicExamController@examshow');
Route::post('/public-exams/{eid}/save', 'App\Http\Controllers\PublicExamController@examsave');
Route::get('/public-exams/{eid}/download-questions', 'App\Http\Controllers\PublicExamController@examQuestionsPdfDownload')->middleware('auth');

//front public exams results
Route::get('/results', 'App\Http\Controllers\PublicExamController@resultlist');
Route::get('/results/{eid}', 'App\Http\Controllers\PublicExamController@resultshow');

//front premium exams section
Route::get('/exam-hall/premium/{eid}', 'App\Http\Controllers\PublicExamController@premiumExamShow');
Route::get('/exam-hall/category/{cat}', 'App\Http\Controllers\PublicExamController@categoryPremiumExamList');

//front ebooks
Route::get('/books', 'App\Http\Controllers\FrontController@books');
Route::post('/books/{bid}/physical-order/add', 'App\Http\Controllers\FrontController@addPhysicalBookOrder');
Route::post('/books/{bid}/review/add', 'App\Http\Controllers\FrontController@addBookReview');
Route::get('/books/{bid}', 'App\Http\Controllers\FrontController@singleBook');
Route::get('/book-publishers/{pub}/all-books', 'App\Http\Controllers\FrontController@publisherAllBooks');
Route::get('/book-publishers/{pub}/category/{cat}', 'App\Http\Controllers\FrontController@publisherCategoryBooks');
Route::get('/book-publishers/{pub}', 'App\Http\Controllers\FrontController@publisherBookCategories');

Route::get('/qr-book-scans/{book}/{bsn}', 'App\Http\Controllers\FrontController@qrBookScanForm');
Route::post('/qr-book-scans/{book}/{member}', 'App\Http\Controllers\FrontController@qrBookScanMemberStore');

//front library materials
Route::get('/library', 'App\Http\Controllers\FrontController@getLibrary');
Route::get('/library/{cat}', 'App\Http\Controllers\FrontController@getLibraryContents');
Route::get('/library/{cat}/{mat}', 'App\Http\Controllers\FrontController@getLibraryContentDetail');

//front search mgmt
Route::get('/search', 'App\Http\Controllers\FrontController@search');

//front testimonials
Route::get('/testimonials', 'App\Http\Controllers\FrontController@getTestimonials');
Route::post('/testimonials/add', 'App\Http\Controllers\FrontController@addTestimonials');

//front dynamic forms
Route::get('/dynamic-forms/{form}', 'App\Http\Controllers\FrontDynamicFormController@showDynamicForm');
Route::post('/dynamic-forms/{form}', 'App\Http\Controllers\FrontDynamicFormController@saveDynamicFormApplicant');

Route::get('/question-of-the-day/{qdate}', 'App\Http\Controllers\FrontController@getQuestionOfDay');
Route::post('/question-of-the-day/{qdate}/comment/add', 'App\Http\Controllers\FrontController@addCommentToQuestionOfDay');
Route::get('/question-of-the-day-quiz', 'App\Http\Controllers\PublicExamController@playDailyQuestionQuiz');

//front pdf banks
Route::get('/pdf-banks', 'App\Http\Controllers\FrontPdfBankController@index');
Route::get('/pdf-banks/category/{cat}', 'App\Http\Controllers\FrontPdfBankController@categoryPdfBanks');
Route::get('/pdf-banks/bank/{bank}', 'App\Http\Controllers\FrontPdfBankController@singlePdfBankDetails');

//nepal pay proxy apis
Route::post('/nepal-pay/get-payment-instrument-details', 'App\Http\Controllers\NepalPayProxyController@getPaymentInstrumentDetails');
Route::post('/nepal-pay/get-service-charge', 'App\Http\Controllers\NepalPayProxyController@getServiceCharge');
Route::post('/nepal-pay/get-process-id', 'App\Http\Controllers\NepalPayProxyController@getProcessId');
Route::get('/nepal-pay/return-payment-response', 'App\Http\Controllers\NepalPayProxyController@returnPaymentResponse');
Route::get('/nepal-pay/return-payment-notification', 'App\Http\Controllers\NepalPayProxyController@returnPaymentNotification');

//front vaccancy management
Route::get('/vaccancies', 'App\Http\Controllers\FrontCareerController@index');
Route::get('/vaccancies-tag/{tag}', 'App\Http\Controllers\FrontCareerController@tagVaccancies');
Route::get('/vaccancies/create', 'App\Http\Controllers\FrontCareerController@create')->middleware('auth');
Route::post('/vaccancies', 'App\Http\Controllers\FrontCareerController@store')->middleware('auth');
Route::get('/vaccancies/{vaccancy}', 'App\Http\Controllers\FrontCareerController@show');

Route::get('/child-nutrition-calculator', 'App\Http\Controllers\FrontMiscController@childNutritionCalculator');


//front menu details
Route::get('/{group}/{menu}', 'App\Http\Controllers\FrontController@getMenuCategories');
Route::get('/{group}/{menu}/{cat}', 'App\Http\Controllers\FrontController@getMenuItems');
Route::get('/{group}/{menu}/{cat}/{item}', 'App\Http\Controllers\FrontController@getMenuItemDetail');
Route::get('/{group}/{menu}/{cat}/{item}/{subitem}', 'App\Http\Controllers\FrontController@getMenuSubItemDetail');



/******************************************************************************************************************************* */
