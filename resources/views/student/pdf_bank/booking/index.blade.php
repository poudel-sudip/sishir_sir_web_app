@extends('student.layouts.app')
@section('student-title')
    Enrolled eBooks
@endsection

@section('student-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                {{-- <a class="student-enroll-btn" href="{{ url('/student/pdf-bank-bookings/create') }}">Enroll eBook</a> --}}
                <a class="student-enroll-btn" href="/pdf-banks">Enroll eBook</a>
            </div>
        </div>
        <div class="row">
            @foreach ($bookings as $booking)
                <div class="col-md-4 student-video-card mb-3">
                    <div class="vid-card-img-container">
                        @if ($booking->status=="Verified")
                        <a href="/student/pdf-bank-bookings/{{$booking->id}}/pdf-contents">
                            <img src="/storage/{{$booking->book->thumbnail ?? ''}}" alt="thumbnail error" class="img img-fluid">
                        </a>
                        @else
                        <img src="/storage/{{$booking->book->thumbnail ?? ''}}" alt="thumbnail error" class="img img-fluid">
                        @endif
                    </div>
                    <div class="student-vid-dec">
                        <h6>{{($booking->book->title ?? '')}}</h6>
                        @if($booking->book)
                            <div>{{ $booking->book->type == 'set' ? $booking->book->chapters()->where('status','=','Active')->count() : 1 }} pdf sets</div>
                        @endif
                        <div class="small">Expiry Date: {{$booking->expiry_date}}</div>
                        <div class="student-vid-status">                            
                            @if ($booking->status == "Verified")
                            <div class="text-success">{{$booking->status}}</div>
                            @else
                            <div class="text-primary">{{$booking->status}}</div>
                            @endif
                            <div class="text-end">
                                @if($booking->status!="Verified")
                                    <a href="/student/pdf-bank-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm">Verify</a> 
                                    <form id="delete-form-{{$booking->id}}" action="/student/pdf-bank-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>
                                @else 
                                <a href="/student/pdf-bank-bookings/{{$booking->id}}/pdf-contents" class="btn btn-success btn-sm">View PDFs</a> 
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

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection
