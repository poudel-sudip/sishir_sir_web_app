@extends('front.layouts.app')

@section('page_title', 'About Us')
@section('og-title', 'About Us')
@section('og-url', url('/about-us'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>About Us</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container personal-details border border-primary rounded">
            <div class="text-justify">
                {!! $page->description !!}
                
                {{-- <div class="my-4 text-justify">
                    <strong>Shisiradhikari.com</strong> is a Nepalese education website that was created in 2022 by <strong>Shisir Kumar Adhikari</strong>,
                    who is also the author of the Mentor Series Books for Health Loksewa. 
                    The primary objective of this website is to provide a comprehensive set of online tools aimed
                    at educating students studying school health science, public health, and medical disciplines.
                </div>
                <div class="my-4 text-justify">
                    The core focus of <strong>shisiradhikari.com</strong> is to deliver educational content through short video lessons.
                    These videos serve as a means of imparting knowledge and facilitating understanding in an easily 
                    digestible format. By utilizing videos, the website aims to make the learning process engaging, 
                    interactive, and accessible to a wide range of students.
                </div>
                <div class="my-4 text-justify">
                    In addition to the video lessons, <strong>shisiradhikari.com</strong> also offers supplementary practice exercises
                    and materials for health educators. These resources further enhance the learning experience by 
                    providing students with opportunities to apply their knowledge and reinforce key concepts. 
                    The inclusion of such practice exercises allows for a more comprehensive approach to learning, 
                    ensuring that students not only acquire knowledge but also develop practical skills.
                </div>
                <div class="my-4 text-justify">
                    The website's founder, <strong>Shisir Kumar Adhikari</strong>, brings his expertise as an author and his understanding 
                    of the educational needs of health science students to the platform. Through his Mentor Series Books, 
                    he has already established himself as a trusted resource in the field. By leveraging his experience 
                    and knowledge, <strong>shisiradhikari.com</strong> aims to provide quality educational content tailored to the specific 
                    needs of Nepalese students pursuing health science, public health, and medical studies.
                </div>
                <div class="my-4 text-justify">
                    Overall, <strong>shisiradhikari.com</strong> strives to be a valuable online resource for students and educators 
                    alike. By offering a combination of video lessons and supplementary materials, 
                    it aims to facilitate effective learning in the health sciences and Health Loksewa field in Nepal.
                </div> --}}
                
            </div>
        </div>
    </div>

@endsection
