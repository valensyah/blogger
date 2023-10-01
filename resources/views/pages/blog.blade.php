@extends('layout.app')
@section('style')
    <style>
        div>figure>img {
            max-width: 500px !important;
            max-height: 350px !important;
        }
        div>figure {
            width: 100% !important;
            display: flex !important;
            flex-direction: column;
            place-items: center !important;
            /* justify-content: center !important; */
            margin-top: 5%;
            margin-bottom: 3%;
        }
    </style>
@endsection
@section('script')
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('877a1bdc219d2aab6bf3', {
    cluster: 'ap1',
    encrypted: true
    });

    var channel = pusher.subscribe('comment');
    channel.bind('sendComment', function(data) {
        console.log(data.message.time)
      $("#card-for-message").prepend(`
      <div class="card mb-3 p-4" style="max-width: 540px; max-height: 500px;">
          <div class="my-2">
              <div class="d-flex justify-start align-center">
                  <img class="me-2" src="{{asset('icons/profile.png')}}" width="24" height="24" />
                  <p>${data.message.email}</p>
              </div>
              <div class="d-flex justify-content-between align-center">
                  <p>${data.message.msg}</p>  
                  <p>${data.message.time}</p>
              </div>
          </div>
      </div>
      `)
    });
  </script>
<script>
    $(document).ready(function() {
        let figure = document.getElementsByTagName("figure");
        // let thumb = figure[0].getElementsByTagName("img");
        figure[0].innerHTML += `<p>{{$news->created_at->format('F j, Y')}}</p>`
    })


    const sendMsg = () => {
      $.ajax({
          url: "http://localhost:8000/send-notif", // Replace with your API endpoint
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
    <p>{!! $news->paragraph !!}</p>
</div>

<hr class="my-5 w-50 mx-auto">

<p class="fw-bold">Komentar</p>

<div class="row">
    <div id="card-for-message" class="col-12 col-md-6 overflow-y-auto pe-3 example" style="max-height: 400px !important">
        @if(count($comment) > 0)
            @foreach ($comment as $item)
            @php
                $colors = [
                    'bg-primary', 
                    'bg-primary', 
                    'bg-secondary', 
                    'bg-secondary', 
                    'bg-success', 
                    'bg-success', 
                    'bg-danger', 
                    'bg-danger', 
                    'bg-warning', 
                    'bg-warning', 
                    'bg-info', 
                    'bg-info', 
                    'bg-light', 
                    'bg-light-subtle', 
                    'bg-dark', 
                    'bg-dark-subtle'
                ];

                // Get a random index from the array
                $randomIndex = array_rand($colors);

                // Use the random index to get the random value
                $randomValue = $colors[$randomIndex];
            @endphp
            <div class="card mb-3 px-4 py-2{{' '.$randomValue}} {{(str_contains($randomValue, 'light')) ? 'text-dark' : 'text-light'}}" style="max-width: 540px; max-height: 500px;">
                <div class="my-2">
                    <div class="d-flex justify-start align-center">
                        <img class="me-2" src="{{asset('icons/profile.png')}}" width="24" height="24" />
                        <p>{{$item->email}}</p>
                    </div>
                    <div class="d-flex justify-content-between align-center">
                        <p class="m-0 p-0">{{$item->message}}</p>   
                        <p class="m-0 p-0">{{ (str_contains($item->time, 'week')) ? $item->created_at : str_replace('after', 'ago', $item->time) }}</p> 
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="mx-auto my-auto text-dark">
            Belum ada komentar
        </div>
        @endif
    </div>
    <div class="col-12 col-md-6">
        <div class="my-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" name="message" id="message" rows="3"></textarea>
        </div>
        <button type="button" class="btn btn-primary" onclick="sendMsg()">send</button>
    </div>
</div>
@endsection