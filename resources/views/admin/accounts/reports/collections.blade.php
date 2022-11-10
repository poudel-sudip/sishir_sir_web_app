@extends('admin.layouts.app')
@section('admin-title')
    Amount Collections
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Collections</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Collections</li>
                </ol>
            </nav>
        </div>

        <div class="row">
          <div class="col-md-12">
          <div class="card collections-container">

            <div class="card-body">
              <h4>Course Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Self / Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($courseCollection->cash) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($courseCollection->connectips) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($courseCollection->esewa)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($courseCollection->imepay)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($courseCollection->khalti)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Bank Transfer</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($courseCollection->bank) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Due Amount</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($courseCollection->due)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Total Collection</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($courseCollection->cash + $courseCollection->connectips + $courseCollection->esewa + $courseCollection->imepay + $courseCollection->khalti + $courseCollection->bank)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h4>Exam Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Self / Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($examCollection->cash) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($examCollection->connectips) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($examCollection->esewa)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($examCollection->imepay)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($examCollection->khalti)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Bank Transfer</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($examCollection->bank) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Due Amount</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($examCollection->due)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Total Collection</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($examCollection->cash + $examCollection->connectips + $examCollection->esewa + $examCollection->imepay + $examCollection->khalti + $examCollection->bank)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h4>Video Course Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Self / Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($videoCollection->cash) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($videoCollection->connectips) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($videoCollection->esewa)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($videoCollection->imepay)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($videoCollection->khalti)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Bank Transfer</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($videoCollection->bank) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Due Amount</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($videoCollection->due)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Total Collection</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($videoCollection->cash + $videoCollection->connectips + $videoCollection->esewa + $videoCollection->imepay + $videoCollection->khalti + $videoCollection->bank)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h4>E-Book Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Self / Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($ebookCollection->cash) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($ebookCollection->connectips) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($ebookCollection->esewa)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($ebookCollection->imepay)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($ebookCollection->khalti)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Bank Transfer</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($ebookCollection->bank) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Due Amount</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($ebookCollection->due)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Total Collection</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($ebookCollection->cash + $ebookCollection->connectips + $ebookCollection->esewa + $ebookCollection->imepay + $ebookCollection->khalti + $ebookCollection->bank)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h4>Accounts Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($AccountCollection->cash->income - $AccountCollection->cash->expense) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($AccountCollection->connectips->income - $AccountCollection->connectips->expense) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($AccountCollection->esewa->income - $AccountCollection->esewa->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($AccountCollection->imepay->income - $AccountCollection->imepay->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($AccountCollection->khalti->income - $AccountCollection->khalti->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Mega Bank</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($AccountCollection->megabank->income - $AccountCollection->megabank->expense) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Global Bank</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($AccountCollection->globalbank->income - $AccountCollection->globalbank->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h4>Vendor Collections</h4>
              <div class="row">
                @foreach($vendorCollection as $vendor)
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="survey-head text-dark ">{{ucwords($vendor->name)}}</p>
                      <p class="h6 text-center mt-1">Course:  Rs. <span class="text-primary"> {{number_format($vendor->course->verified)}}  </span> </p>
                      <p class="h6 text-center mt-1">Exam:  Rs. <span class="text-primary"> {{number_format($vendor->exam->verified)}}  </span> </p>
                      <p class="h6 text-center mt-1">Video:  Rs. <span class="text-primary"> {{number_format($vendor->video->verified)}}  </span> </p>
                      <p class="h6 text-center mt-1">E-Book:  Rs. <span class="text-primary"> {{number_format($vendor->ebook->verified)}}  </span> </p>
                    </div>
                  </div>
                </div>
                @endforeach

              </div>
            </div>


          </div>
        </div>
        

      </div>
    </div>

@endsection
