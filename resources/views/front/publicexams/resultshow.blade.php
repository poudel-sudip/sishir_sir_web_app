@extends('front.layouts.app')
@section('page_title', 'Results: '.($exam->name))
@section('content')
    <div class="container-fluid px-md-5">
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
        <div class="container-fluid px-md-5">
            <div class="text-end"><span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span></div>
            <div>TQ= Total Question, FM= Full Marks, LQ= Leaved Questions, CQ= Correct Questions, WQ= Wrong Questions, MO= Marks Obtained</div>
            <div class="public-exam-section table-responsive">
                <table class="table table-bordered" id="table-coursess">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>TQ</th>
                        <th>FM</th>
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
                        <td class="text-wrap">{{ $result->id }}</td>
                        <td class="text-wrap">{{ $result->name }}</td>
                        <td class="text-wrap">{{ $result->total_questions ?? '' }}</td>
                        <td class="text-wrap">{{ ($result->total_questions * ($exam->exam->marks_per_question ?? 1)) }}</td>
                        <td class="text-wrap">{{ $result->leaved_questions ?? '' }} </td>
                        <td class="text-wrap">{{ $result->correct_questions ?? '' }} </td>
                        <td class="text-wrap">{{ $result->wrong_questions ?? '' }} </td>
                        <td class="text-wrap">{{ ($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))}} </td>
                        </tr>
                        @php($i++)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection