@extends('student.layouts.app')
@section('student-title')
    Student Home
@endsection
@section('student-title-icon')
    <i class="fas fa-house-user"></i>
@endsection

@section('content')
    <style>
        .dashboard-menus .nav-item .nav-link{
            font-weight: 500;
            color: #363434;
        }

        .dashboard-menus .nav-item .nav-link:hover {
            background: rgb(52 144 220 / 27%);
            color: #116cb7;
        }
    </style>

    <div> @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <section class=" student-content-wrapper">
        <div class="main-news-home">
            <div class="student-home-block mt-4">                

                <div class="student-dashboard-card block-third">
                    <div class="first-row">
                        <span>Exam Set Bookings</span>
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/exam-bookings">View Bookings</a>
                        <span>{{$count->bookings->exams ?? '-'}}</span>
                    </div>
                </div>

                <div class="student-dashboard-card block-fourth">
                    <div class="first-row">
                        <span>eBook Bookings</span>
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/pdf-bank-bookings">View Bookings</a>
                        <span>{{$count->bookings->pdf_banks ?? '-'}}</span>
                    </div>
                </div>  
                
                <div class="student-dashboard-card block-second">
                    <div class="first-row">
                        <span>Free Exams</span>
                        <i class="fas fa-stopwatch"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="{{$count->free_exams->link ?? '-'}}">View Exams</a>
                        <span>{{$count->free_exams->count ?? '-'}}</span>
                    </div>
                </div>    

            </div>            
        </div>        
    </section>
   
    <section class="student-content-wrapper mt-4 d-md-none">
        <div class="card">
            <div class="card-body">
                <h4 class="text-info">MENUS</h4>
                <ul class="nav flex-column dashboard-menus">
                    <li class="active nav-item">
                      <a class="nav-link" aria-current="page" href="/student/home"><i class="fas fa-house-user text-primary me-1"></i> Student Home</a>
                    </li>           
                    
                    <li class="nav-item">
                      <a class="nav-link" href="/student/pdf-bank-bookings"><i class="fas fa-file-pdf text-pink  me-1"></i>eBook Bookings</a>
                    </li>
        
                    <li class="nav-item">
                      <a class="nav-link" href="/student/exam-bookings"><i class="fas fa-laptop-house text-info  me-1"></i>Exam Set Bookings</a>
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link" href="/student/invoices"><i class="fas fa-file-pdf text-primary  me-1"></i>Invoices</a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="/student/tickets"><i class="fas fa-address-card text-danger me-1"></i>Ask/Complain  Admin</a>
                    </li>
        
                    <li class="nav-item">
                        <a class="nav-link" href="/student/free-exams"><i class="fas fa-stopwatch text-orange me-1"></i>Free Exams</a>
                      </li>   

                    <li class="nav-item">
                      <a class="nav-link" href="/student/vaccancies"><i class="fas fa-graduation-cap  text-pink  me-1"></i>Latest Vacancies</a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="/library"><i class="fas fa-swatchbook text-info me-1"></i>eLibrary</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/question-of-the-day-quiz"><i class="fas fa-stopwatch text-primary me-1"></i>Play Quiz</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/discussion-forum"><i class="fas fa-table text-danger me-1"></i>Discussion Forum</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/newsroom"><i class="fas fa-blog text-primary me-1"></i>Newsroom</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/books"><i class="fas fa-swatchbook text-info me-1"></i>Books</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/free-videos"><i class="fas fa-video text-pink me-1"></i>Videos</a>
                    </li>

                </ul>
            </div>
        </div>
        
    </section>

      

@endsection
