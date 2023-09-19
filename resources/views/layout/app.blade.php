<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
      Pusher.logToConsole = true;

      var pusher = new Pusher('877a1bdc219d2aab6bf3', {
      cluster: 'ap1',
      encrypted: true
      });

      var channel = pusher.subscribe('comment');
      channel.bind('sendComment', function(data) {
        $("#card-for-message").prepend(`
        <div class="card mb-3 p-4" style="max-width: 540px; max-height: 500px;">
            <div class="my-2">
                <div class="d-flex justify-start align-center">
                    <img class="me-2" src="{{asset('icons/profile.png')}}" width="24" height="24" />
                    <p>${data.message.email}</p>
                </div>
                <p>${data.message.msg}</p>  
            </div>
        </div>
        `)
      });
    </script>
    @yield('script')
    {{-- <style>
       /* Hide scrollbar for Chrome, Safari and Opera */
      .example::-webkit-scrollbar {
        display: none;
      }

      /* Hide scrollbar for IE, Edge and Firefox */
      .example {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
      } 
    </style> --}}
  </head>
  <body>
    <div class="container-fluid p-2 p-md-5">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>