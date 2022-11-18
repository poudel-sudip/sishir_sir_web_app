@extends('admin.layouts.app')
@section('admin-title')
    Batch Exam Results
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Results | {{$exam->name}} | {{$batch->name}} </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
              <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/exams">Exams</a></li>
              <li class="breadcrumb-item active" aria-current="page">Results</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Results | {{$exam->name}} | {{$batch->name}}</h4>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Student Name</th>
                            <th>Total Questions</th>
                            <th>Leaved Questions</th>
                            <th>Correct Questions</th>
                            <th>Wrong Questions</th>
                            <th>Marks Obtained</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach ($results as $result)
                          <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $result->user->name ?? '' }}</td>
                            <td>{{ $result->total_questions ?? '' }}</td>
                            <td>{{ $result->leaved_questions ?? '' }} </td>
                            <td>{{ $result->correct_questions ?? '' }} </td>
                            <td>{{ $result->wrong_questions ?? '' }} </td>
                            <td>{{ ($result->correct_questions * $exam->marks_per_question)-($result->wrong_questions*$exam->negative_marks)}} </td>
                            <td>{{ date('Y-m-d',strtotime($result->created_at))}} </td>                           
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
