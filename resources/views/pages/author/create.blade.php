@extends('layout.dashboard')
@section('script')
    <script src="{{asset('assets/vendor/ckeditor5/build/ckeditor.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const previewTags = (e) => {
            let tagString = e.target.value;
            let tags = tagString.split(',');
            let modifiedTags = tags.map(item => '#' + item);
            let elmTag = document.getElementById('item-tags');
            let parentTags = document.getElementById('tags-preview').classList.remove("d-none")
            console.log('oke', elmTag)
            for (let i = 0; i < modifiedTags.length; i++) {
                console.log(modifiedTags[i])
                elmTag.innerHTML += `
                    <button class="btn btn-outline-primary me-2" disabled="true">${modifiedTags[i]}</button>
                `
            }
        }
    </script>
@endsection
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .ck-content {
            min-height: 300px !important;
        }
        .ck-body-wrapper {
            display: none !important;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <form method="POST" action="{{ url('/author/create-content') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input class="form-control" name="title" type="text" id="title" required>
        </div> 
        <div class="mb-3">
            <label for="formFile" class="form-label">Add Thumbnail Image</label>
            <input class="form-control" name="img_thumb" type="file" id="formFile" onchange="fileRead(event)">
        </div> 
        <div id="img-preview" class="mb-3 d-none">
            <div class="w-100 d-flex justify-content-center">
                <img width="400px" id="preview" height="300px" src="" alt="">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Select category</label>
            <select class="form-select" name="category_id">
                <option selected>Open this select menu</option>
                @foreach ($category as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Tags</label>
            <input class="form-control" name="tags" type="text" id="tags" placeholder="example: tags1,tags2,tags3,....." onchange="previewTags(event)">
        </div> 
        <div id="tags-preview" class="mb-3 d-none">
            <div id="item-tags" class="w-100 d-flex justify-content-start"></div>
        </div>
        <div class="mb-3">
            <label for="editorText" class="form-label">Write your content!</label>
            <textarea id="editor" name="paragraph"></textarea>
        </div>
        <div class="mb-3 w-100 d-flex justify-content-start">
            <button type="submit" class="btn btn-success text-light me-2">Save</button>
            <button class="btn btn-danger text-light" onclick="save(false)">Cancel</button>
        </div>
    </form>
</div>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                image: {
                    upload: {
                        // Replace with the actual URL to your image upload route
                        url: '/upload-image',
                    },
                }
            })
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script>
        function fileRead(e) {
            const [ File ] = e.target.files
            let fileRead = new FileReader();
            
            fileRead.onload = () => {
                let result = fileRead.result
                $("#img-preview").removeClass("d-none");
                $("#preview").attr("src", result);
            }
            fileRead.readAsDataURL(File);
        }

        function save(decission) {
            $("#img-preview").addClass("d-none");
            $("#preview").attr("src", '');

            if (!decission) {
                $("#formFile").val('');
            }
        }
        // $("#formFile").change(async (e) => {
        // })
    </script>
@endsection