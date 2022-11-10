@extends('vendors.layouts.app')
@section('admin-title')
    Filtered Leads & Enquiries
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Filtered Leads/Enquiries</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/vendor/enquiries') }}">Enquiries</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filtered</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Filter Enquiries</h4>
                        <form method="POST" action="/vendor/enquiries/filter" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label text-right">{{ __('Filter By Course Name') }} </label>
                                
                                <div class="col-md-8">
                                    <select name="course" id="course" class="form-control @error('course') is-invalid @enderror" required>
                                        <option value="">Select a Course</option>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        @if(count($enquiries))
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Leads/Enquiries of : {{$coverageArea ?? ''}}</h4>
                        <h4 class="card-title">Course : {{$filterValue}}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Provience</th>
                                        <th>District</th>
                                        <th>Course</th>
                                        <th>Message</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($enquiries as $enquiry)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap">{{date("Y-m-d",strtotime($enquiry->created_at))}}</td>
                                        <td class="text-wrap">{{$enquiry->name}}</td>
                                        <td class="text-wrap">{{$enquiry->email}}</td>
                                        <td class="text-wrap">{{$enquiry->contact}}</td>
                                        <td class="text-wrap">{{$enquiry->provience}}</td>
                                        <td class="text-wrap">{{$enquiry->district}}</td>
                                        <td class="text-wrap">{{$enquiry->course->name ?? ''}}</td>
                                        <td class="text-wrap">{!! $enquiry->message !!}</td>
                                        <td class="text-wrap">{!! $enquiry->remarks !!}</td>

                                        <td><a href="/vendor/enquiries/{{$enquiry->id}}/edit">Edit</a> </td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>  
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif

    </div>
@endsection
