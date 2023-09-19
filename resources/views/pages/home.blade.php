@extends('layout.app')
@section('content')
  @foreach ($news as $item)
  <a href="{{ url('/news').'/'.$item->id }}">
    <div class="card mb-3" style="max-height: 300px;">
        <div class="row g-0">
        <div class="col-md-4">
            <img src="https://play-lh.googleusercontent.com/8LYEbSl48gJoUVGDUyqO5A0xKlcbm2b39S32xvm_h-8BueclJnZlspfkZmrXNFX2XQ" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <p class="card-text d-block overflow-hidden" style="max-height: 150px;">{{ $item->paragraph }}</p>
            <p class="card-text"><small class="text-body-secondary">{{ $item->created_at }}</small></p>
            </div>
        </div>
        </div>
    </div>
  </a>
  @endforeach
@endsection