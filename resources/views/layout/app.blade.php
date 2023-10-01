<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    @yield('script')
    @yield('style')
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-primary">
      <div class="container-fluid px-2 px-md-5">
        <a class="navbar-brand text-light" href="#">Talkie</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active text-light" aria-current="page" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ url('/about') }}">About Us</a>
            </li>
            {{-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li> --}}
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ url('/policy') }}">Policy</a>
            </li>
          </ul>
          <form class="d-flex me-2 mb-4 mb-lg-0" role="search" method="get" action="{{url('/find')}}">
            <input class="form-control me-2" type="search" placeholder="Search by title/category" name="keyword" id="filter" aria-label="Search">
            <button class="btn btn-outline-light" type="submit" >Search</button>
          </form>
          @auth
          <div class="dropdown">
            <button class="btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="rounded-circle" width="32px" src="{{ Auth::user()->avatar ? Auth::user()->avatar : asset('icons/profile.png') }}" alt="">
              {{-- {{ Auth::user()->name }} --}}
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ url('/author') }}">Dashboard</a></li>
              <li><a class="dropdown-item" href="#">Setting</a></li>
              <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
            </ul>          
          </div>
          @else
          <a href="{{ url('/auth/google') }}" class="btn btn-light d-flex" style="text-decoration: none !important; width: fit-content !important" type="submit" >
            <img class="me-2" width="24px" src="{{ asset('icons/google.png') }}" alt="">
            Login
          </a>
          @endauth
        </div>
      </div>
    </nav>
    <div class="container-fluid p-4 p-md-5">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>