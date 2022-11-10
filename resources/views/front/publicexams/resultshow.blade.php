@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$exam->name}} Results</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/results">Results</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$exam->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page">
        <div class="container">
            <div>TQ= Total Question, LQ= Leaved Questions, CQ= Correct Questions, WQ= Wrong Questions, MO= Marks Obtained</div>
            <div class="public-exam-section table-responsive">
                <table class="table table-bordered" id="table-courses">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>TQ</th>
                        <th>LQ</th>
                        <th>CQ</th>
                        <th>WQ</th>
                        <th>MO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach ($results as $result)
                        <tr>
                        <td>{{ $result->id }}</td>
                        <td>{{ $result->name }}</td>
                        <td>{{ $result->total_questions ?? '' }}</td>
                        <td>{{ $result->leaved_questions ?? '' }} </td>
                        <td>{{ $result->correct_questions ?? '' }} </td>
                        <td>{{ $result->wrong_questions ?? '' }} </td>
                        <td>{{ ($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))}} </td>
                        </tr>
                        @php($i++)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection