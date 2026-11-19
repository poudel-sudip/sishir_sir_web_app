@extends('admin.layouts.app')
@section('admin-title')
  Batch MCQ Exam Lists
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> {{$batch->name}} | MCQ Exams </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
          <li class="breadcrumb-item active" aria-current="page">MCQ Exams</li>
        </ol>
      </nav>
    </div>  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title"> {{$batch->name}} | {{$unit ? $unit->name.' | ' : '' }} MCQ Exams</h4>
              <div class="text-right">
                <button type="button" class="btn btn-info m-2" data-toggle="modal" data-target="#create_folder">
                  <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                  <span class="file-upload-hover">Add New Folder</span>
                </button>
                <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/create?unit_id={{$unit->id ?? ''}}"><button type="button" class="btn btn-sm ml-3 btn-success"> Associate MCQ Exam </button></a>
              </div>
            </div>
            <div class="my-2">
              <div class="mt-4 row align-items-stretch">
                @foreach($units as $cat)
                  <div class="col-md-3 col-6 my-3">
                    <div>
                      <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/unit/{{$cat->id}}" class="h1"><i class="fa fa-folder-open text-primary"></i></a>
                    </div>
                    <div class="h5">
                      <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/unit/{{$cat->id}}" style="color:inherit;">{{($cat->name)}}</a>
                    </div>
                    <div>
                      <a class="edit-folder btn-sm btn-info" href="#edit_folder" folder-name="{{$cat->name}}"  folder-id="{{$cat->id}}" data-toggle="modal" data-target="#edit_folder">Edit</a>
                      <form class="d-inline" id="delete-unit-{{$cat->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/unit/{{$cat->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="parent" value={{$unit->id ?? null}}>
                        <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData('delete-unit-{{$cat->id}}');" title="Delete">Delete</a>
                      </form>
                    </div>
                  </div>
                      
                @endforeach
              </div>

              @if($mcq_exams->isEmpty() && $units->isEmpty())
                <div class="text-center">
                  <h4 class="text-danger">Mcq Exams Not Found</h4>
                </div>
              @endif
            </div>

            @if($mcq_exams->count())
              <div class="table-responsive table-responsive-md">
                <table class="table table-bordered" id="advanced-desc-table">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Exam Name</th>
                      <th>Time(HH:MM:SS)</th>
                      <th>Questions</th>
                      <th>CQCs</th>
                      <th>Is Final Exam</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mcq_exams as $key=>$exam)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $exam->exam->name ?? '' }}</td>
                        <td>{{ $exam->exam->exam_time.':00' ?? '' }} </td>
                        <td> <a href="/admin/exams/{{$exam->exam->id}}/questions"> Questions({{ $exam->exam->questions()->count() }}) </a></td>
                        <td> <a href="/admin/exams/{{$exam->exam->id}}/cqcs" class="@if($exam->exam->cqc_unread()->exists()) text-danger @endif"> CQCs({{ $exam->exam->cqcs()->count() }}) </a></td>
                        <td>{{ $exam->is_final_exam ? 'Yes' : 'No' }} </td>
                        
                        <td class="classroom-btn" width="100">
                          
                          <form id="delete-form-{{$exam->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/{{$exam->id}}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:{}" onclick="javascript:deleteData('delete-form-{{$exam->id}}');" class="btn btn-warning">Delete</a>
                          </form>
                          <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/{{$exam->exam->id}}/results" class="btn btn-primary">Results</a>
                        </td>
                        
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
    
  {{-- for unit create model start--}}
  <div class="modal fade" id="create_folder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Folder</h5>
          <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-danger">&times;</span>
          </button>
        </div>

        <div class="modal-body enroll_form">
          <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/unit" enctype="multipart/form-data">
            @csrf

            <div class="form-group row my-0">
              <label for="folder_unit_id" class="col-md-4 col-form-label text-md-right">{{ __('Parent Unit Id') }}</label>

              <div class="col-md-8">
                <input id="folder_unit_id" type="text" class="form-control @error('folder_unit_id') is-invalid @enderror" name="folder_unit_id" value="{{ old('folder_unit_id') ?? $unit->id ?? null }}" readonly>

                @error('folder_unit_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="folder_name" class="col-md-4 col-form-label text-md-right">{{ __('Folder Name') }}</label>

              <div class="col-md-8">
                <input id="folder_name" type="text" class="form-control @error('folder_name') is-invalid @enderror" name="folder_name" value="{{ old('folder_name') }}" autofocus>

                @error('folder_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
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
  {{-- for unit create model end--}}

  {{-- Unit Edit Modal HTML --}}
  <div id="edit_folder" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Edit Folder </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/unit" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group row my-0">
              <label for="folder_id" class="col-md-3 col-form-label">{{ __(' Folder ID') }}</label>

              <div class="col-md-9">
                <input id="folder_id" type="text" class="form-control @error('folder_id') is-invalid @enderror" name="folder_id" value="{{ old('folder_id') }}" required readonly>

                @error('folder_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            
            <div class="form-group row my-0">
              <label for="folder_title" class="col-md-3 col-form-label">{{ __(' Folder Name') }}</label>

              <div class="col-md-9">
                <input id="folder_title" type="text" class="form-control @error('folder_title') is-invalid @enderror" name="folder_title" value="{{ old('folder_title') }}" required autofocus>

                @error('folder_title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>


            <div class="form-group row my-0">
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
  {{-- Unit Edit Modal HTML end --}}

  <script type="text/javascript">
   
    function deleteData(id)
    {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(id).submit();
          Swal.fire(
            'Deleted!',
            'Your record has been deleted.',
            'success'
          )
        }
      })
    }
  </script>

  <script>
    // this script is used to prompt edit model
    $(document).ready(function(){
      $('.edit-folder').click(function(){
        //clear previous data
        $('#folder_id').attr('value','');
        $('#folder_title').attr('value','');

        //fetch current data
        let fid = $(this).attr('folder-id');
        let ftitle = $(this).attr('folder-name');

        //set the value to edit model
        $('#folder_id').attr('value',fid);
        $('#folder_title').attr('value',ftitle);

      });
    });
  </script>
      
@endsection
