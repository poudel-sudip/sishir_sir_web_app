@extends('front.layouts.app')

@section('page_title', 'Discussion Forum')
@section('og-title', 'Discussion Forum')
@section('og-url', url('/discussion-forum'))

@section('content')
  <div class="container-fluid px-md-5">

    <div class="container text-center">
      <img src="/images/logo.png" alt="" class="img img-fluid" style="max-height: 80px;" />
    </div>

    <div class="container clearfix">    
      <div class="forum-chat">
        <div class="chat-header">  
          <div class="chat-about text-center">
            <div class="chat-with">
              <div class="text-center">
                <h3 class="dchl-title fs-3"> Discussion Forum </h3>
              </div>
            </div>
            <div class="">Hello Everyone! Thank you for joining our discussion forum. Should you have any questions or concerns regarding health loksewa, please don't hesitate to leave a comment and share images if necessary. We will be conducting live chats daily from 10:00 to 10:15 PM (15 minutes). Looking forward to engaging with you!</div>
          </div>
        </div> <!-- end chat-header -->
        
        <div class="chat-history" id="chat_history_block">
          <ul>
            @forelse($messages as $row)
              @if($row->user_id == auth()->user()->id)
                <li class="clearfix">
                  <div class="message-data align-right mb-2">
                    <span class="message-data-name" ><strong>{{$row->user->name ?? 'Anomyus'}}</strong></span>
                    <span class="message-data-time" >{{date('M j, Y, g:i A',strtotime($row->created_at))}}</span>
                    <span class="message-data-img" > <img src="/storage/{{$row->user->photo ?? ''}}" onerror="this.src='/images/student.jpg'"> </span>
                  </div>
                  <div class="message float-right other-message">
                    {!! $row->message !!}
                    <div class="align-right">
                      <i class="fa fa-trash text-danger" title="Delete Message" onclick="deleteMessage({{$row->id}});"></i>
                    </div>
                  </div>
                </li>
              @else
                <li class="clearfix">
                  <div class="message-data mb-2">
                    <span class="message-data-img"><img src="/storage/{{$row->user->photo ?? ''}}" onerror="this.src='/images/student.jpg'"></span>
                    <span class="message-data-name"><strong>{{$row->user->name ?? 'Anomyus'}}</strong></span>
                    <span class="message-data-time">{{date('M j, Y, g:i A',strtotime($row->created_at))}}</span>
                  </div>
                  <div class="message float-left my-message">
                    {!! $row->message !!}
                    @if(auth()->user()->role == 'Admin')
                      <div class="align-right">
                        <i class="fa fa-trash text-danger" title="Delete Message" onclick="deleteMessage({{$row->id}});"></i>
                      </div>
                    @endif
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
        <div class="">
          {{$messages->onEachSide(1)->links('paginator.bootstrap')}}
        </div>
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
    function deleteMessage(id)
    {
      if(confirm('Are You Sure You Want To Delete This Message?')){
        var params= {
          _token: "{{csrf_token()}}",
          _method: 'DELETE',
          mid: id,
        };
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "/discussion-forum");
        for(var key in params) {
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", key);
          hiddenField.setAttribute("value", params[key]);
          form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>

  <script>
    var chatHistory = document.getElementById("chat_history_block");
    chatHistory.scrollTop = chatHistory.scrollHeight + 120;
  </script>

@endsection


@section('page-footer-content')
  <script>
    document.body.oncontextmenu = null;
  </script>
@endsection