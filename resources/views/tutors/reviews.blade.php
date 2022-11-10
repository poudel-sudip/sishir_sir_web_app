@extends('tutors.layouts.app')
@section('tutor-title')
    My Reviews
@endsection
@section('tutor-title-icon')
    <i class="fas fa-comment-dots"></i>
@endsection

@section('content')
    <div class="container student-enroll-section">
        
        <div class="row">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Review By</th>
                                <th>Review Content</th>
                                <th>Rating</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($tutor->reviews as $review)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$review->name}}</td>
                                <td class="text-wrap">{{$review->review}}</td>
                                <td>{{$review->rating}}</td>
                                <td>{{date('Y/m/d',strtotime($review->created_at))}}</td>                                
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                

                </div>

            </div>
        </div>
    @endsection
