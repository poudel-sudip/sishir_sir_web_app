@extends('student.layouts.app')
@section('student-title')
    Enrolled Course Batch Files
@endsection
@section('student-title-icon')
    <i class="far fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="card">
            <div class="card-body text-center">
                <div class="h4 text-primary"> {{optional($batch->course)->name}} </div>
                <div class="h5 text-success"> {{$batch->name}} </div>
                <hr class="bg-danger">
                <div class="mt-4 row align-items-stretch">                    
                    @forelse($files as $pdf)
                        <div class="col-md-3 col-6 my-1">    
                            <div class="border p-2 border-info" style="height: 100%">
                                <div style="cursor: pointer" role="button" class="file-view-btn" data-bs-toggle="modal" data-bs-target="#view_file" file-title="{{$pdf->fileTitle}}" file-url="{{$pdf->filePath}}" file-id="{{$pdf->id}}">
                                    <div class="h1 text-danger"><i class="far fa-file-pdf"></i></div>
                                    <h6>{{$pdf->fileTitle}}</h6>
                                </div>
                                <div class="text-primary small">By: {{$pdf->user_name}} <span>on {{$pdf->created_at}}</span></div>                                
                            </div>                              
                        </div>
                    @empty
                        <div class="col-md-3 my-2">No Files Found</div>
                    @endforelse

                </div>
            </div>
        </div>
        
    </div>

    {{-- for view file model start--}}
    <div class="modal fade" id="view_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="file-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="file-image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- for view file model end--}}
    
    <script>
        $(document).ready(function(){
            $('.file-view-btn').click(function(){
                
                //clear previous data
                $('#file-title').html('');
                $('#file-image').html('');

                let fid = $(this).attr('file-id');
                let ftitle = $(this).attr('file-title');
                let furl = $(this).attr('file-url');

                $('#file-title').html(ftitle);
                $('#file-image').append(
                    // '<iframe src="'+furl+'" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>'
                    `<object data="`+furl+`"
                    type="application/pdf"
                    width="100%"
                    height="450">
                        <iframe
                        src="`+furl+`"
                        width="100%"
                        height="100%"
                        style="border: none">
                            <p>
                                Your browser does not support PDFs.
                                <a href="`+furl+`">Download the PDF</a>
                            </p>
                        </iframe>
                    </object>`
                );
                
            });
        })
    </script>
@endsection
