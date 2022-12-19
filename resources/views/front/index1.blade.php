@extends('front.layouts.app')
@section('content')
    <section class="home-slider">
        <div class="main-slider owl-carousel">
            <div class="single-item">
                <img src="images/slider1.jpg" alt="" width="100%">
            </div>
            <div class="single-item">
                <img src="images/slider2.jpg" alt="" width="100%">
            </div>
        </div>
    </section>
    <section class="video-course mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="mb-3 wow fadeInUp">Videos Courses</h2>
                </div>
            </div>
            <div class="course-container">
                <div class="owl-carousel course-carousel">
                    <div class="post-thumb">
                        <a href=""><img src="images/course1.jpg" alt="" ></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mock-test mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="mb-3 wow fadeInUp">Mock Tests</h2>
                </div>
            </div>
            <div class="mocktest-container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="mock-premium"><u>Premium</u></h3>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h3 class="mb-3 mock-heading">1. Loksewa Examination</h3>
                        <a href="" class="mock-btn mock-btn1">Free Demo</a>
                        <a href="" class="mock-btn mock-btn2">Book Now</a>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h3 class="mb-3 mock-heading">1. Loksewa Examination</h3>
                        <a href="" class="mock-btn mock-btn1">Free Demo</a>
                        <a href="" class="mock-btn mock-btn2">Book Now</a>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h3 class="mb-3 mock-heading">1. Loksewa Examination</h3>
                        <a href="" class="mock-btn mock-btn1">Free Demo</a>
                        <a href="" class="mock-btn mock-btn2">Book Now</a>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h3 class="mb-3 mock-heading">1. Loksewa Examination</h3>
                        <a href="" class="mock-btn mock-btn1">Free Demo</a>
                        <a href="" class="mock-btn mock-btn2">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-blog mt-3 mb-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="mb-3 wow fadeInUp">Blogs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-section">
                        <div class="blog-header">
                            <img src="images/course3.jpg" alt="">
                        </div>
                        <div class="blog-footer">
                            <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
                            <div class="blog-details"><a href="">View Details</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blog-section">
                        <div class="blog-header">
                            <img src="images/course3.jpg" alt="">
                        </div>
                        <div class="blog-footer">
                            <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
                            <div class="blog-details"><a href="">View Details</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-ebook mt-3 mb-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="mb-3 wow fadeInUp">E-Books</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="ebook-section">
                        <div class="ebook-header">
                            <img src="images/course3.jpg" alt="">
                        </div>
                        <div class="ebook-footer">
                            <a href=""><h4>Loksewa Aayog Tayari</h4></a>
                            <p><strong>Author :</strong>  Shishir Adhikari</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ebook-section">
                        <div class="ebook-header">
                            <img src="images/course3.jpg" alt="">
                        </div>
                        <div class="ebook-footer">
                            <a href=""><h4>Loksewa Aayog Tayari</h4></a>
                            <p><strong>Author :</strong>  Shishir Adhikari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="loksewa-today mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 loksewa-selector mb-2">
                    <h2>आ. ब </h2>   
                        <select name="" id="">
                            <option value="">079-80</option>
                        </select>   
                    <h2> का.</h2>
                </div>
                <div class="col-md-8"><h2 class="loksewa-title">लोकसेवा आयोगमा आज </h2></div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center mb-5">
                    <h3 class="loksewa-content"><span class="span-left">कुल विज्ञापन</span>  |  <span class="span-right">150</span></h3>
                </div> 
                <div class="col-md-12 text-center mb-3">
                    <h3 class="loksewa-content"><span class="span-left">विज्ञापित कुल पद</span>  |  <span class="span-right">150</span></h3>
                </div> 
            </div>
        </div>
    </section>
@endsection

