@extends('front.layouts.app')
@section('page_title','Home')
@section('content')

    <style>
        body{
            overflow-x: hidden;
        }
    </style>
    
    <section class="mt-4">
        <div class="container-fluidb px-md-5">
            <div class="row">
                <div class="col-md-9">
                    <div class="marquee-text">
                        <marquee width="100%" direction="left" height="25px">
                            @foreach ($updates as $update)
                            <span style="padding-right: 10rem"><a href="{{$update->link}}"><i class="fas fa-star text-danger"></i> {{($update->title)}}</a></span>
                            @endforeach
                        </marquee>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <iframe scrolling="no" border="0" frameborder="0" marginwidth="0" marginheight="0" allowtransparency="true" src="https://www.ashesh.com.np/linknepali-time.php?time_only=no&font_color=1375b9&aj_time=yes&font_size=18&line_brake=0&bikram_sambat=0&nst=no&api=500122n569" width="307" height="22"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-3">
        <div class="container-fluid px-md-5">
            <div class="row align-items-stretch flex-row-reverse">
                
                <div class="my-1 col-md-3 ">
                    <div class="updates border border-primary border-2" style="height: 100%">
                        <div class="update-header">
                            <div class="text-light text-center p-1" style="background: #1375b9"><h5><i class="fas fas fa-clock"></i> Updates </h5></div>
                        </div>
                        <div class="update-body" style="max-height:375px; overflow-y:scroll">
                            <ul class="p-0">
                                @forelse($updates as $row)                         
                                    <li><a href="{{$row->link}}"><i class="far fa-check-circle"></i>{{ucwords($row->title)}}</a></li>
                                @empty
                                    <li>No Trendings Available</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    
                </div>

                <div class="my-1 col-md-6 text-center">
                    @if($today_question)
                        <div class="" >
                            <a href="/question-of-the-day/{{$today_question->show_date}}">
                                <img src="{{$today_question->image}}" alt="{{$today_question->show_date}}"  style="max-height:400px;" class="img img-fluid border border-3 border-danger">                                   
                            </a>
                        </div>
                    @endif
                </div>
                
                <div class="my-1 col-md-3 ">
                    <div class="updates border border-primary border-2" style="height: 100%">
                        <div class="update-header">
                            <div class="text-light text-center p-1" style="background: #1375b9"><h5><i class="fas fa-chart-bar"></i> Trending </h5></div>
                        </div>
                        <div class="update-body" style="max-height:375px; overflow-y:scroll">
                            <ul class="p-0">
                                @forelse(Helper::mostViewPosts() as $row)                         
                                    <li><a href="{{$row->url}}"><i class="fa fa-pen-nib"></i>{{ucwords($row->title)}} <small class="ms-2 text-primary text-nowrap">({{$row->count}} views)</small> </a></li>
                                @empty
                                    <li>No Trendings Available</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>

    {{-- <section class="home-slider mt-2">
        <div class="container-fluid px-md-5">
            <div class="row">
                <div class="col-md-8">
                    @if($today_question)
                        <div class="border border-2 border-danger" >
                            <a href="/question-of-the-day/{{$today_question->show_date}}">
                                <img src="{{$today_question->image}}" alt="{{$today_question->show_date}}" width="100%" style="max-height:500px;" class="img img-fluid">                                   
                            </a>
                        </div>
                    @endif
                  
                </div>
                <div class="col-md-4 border border-primary border-2 rounded p-0" style=" ">
                    <div class="homepage-side-update " style="box-shadow: none; height:auto; ">
                        <div class="update-header"><h5><i class="fas fa-clock"></i> UPDATES</h5></div>
                        <div class="update-body " style="height: 475px; overflow-y:scroll;">
                            <ul>
                                @forelse($updates as $update)                            
                                    <li><a href="{{$update->link}}"><i class="far fa-check-circle"></i>{{ucwords($update->title)}}</a></li>
                                @empty
                                    <li>No Updates Available</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section> --}}

    @if($ads->where('position','=','after_landing_section')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_landing_section')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    {{-- @if($today_question)
        <section class="my-3 text-center">
            <a href="/question-of-the-day/{{$today_question->show_date}}">
                <img src="{{$today_question->image}}" alt="" class="img img-fluid">            
            </a>
        </section>
    @endif --}}


    @if(count($dynamic_forms))
    <section class="home-slider my-5">
        <div class="container-fluid px-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-slider owl-carousel">
                        @foreach($dynamic_forms as $form)
                            <div class="single-item row form-row">
                                <div class="col-sm-6 col-md-8 form-banner"><img src="/storage/{{$form->banner}}" alt=""></div>
                                <div class="col-sm-6 col-md-4 form-fillup">
                                    <h4>Class Registeration Form</h4>
                                    <form  action="/dynamic-forms/{{$form->slug}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if (Session::has('successMessage'))
                                        <div class="form-group row my-2">
                                            <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                        </div>
                                        @endif

                                        <div class="form-group row my-2">
                                            <label for="sub_course" class="col-12 col-form-label">{{ __('Course') }}</label>
                    
                                            <div class="col-12">
                                                <select name="sub_course" id="sub_course" class="form-control @error('sub_course') is-invalid @enderror">
                                                    @php($subs = array_map('trim', explode(',', $form->sub_categories)))
                                                    @foreach($subs as $cat)
                                                        <option value="{{ucwords($cat)}}">{{ucwords($cat)}}</option>
                                                    @endforeach
                                                </select>
                                                @error('sub_course')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(isset($form->name) && $form->name)
                                            <div class="form-group row my-2">
                                                <label for="element_name" class="col-12 col-form-label">Name</label>
                
                                                <div class="col-12">
                                                    <input id="element_name" type="text" class="form-control @error('element_name') is-invalid @enderror" name="element_name" value="{{ old('element_name') }}" required>
                
                                                    @error('element_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($form->email) && $form->email)
                                            <div class="form-group row my-2">
                                                <label for="element_email" class="col-12 col-form-label">Email</label>
                
                                                <div class="col-12">
                                                    <input id="element_email" type="email" class="form-control @error('element_email') is-invalid @enderror" name="element_email" value="{{ old('element_email') }}" required>
                
                                                    @error('element_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        @if(isset($form->contact) && $form->contact)
                                            <div class="form-group row my-2">
                                                <label for="element_contact" class="col-12 col-form-label">Contact</label>
                
                                                <div class="col-12">
                                                    <input id="element_contact" type="number" class="form-control @error('element_contact') is-invalid @enderror" name="element_contact" value="{{ old('element_contact') }}" required>
                
                                                    @error('element_contact')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                                                                                        
                                        @if(isset($form->message) && $form->message)
                                            <div class="form-group row my-2">
                                                <label for="element_message" class="col-12 col-form-label">Message</label>
                
                                                <div class="col-12">
                                                    <textarea name="element_message" id="element_message" rows="2" class="form-control @error('element_message') is-invalid @enderror"> {{ old('element_message') }} </textarea>
                                                    
                                                    @error('element_message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group row mt-2">
                                            <div class="col-12 ">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> 
    </section>
    @endif

    <section class="mock-test mb-5 mt-5">
        <div class="container-fluid px-md-5">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3">Mock Tests</h2>
                </div>
            </div>
            <div class="mocktest-container">
                <nav>
                    <div class="nav nav-tabs mock-premium" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Premium</button>
                      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Free</button>
                      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-result" type="button" role="tab" aria-controls="nav-result" aria-selected="false">Results</button>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <div class="row">
                                    @foreach ($premiumExams as $exam)
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="seller-item border border-primary rounded border-2">
                                                <div class="seller-header text-center">
                                                    <a href="/exam-hall/premium/{{$exam->slug}}">
                                                        <img src="/storage/{{$exam->image}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                                    </a>
                                                    <h5 class="mt-3"><a href="/exam-hall/premium/{{$exam->slug}}">{{ucwords($exam->title)}}</a></h5>
                                                    <h6>{{$exam->category_exams->count()}} Sets </h6>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- @foreach ($premiumExams as $exam)
                                        <div class="col-md-6 mb-5">
                                            <h3 class="mock-heading">{{$exam->title}}</h3>
                                            <div class="mb-3">({{$exam->category_exams()->count() ?? '-'}} Sets)</div>
                                            <a href="/exam-hall/premium/{{$exam->slug}}" class="mock-btn mock-btn1">Book Now</a>
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <div class="row">
                                    @foreach ($exams as $exam)
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="seller-item border border-primary rounded border-2">
                                                <div class="seller-header text-center">
                                                    <a href="/public-exams/{{$exam->slug}}">
                                                        <img src="/storage/{{$exam->image}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                                    </a>
                                                    <h5 class="mt-3"><a href="/public-exams/{{$exam->slug}}">{{ucwords($exam->name)}}</a></h5>
                                                    <h6>{{ $exam->exam ? ($exam->exam->questions ? $exam->exam->questions->count() : '-') : '-' }} Questions </h6>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- @foreach ($exams as $exam)
                                        <div class="col-md-6 mb-5">
                                            <h3 class="mock-heading">{{$exam->name}}</h3>
                                            <div class="mb-3">({{ $exam->exam ? ($exam->exam->questions ? $exam->exam->questions->count() : '-') : '-' }} Questions)</div>
                                            <a href="/public-exams/{{$exam->slug}}" class="mock-btn mock-btn1">Exam</a>
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-result" role="tabpanel" aria-labelledby="nav-result-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <a href="/results" class="mock-btn mock-btn1">View Exam Results...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="/public-exams" class="btn" style="background:#1375b9; color:#fff;">View all exams...</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </section>

    @if($ads->where('position','=','after_mock_test')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_mock_test')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- @if(count($pdf_banks))
        <div class="container-fluid px-md-5 eb-seller my-5">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3">PDF Banks</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="owl-carousel eb-seller-carousel">
                        @foreach($pdf_banks as $row)
                            <div class="seller-item bg-light p-3 border border-primary rounded">
                                <div class="seller-header text-center">
                                    <a href="/pdf-banks/bank/{{$row->slug}}">
                                        <img src="/storage/{{$row->thumbnail}}" alt="" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                    </a>
                                </div>
                                <div class="seller-footer">
                                    <h4 class="text-center" title="{{strtoupper($row->title)}}"> <a href="/pdf-banks/bank/{{$row->slug}}"> {{strtoupper($row->title)}} </a></h4>
                                    <div class="text-center text-danger" style="margin-top: -0.5rem">(PDF Sets: <span class="text-primary">{{ $row->pdf_count ?? '' }}</span>)</div>
                                    <div>Price : @if($row->discount > 0) <s class="text-danger">Rs. {{ $row->price }}</s> @endif <strong class="text-success"> Rs. {{ ($row->price - $row->discount) }}</strong></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
            <div class="text-end mt-2">
                <a href="/pdf-banks" class="btn" style="background:#1375b9;color:#fff">View all...</a>
            </div>
        </div>

    @endif --}}

    @if(count($pdf_bank_categories))
        
        <section class="footer-imp-link mt-5 mb-5">
            <div class="container-fluid px-md-5">
                <h4 class="m-4 text-center">Premium PDF Bank</h4>
                <nav>
                    <div class="nav nav-tabs" id="nav-pdf-bank-tab" role="tablist">
                        @php($isFirstElement = true)
                        @foreach($pdf_bank_categories as $cat)
                            <button class="border nav-link {{$isFirstElement ? 'active' : ''}}" id="nav-pdf-bank-{{ $cat->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-pdf-bank-{{ $cat->id }}" type="button" role="tab" aria-controls="nav-pdf-bank-{{ $cat->id }}" aria-selected="true">{{ucwords($cat->name)}}</button>
                            @php($isFirstElement = false)
                        @endforeach
                    </div>
                </nav>
                <div class="tab-content shadow border border-danger border-2 p-1" id="nav-pdf-bank-tabContent" style="border-top:0px !important;">
                    @php($isFirstElement = true)
                    @foreach($pdf_bank_categories as $cat)
                        <div class="tab-pane fade  {{$isFirstElement ? 'active show' : ''}} " id="nav-pdf-bank-{{ $cat->id }}" role="tabpanel" aria-labelledby="nav-pdf-bank-{{ $cat->id }}-tab" tabindex="0">
                            @php($isFirstElement = false)
                            <div class="row">
                                @foreach ($cat->pdf_banks as $row)
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <div class="seller-item border border-primary rounded border-2">
                                            <div class="seller-header text-center">
                                                <a href="/pdf-banks/bank/{{$row->slug}}">
                                                    <img src="/storage/{{$row->thumbnail}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:150px; width:auto;" class="img img-fluid" draggable="false">
                                                </a>
                                                <h6 class="mt-3"><a href="/pdf-banks/bank/{{$row->slug}}">{{ucwords($row->title)}}</a></h6>
                                                <h6 class="small">{{$row->pdf_count}} PDF Sets </h6>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                    @endforeach

                    <div class="text-end">
                        <a href="/pdf-banks" class="btn" style="background:#1375b9; color:#fff;">View all PDF Banks...</a>
                    </div>
                </div>
                
                
                
            </div>
        </section>

    @endif

    <section class="home-ebook mt-3 mb-5">
        <div class="container-fluid px-md-5">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3 ">Library</h2>
                </div>
            </div>
            <div class="lib-filter-alphabets">
                <a href="/library" class="lib-filter-character active" > All </a>
                @for($i='A';$i<'Z';$i++)
                    <a href="/library?filter={{$i}}" class="lib-filter-character" > {{$i}} </a>
                @endfor
                <a href="/library?filter=Z" class="lib-filter-character" > Z </a>
            </div>    

            {{-- <div class="row">
                @foreach ($libraries as $cat)
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="ebook-section library-item border border-primary text-center">
                        <div>
                            <a href="/library/{{$cat->slug}}"><i class="h1 fa fa-folder"></i></a>
                        </div>
                        <div class="ebook-footer h5">
                            <a href="/library/{{$cat->slug}}">{{ucwords($cat->name)}}</a>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-12 text-end mt-2">
                    <a href="/library" class="btn" style="background:#1375b9;color:#fff">View all...</a>
                </div>
            </div> --}}
        </div>
    </section>

    @if($ads->where('position','=','after_library')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_library')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="home-blog mt-3 mb-5">
        <div class="container-fluid px-md-5">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3">Blogs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-section border border-primary">
                        <div class="blog-header">
                            <a href="/blogs/{{$last_blog->slug}}"><img src="/storage/{{$last_blog->image}}" alt=""></a>
                        </div>
                        <div class="blog-footer">
                            <h3>{{$last_blog->title}}</h3>
                            <div class="blog-footer-details">{!! Helper::excerpt($last_blog->description,500) !!}</div>
                            <div class="mb-3 mt-2"><small class="text-primary">Published: {{date('Y-m-d',strtotime($last_blog->created_at))}}</small> <small class="text-success" style="float: right">By: {{$last_blog->author}}</small></div>
                            <div class="blog-details"><a href="/blogs/{{$last_blog->slug}}">View Details</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 position-relative">
                    <div class="home-blog-list">
                        @foreach ($blogs as $blog)
                        <div class="row mb-2 @if ($loop->first) hidden @endif">
                            <div class="col-4">
                                <img src="/storage/{{$blog->image}}">
                            </div>
                            <div class="col-8">
                                <h4 class="blog-list-title"><a href="/blogs/{{$blog->slug}}">{{$blog->title}}</a></h4>
                                <div>Published: <span class="text-primary"> {{date('Y-m-d',strtotime($blog->created_at))}}</span></div>
                                <div>By: <span class="text-success"> {{$blog->author}}</span></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="home-blog-btn">
                        <a href="/blogs" class="btn">View all...</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    @if($ads->where('position','=','after_blogs')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_blogs')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($books))
        <div class="container-fluid px-md-5 eb-seller my-5">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3">My Books</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="owl-carousel eb-seller-carousel">
                        @foreach($books as $book)
                            <div class="seller-item bg-light p-3 border border-primary rounded">
                                <div class="seller-header text-center">
                                    <a href="/books/{{$book->slug}}">
                                        <img src="/storage/{{$book->thumbnail}}" alt="" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                    </a>
                                </div>
                                <div class="seller-footer">
                                    <h4 class="text-center" title="{{strtoupper($book->title)}}"> <a href="/books/{{$book->slug}}"> {{strtoupper($book->title)}} </a></h4>
                                    <div class="text-center text-danger" style="margin-top: -0.5rem">(Edition: <span class="text-primary">{{ $book->edition ?? '' }}</span>)</div>
                                    <div>Price : @if($book->discount > 0) <s class="text-danger">Rs. {{ $book->price }}</s> @endif <strong class="text-success"> Rs. {{ ($book->price - (($book->price*$book->discount)/100)) }}</strong></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
            <div class="text-end mt-2">
                <a href="/books" class="btn" style="background:#1375b9;color:#fff">View all...</a>
            </div>
        </div>

    @endif

    @if($ads->where('position','=','after_books')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_books')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($videos))
        <section class="course-section">
            <div class="container-fluid px-md-5">
                <div class="row">
                    <div class="col-md-12 text-center relative">
                        <h2 class="home-section-heading mb-3 ">Videos</h2>
                        {{-- <div class="header-view-more"><a href="{{ url('/free-videos') }}">View More</a></div> --}}
                    </div>
                </div>
                <div class="course-container">
                    <div class="owl-carousel review-slider">
                        @foreach($videos as $video)
                            <div class="card-course border border-primary border-2">
                                <a href="/free-videos/{{$video->id}}">
                                    <div class="single-video w-100" style="position: relative;">
                                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 1; cursor: pointer;z-index:99" ></div>
                                        <iframe
                                            class="embed-responsive-item"
                                            src="https://www.youtube.com/embed/{{$video->video_id}}"
                                            frameborder="0"
                                            width="100%"
                                            height="100%"
                                            allowfullscreen
                                            style="width:100%; height:100%; min-height:210px">
                                        </iframe>                                        
                                    </div>
                                </a>
                                {{-- <div class="header">
                                    <div class="post-thumb" style="height:200px">
                                        <img src="https://img.youtube.com/vi/{{$video->video_id}}/hqdefault.jpg" alt="" >
                                    </div>

                                </div>
                                <div class="body">
                                    <h5 class="post-title text-center" style="font-size: 16px">{{$video->title}}</h5>
                                    <div class="course-info text-center">
                                        <a class="btn-sm btn-primary" href="/free-videos/{{$video->id}}" >Play Video</a>
                                    </div>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-2">
                        <a href="/free-videos" class="btn" style="background:#1375b9;color:#fff">View all...</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($ads->where('position','=','after_videos')->count())
        <section class="home-banner">
            <div class="container-fluid px-md-5">
                <div class="row">
                    @foreach ($ads->where('position','=','after_videos')->values() as $ad)
                    <div class="col-md-12 my-2 text-center">
                        <img class="img img-fluid" src="/storage/{{$ad->banner}}" alt="" style="max-height:350px;">
                        <div>{{$ad->info}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    @if(count($img_gallery))
        <section class="course-section">
            <div class="container-fluid px-md-5">
                <div class="row">
                    <div class="col-md-12 text-center relative">
                        <h2 class="home-section-heading mb-3 ">Image Gallery</h2>
                    </div>
                </div>
                <div class="course-container">
                    <div class="owl-carousel review-slider">
                        @foreach($img_gallery as $row)
                            <div class="card-course border border-primary border-2" title="{{$row->caption}}">
                                <a target="_blank" href="/storage/{{$row->image}}"><img src="/storage/{{$row->image}}" class="img img-fluid" alt="img_error" style="width: 100%; max-height:300px"></a>
                                <div  class="ps-1 text-center text-nowrap" style="overflow-x: hidden; text-overflow: ellipsis;">
                                   {{$row->caption}}
                                </div>                               
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-2">
                        <a href="/image-gallery" class="btn" style="background:#1375b9;color:#fff">View all...</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- review section start --}}
    @if(count($testimonials))
    <section class="review-section mt-5">
        <div class="container-fluid px-md-5">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3">Testimonial</h2>
                </div>
            </div>
            <div class="review-container">
            <div class="row">
                {{-- <div class=" owl-carousel review-slider">
                    @foreach($testimonials as $testimonial)
                        <div class="reviw-item border border-primary" style="overflow: hidden">
                            <div class="reviewer">
                                <div class="profile-image">
                                    <img src="/storage/{{$testimonial->image}}" alt="Feedback Review">
                                </div>
                                <div class="profile-details">
                                    <h5>{{$testimonial->name}}</h5>
                                    <p>{{$testimonial->role}}</p>
                                </div>
                            </div>
                            <div class="review-content">
                                <div class="review text-justify">
                                    <p class="text-justify">{{$testimonial->message}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                <div class="owl-carousel review-slider" style="align-items: stretch;">
                    @foreach($testimonials as $row)
                        <div class=" reviw-item border border-primary" style="height:100%; align-items:stretch; align-self:stretch">
                            <div class="text-center">
                                <div class="profile-image d-inline-block">
                                    <img src="/storage/{{$row->image}}" alt="{{$row->name}}">
                                </div>

                                <div class="mt-2">
                                    <p >{{$row->message}}</p>
                                </div>

                                <div class="mt-2">
                                    <h6 class="text-primary">{{$row->name}}, <em> {{$row->role}} </em> </h6>
                                </div>

                            </div>
                            
                            {{-- <div>
                                <img src="/storage/{{$row->image}}" alt="{{$row->name}}" width="100%" style="max-height:420px;">
                            </div>
                            <div class="text-center mt-1" >
                                <h5>{{$row->message}}</h5> 
                            </div> --}}
                        </div>
                    @endforeach
                </div>

            </div>
            </div>
        </div>
    </section>
    @endif
   
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    @if($homepopup)
        <div id="pup-up-container" class="mt-5" style="">
            <div id="pop-up" class="mt-3 p-3 border border-3 border-primary bg-light" style="">
                <button id='close-btn'>X</button>
                <div class="text-center">
                    <img src="/storage/{{$homepopup->image}}" alt="" class="img img-fluid" style="max-height:320px; width:auto;">
                    <div class=" h5">{{$homepopup->title}}</div>
                </div>                
            </div>
        </div>

        <script>
            //homepage popup
            $(document).ready(function(){
    
                var stopAutohide;
        
                function showWindow(){
                    $('#pup-up-container').show();
                    // stop scroll
                    $('html body').css('overflow','hidden');
                    // auto hide fter 15s
                    stopAutohide = setTimeout(hideWindow,15000);
        
                }
                //showWindow()
    
                function hideWindow(){
                    $('#pup-up-container').hide();
                    // on scroll
                    $('html body').css('overflow-y','scroll');
                }
                //hideWindow()
    
                // now call function automatically after some time    
    
                // auto open after 2s
                setTimeout(showWindow,2000);
        
                // close after click 
        
                $("#close-btn").click(function(){
        
                    hideWindow();
                    celarTimeout(stopAutohide);    
                })    
            })
        </script>
    @endif

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "255614494928169");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    {{-- for messenger plugin --}}
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v16.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

@endsection

