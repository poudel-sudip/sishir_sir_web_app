@extends('student.layouts.app')
@section('student-title')
    eBook Contents
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

@endsection
