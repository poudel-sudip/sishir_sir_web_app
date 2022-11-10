@extends('front.layouts.app')
@section('title')
  About
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>About Us</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">About us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center about-heading">
                  <span class="page-sub-heading">ETUTORS A GLORIOUS JOURNEY</span>
                  <h2 class="mb-3">“Everything starts with one step, or one brick, or one word or one day.”</h2>
                </div>
            </div>
            <div class="row about-details">
                <div class="col-md-5">
                    <div class="about-image">
                        <img src="{{ asset('images/about.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h6>FROM THE DESK OF FOUNDER & CEO</h6>
                    <h5>Mt. Husain</h5>
                    <p>
                        Keeping in mind the high demand of the Learners we opened our doors with the mission to make a learning system as convenient, effective & affordable as possible through Digitalization. It was a challenging beginning in the initial year. I started this journey with a smaller number of students, I strived to nurture them with a belief “careful nurturing and right direction can help learners unlock their full learning potential” and with the abundance of love and support of our well-wishers and eTutorian in a matter of few years, we have able to connect with 10000+ students and have made it into a trustworthy destination for all the students. 
                    </p>
                    <p>
                        eTutorclass has always been convenient, effective, accessible, and reasonable for all the aspirants who carry their aim to crack competitive examination conduct by Public Service Commission (PSC)-Lok Sewa Aayog (लोकसेवा आयोग), All Nepal common Entrance examination many more and seeking a platform to give a kickoff start to their career. It is also a boon to learners who wants to accelerate their skills to keep up with the fast-changing world. similarly, it helps students to maintain their academic progress and make a difference in their preparation. 
                    </p>
                    <p>
                        What makes eTutorclass the first choice is the specialized expert trainers that it offers to the eTutorian. Success is sweet, but it’s as sweeter as when it is achieved through coordination, cooperation, and collaboration so Thank you, Expert resources for connecting with us and utilizing skills, experiences, knowledge as well as time to make eTutor Class always stand out tall in the Digitalized learning system with cutting edge technology.
                    </p>
                    <p style="font-style: italic">
                        I wish every eTutorian a bright future ahead.
                    </p>
                </div>
            </div>
            <div class="row about-details">
                <div class="col-md-12">
                    <h5>eTutor Class (Nepal’s First Open Online Tutoring Class)</h5>
                </div>
                <div class="col-md-12">
                    <p>
                        eTutorclass is Nepal’s First open online tutoring class system that connects teachers, students, institutions, schools, colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology.
                    </p>
                    <p>
                        It manages expert resources from various fields in our work ecosystem and utilizes their skills, experiences, knowledge as well as time to provide bundle-up services to the students at reasonable charges so that they can excel in their future and career. It also emphasizes teachers increase their regular income by utilizing their free Part-time and letting them teach what they love to teach through which students can learn quality education with Nepal's top Ranked Tutor.
                    </p>
                    <p>
                        Learning with eTutorclass is more convenient and 2x-3x times more affordable than usual classes either physical or Online Classes where students can strengthen their preparation with our study material by fingertip sitting at home. Our Mission is to make the learning system as convenient, effective & affordable as possible through Digitalization. 
                    </p>
                    <p style="font-style: italic">
                        A Step Towards Digitalizing the Nation...!
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection