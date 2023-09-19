@extends('layout.app')
@section('script')
<script>
    const sendMsg = () => {
      $.ajax({
          url: "http://127.0.0.1:8000/send-notif", // Replace with your API endpoint
          type: "POST",
          dataType: "json",
          data: JSON.stringify({
            _token: "{{csrf_token()}}",
            message: $('#message').val(),
            email: $('#email').val(),
            id: "{{$news->id}}"
          }),
          contentType: "application/json",
          success: function(data) {
            console.log(data)
              // $("#result").html(JSON.stringify(data));
          },
          error: function(xhr, status, error) {
              console.error("Error: " + error);
          }
      });
    }
</script>
@endsection
@section('content')
<div>
    <h1 class="mb-3">{{ $news->title }}</h1>
    <p>{{ $news->paragraph }}</p>
</div>

<p>Komentar</p>

<div class="row">
    <div id="card-for-message" class="col-12 col-md-6 overflow-y-auto pe-3 example" style="max-height: 400px !important">
        @if($comment)
            @foreach ($comment as $item)
            <div class="card mb-3 p-4" style="max-width: 540px; max-height: 500px;">
                <div class="my-2">
                    <div class="d-flex justify-start align-center">
                        <img class="me-2" src="{{asset('icons/profile.png')}}" width="24" height="24" />
                        <p>{{$item->email}}</p>
                    </div>
                    <p>{{$item->message}}</p>  
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="col-12 col-md-6">
        <div class="my-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" name="message" id="message" rows="3"></textarea>
        </div>
        <button type="button" class="btn btn-primary" onclick="sendMsg()">send</button>
    </div>
</div>
@endsection