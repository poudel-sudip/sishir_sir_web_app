@extends('student.layouts.app')
@section('student-title')
    PDF Contents | {{$pdfbank->title}}
@endsection

@section('student-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <h4 class="text-center my-2">{{$pdfbank->title}}</h4>
        <div class="row">
            @foreach ($contents as $row)
                <div class="col-md-4 my-2">
                    <a class="text-center"  href="/student/pdf-bank-bookings/{{$booking->id}}/pdf-contents/{{$row->id}}" style="text-decoration: none">
                        <div class="student-vid-chapter border border-2 border-primary">
                            <h1 class="text-danger"><i class="fas fa-file-pdf"></i></h1>
                            <h5 class="text-black">{{($row->title ?? '')}}</h5>                            
                        </div>
                    </a>
                </div>
            @endforeach
                        
        </div>
    </div>

@endsection
