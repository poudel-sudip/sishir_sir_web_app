@extends('student.layouts.app')
@section('student-title')
   Free Orientation Classes
@endsection
@section('student-title-icon')
    <i class="fas fa-bell"></i>
@endsection
@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            <div class="col-12 h4 mb-3">Free Orientation Classes:</div>
            @foreach($orientations as $ori)
            <div class="col-md-12 my-2">
                <div class="student-notification row justify-content-center align-items-center">
                    <div class="col-5">
                        <a @if(trim($ori->join_link)) href="{{$ori->join_link}}" @endif target="_blank">
                            <img src="/storage/{{$ori->image}}" alt="" class="img img-fluid">
                        </a>
                    </div>
                    <div class="col-7 d-flex align-self-stretch">
                        <a @if(trim($ori->join_link)) href="{{$ori->join_link}}" @endif target="_blank" class="text-decoration-none d-flex flex-column justify-content-around" style="font: inherit; color:inherit; width:100%;" >
                            <h3>{{$ori->course}}</h3>
                            <div>Date: {{date('Y-m-d g:i a',strtotime($ori->date.' '.$ori->time))}}</div>
                            <strong class="text-success">Starts On: <span class="text-primary" data-countdown = "{{$ori->date.' '.$ori->time}}">0 Days 00:00:00 </span></strong>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/libraries/jquery.countdown.min.js') }}"></script>
    <script>
       $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D Days %H:%M:%S'));
            }).on('finish.countdown',function(){
                $this.html('Already Started');
            });
        });
    </script>

@endsection
