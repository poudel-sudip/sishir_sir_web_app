@extends('student.layouts.app')
@section('student-title')
    Enrolled Course Batches
@endsection

@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                {{-- <a class="student-enroll-btn" href="{{ url('/student/online-course-bookings/create') }}">Book a Course Batcht</a> --}}
                <a class="student-enroll-btn" href="/courses">Book a Course Batch</a>
            </div>
        </div>
        <div class="row">
            @foreach ($bookings as $booking)
                <div class="col-md-4 student-video-card mb-3">
                    <div class="vid-card-img-container">
                        @if ($booking->status=="Verified")
                            <a href="/student/online-course-bookings/{{$booking->id}}/curriculum">
                                <img src="/storage/{{$booking->batch->image ?? ''}}" alt="thumbnail error" onerror="this.src='/images/default-post.png'" class="img img-fluid">
                            </a>
                        @else
                            <img src="/storage/{{$booking->batch->thumbnail ?? ''}}" alt="thumbnail error" onerror="this.src='/images/default-post.png'" class="img img-fluid">
                        @endif
                    </div>
                    <div class="student-vid-dec">
                        <h6>{{($booking->batch->name ?? '')}}</h6>
                        
                        {{-- <div class="small">Expiry Date: {{$booking->expiry_date}}</div> --}}
                        @if ($booking->status == "Verified")
                            <div class="text-success">{{$booking->status}}</div>
                        @elseif($booking->status == "Expired")
                            <div class="text-danger">{{$booking->status}} <span class="text-primary">(Renew with 50% discount)</span> </div>
                        @else
                            <div class="text-danger">{{$booking->status}}</div>
                        @endif
                        <div class="f-flex gap-1">                            
                            <div class="text-end">
                                @if($booking->status == 'Verified')
                                    {{-- <a href="/student/online-course-bookings/{{$booking->id}}/files" class="btn btn-info btn-sm mb-1 ">Files</a>  --}}
                                    {{-- <a href="/student/online-course-bookings/{{$booking->id}}/videos" class="btn btn-danger btn-sm mb-1 ">Videos</a>  --}}
                                    <a href="/student/online-course-bookings/{{$booking->id}}/curriculum" class="btn btn-success btn-sm mb-1 ">View Contents</a> 
                                    {{-- <a href="/student/online-course-bookings/{{$booking->id}}/mcq-exams" class="btn btn-primary btn-sm mb-1 ">MCQ Exams</a>  --}}
                                    <a href="javascript:{}" onclick="javascript:attemptExamData({{$booking->id}});" class="btn btn-danger btn-sm mb-1 ">Attempt Final Exam</a>

                                @elseif($booking->status == 'Completed')
                                    <a href="/student/online-course-bookings/{{$booking->id}}/certificate" class="btn btn-success btn-sm">View Certificate</a> 
                                @else
                                    <a href="/student/online-course-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm">Verify</a> 
                                    <form id="delete-form-{{$booking->id}}" action="/student/online-course-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="">
            {{$bookings->onEachSide(1)->links('paginator.bootstrap')}}
        </div>
        <div class="mt-3">
            <h4>Disclaimer:</h4>
            <p>
                If you print or copy any material placed here physically or with the help of electronic devices without permission, or if you use it or reproduce it unauthorized or share it on social media, action will be taken according to copyright Act.
            </p>
            <p>
                हजुरहरुले यहाँ राखिएको कुनैपनि सामग्री अनुमती नलिई अरु कसैलाई भौतिक रुपमा प्रिन्ट गरी वा इलेक्ट्रोनिक डिभाइसको मद्धतले कपि गरी अनाधिकृत रुपमा प्रयोग वा पुर्नउत्थान गरेमा वा सामाजिक सञ्जालमा शेयर गरेको पाइएमा प्रतिलिपि अधिकार ऐन अनुसार कारबाही गरिने  छ ।
            </p>
        </div>
    </div>

    <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>
    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }

        function attemptExamData(id)
        {
            Swal.fire({
                title: 'Confirmation',
                text: "Do you want to attempt this final exam? Once Attempted, you cannot access its course contents.",
                icon: 'warning',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                denyButtonColor: '#00e3f3',
                confirmButtonText: 'Yes, Attempt It',
                cancelButtonText: 'No, Cancel It',
            }).then((result) => {
                if(result.isConfirmed) 
                {
                    redirectto = '/student/online-course-bookings/'+id+'/final-exam';
                    window.location.href = redirectto;
                }
                else
                {
                    // alert('cancncelled'); 
                }
            });
        }
    </script>

@endsection
