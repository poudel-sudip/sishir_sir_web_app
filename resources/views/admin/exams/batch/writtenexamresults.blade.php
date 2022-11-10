@extends('admin.layouts.app')
@section('admin-title')
    Batch Written Exam Solutions
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$batch->name}} :-Question Solution Lists</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
              <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/written-exams">Written Exams</a></li>
              <li class="breadcrumb-item active" aria-current="page">Solutions</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">{{$exam->question}}</h4>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Student Name</th>
                            <th>Answer Date</th>
                            <th>Remarks</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach ($results as $result)
                          <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $result->user->name ?? '' }}</td>
                            <td>{{ date('Y-m-d',strtotime($result->created_at))}} </td>                           
                            <td>{{ $result->remarks ?? '' }} </td>
                            <td class="classroom-btn" width="160">
                              <a href="/admin/batches/{{$batch->id}}/written-exams/{{$exam->id}}/solutions/{{$result->id}}" class="btn btn-primary">View</a>
                            </td>                     
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
    </div>
    
@endsection
