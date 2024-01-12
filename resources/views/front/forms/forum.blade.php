@extends('front.layouts.app')

@section('page_title', 'Discussion Forum')
@section('og-title', 'Discussion Forum')
@section('og-url', url('/discussion-forum'))

@section('content')
  <div class="container-fluid px-md-5">
    <div class="row">
        <div class="col-md-12 etutor-breadcrumb text-center">
            <h2>Discussion Forum</h2>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Discussion Forum</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container clearfix">    
      <div class="forum-chat">
        <div class="chat-header">  
          <img src="/images/logo.png" alt="" />              
          <div class="chat-about">
            <div class="chat-with">Discussion Forum</div>
          </div>
          <i class="fa fa-star d-none d-md-block"></i>
        </div> <!-- end chat-header -->
        
        <div class="chat-history" id="chat_history_block">
          <ul>
            @forelse($messages as $row)
              @if($row->user_id == auth()->user()->id)
                <li class="clearfix">
                  <div class="message-data align-right mb-2">
                    <span class="message-data-time" >{{date('g:i A, M j, Y',strtotime($row->created_at))}}</span>
                    <span class="ms-2 message-data-name" ><strong>{{$row->user->name ?? 'Anomyus'}}</strong></span>
                    
                  </div>
                  <div class="message other-message float-right">
                    {!! $row->message !!}
                  </div>
                </li>
              @else
                <li>
                  <div class="message-data mb-2">
                    <span class="message-data-name"><strong>{{$row->user->name ?? 'Anomyus'}}</strong></span>
                    <span class="message-data-time">{{date('g:i A, M j, Y',strtotime($row->created_at))}}</span>
                  </div>
                  <div class="message my-message">
                    {!! $row->message !!}
                  </div>
                </li>   
              @endif
            @empty
              <li>
                <h5 class="text-center mt-5">You Can Start The Forum Discussion Here...</h5>
              </li>
            @endforelse           
            
          </ul>
          
        </div> <!-- end chat-history -->
        
        <div class="chat-message clearfix">
          <form action="/discussion-forum" method="POST" enctype="multipart/form-data">
            @csrf()
            <textarea class="@error('message') is-invalid @enderror" name="message" id="message" placeholder ="Type your message" rows="3" required autofocus>{{old('message')}}</textarea> 
            @error('message')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror    
            <label for="post_image" class="mt-2 @error('post_image') is-invalid @enderror"><i class="fa fa-file-image"></i> Add Image</label>
            @error('post_image')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            <input type="file" name="post_image" id="post_image" class="d-none" value="{{old('post_image')}}" accept="image/x-png,image/jpeg">
            <button type="submit">Send</button>
          </form>
        </div> <!-- end chat-message -->
        
      </div> <!-- end chat -->
            
    </div> <!-- end container -->
                
  </div>

  <script>
    var chatHistory = document.getElementById("chat_history_block");
    chatHistory.scrollTop = chatHistory.scrollHeight + 120;
  </script>

@endsection
