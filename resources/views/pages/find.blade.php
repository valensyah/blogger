@extends('layout.app')
@section('style')
    <style>
      .paragraph {
        width: 100%; height: 80px; overflow-y: hidden; position: relative;
      }
    </style>
@endsection
@section('script')
    <script>
      const shadowEffect = (id) => {
        document.getElementById(`card-${id}`).classList.add("shadow");
      }

      const removeShadow = (id) => {
        document.getElementById(`card-${id}`).classList.remove("shadow");
      }
    </script>
@endsection
@section('content')
  {{-- <h1 class="fw-semibold mx-auto"></h1> --}}
  <div class="row p-4 p-md-0 p-sm-4">
    @foreach ($new as $item)
    <a class="col-12 col-sm-6 col-md-4" href="{{ url('/news').'/'.$item->id }}" style="text-decoration: none !important;">
      <div id="{{'card-'.$item->id}}" class="card mb-3" onmouseover="shadowEffect({{$item->id}})" onmouseout="removeShadow({{$item->id}})" style="min-height: 360px !important">
        <img src="{{ $item->img_thumb ? asset('storage/images/thumbnail').'/'.$item->img_thumb : 'https://play-lh.googleusercontent.com/8LYEbSl48gJoUVGDUyqO5A0xKlcbm2b39S32xvm_h-8BueclJnZlspfkZmrXNFX2XQ' }}" class="card-img-top" height="200" alt="...">
        <div class="card-body">
          <h5 class="card-title lh-sm fs-6 fw-semibold text-truncate">{{ $item->title }}</h5>
          <p class="card-text"><small class="text-body-secondary">{{ $item->created_at->format('F j, Y') }}</small></p>
          <p class="card-text text-body-secondary fw-semibold">By {{ $item->user->name }}</p>
          <div class="d-flex">
            <p class="text-info-emphasis text-truncate">{{ $item->tags ? $item->tags : '-' }}</p>
          </div>
        </div>
      </div>
    </a>
    @endforeach
  </div>
@endsection