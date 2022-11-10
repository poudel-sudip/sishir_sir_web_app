@extends($header)

@section('student-title')
    My Profile
@endsection

@section('student-title-icon')
    <i class="fas fa-address-card"></i>
@endsection
@section('tutor-title')
    My Profile
@endsection
@section('tutor-title-icon')
    <i class="fas fa-address-card"></i>
@endsection

@section('content')
    <div class="student-content-wrapper content-wrapper">
        <div class="row">
            <div class="col-md-2 col-4">
                @if(auth()->user()->photo)
                <img src="/storage/{{auth()->user()->photo }}" alt="{{auth()->user()->name }}" class="w-100">
              @else
                <img src="{{ asset('images/student.jpg') }}" alt="{{auth()->user()->name }}" class="w-100">
              @endif
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-9 mt-3 col-8">
                <div class="single-details row mt-1">
                    <div class="booking-title col-3">User ID:</div>
                    <div class="booking-data col-8">{{auth()->user()->id}}</div>
                </div>
                <div class="single-details row mt-1">
                    <div class="booking-title col-3">Full Name:</div>
                    <div class="booking-data col-8">{{auth()->user()->name}}</div>
                </div>
                <div class="single-details row mt-1">
                    <div class="booking-title col-3">Email:</div>
                    <div class="booking-data col-8">{{auth()->user()->email}}</div>
                </div>
                <div class="single-details row mt-1">
                    <div class="booking-title col-3">Contact:</div>
                    <div class="booking-data col-8">{{auth()->user()->contact}}</div>
                </div>
            </div>
            <div class="col-md-12 text-right text-end">
                @if(auth()->user()->role=='Tutor')
                <a class="btn btn-success btn-sm" href="/profile/professionaledit">Edit Professional Details</a>
                @endif
                <a class="btn btn-primary btn-sm" href="/profile/edit">Edit Profile</a>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-12 text-end">
            @if(auth()->user()->role=='Tutor')
            <a class="btn btn-success btn-sm" href="/profile/professionaledit">Edit Professional Details</a>
            @endif
            <a class="btn btn-primary btn-sm" href="/profile/edit">Edit Profile</a>
            </div> --}}
            <div class="col-md-12">
                <div class="show-student-profile">
                    {{-- <div class="single-details">
                        <div class="booking-title">User ID:</div>
                        <div class="booking-data">{{auth()->user()->id}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Full Name:</div>
                        <div class="booking-data">{{auth()->user()->name}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Email:</div>
                        <div class="booking-data">{{auth()->user()->email}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Contact:</div>
                        <div class="booking-data">{{auth()->user()->contact}}</div>
                    </div> --}}
                    <div class="single-details">
                        <div class="booking-title">User District/City:</div>
                        <div class="booking-data">{{auth()->user()->district_city}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Provience:</div>
                        <div class="booking-data">{{auth()->user()->provience}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Role:</div>
                        <div class="booking-data">{{auth()->user()->role}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Status:</div>
                        <div class="booking-data">{{auth()->user()->status}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Last Login:</div>
                        <div class="booking-data">{{auth()->user()->last_login}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">User Interests:</div>
                        <div class="booking-data">{{auth()->user()->interests}}</div>
                    </div>
                    @if(auth()->user()->role=='Tutor')
                    <div class="single-details">
                        <div class="booking-title">Experience:</div>
                        <div class="booking-data">{{auth()->user()->tutorProfile->experience}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Qualification:</div>
                        <div class="booking-data">{{auth()->user()->tutorProfile->qualification}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Avg Rating:</div>
                        <div class="booking-data">{{auth()->user()->tutorProfile->rating}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Description:</div>
                        <div class="booking-data">{!! auth()->user()->tutorProfile->description !!}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
