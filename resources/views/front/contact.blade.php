@extends('front.layouts.app')
@section('title')
  Contact
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Contact us</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-details-page">
                        <h5>Head Office</h5>
                        <div>
                            <h6><span class="icon-location2 text-primary"></span> Bagbazar, Kathmandu, Nepal</h6>
                            <h6><span class="icon-phone text-primary"></span> +977 014242320</h6>
                        </div>
                        <div class="mt-3">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d220.77540673102607!2d85.31839474813366!3d27.70473251173386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1915624c6777%3A0x175e3c050fa7d7c8!2seTutorclass%20-%20Bagbazar%2C%20Kathmandu!5e0!3m2!1sen!2snp!4v1638430484264!5m2!1sen!2snp" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-details-page">
                        <h5>Butwal Branch</h5>
                        <div>
                            <h6><span class="icon-location2 text-primary"></span> Kalikanagar-9,Itavatti, Butwal, Nepal</h6>
                            <h6><span class="icon-phone text-primary"></span> +977 071590980
                                {{-- <span class="icon-mobile text-primary"></span> +977 9857084806 --}}
                            </h6>
                        </div>
                        <div class="my-3">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.7929375511844!2d83.46013781492996!3d27.692793932738553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39968744ed6dbd85%3A0x3cb813fbaf5bb3a5!2seTutorclass%20%2C%20Butwal%20Branch!5e0!3m2!1sen!2snp!4v1638430549987!5m2!1sen!2snp" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection