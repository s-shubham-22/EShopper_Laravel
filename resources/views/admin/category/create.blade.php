@extends('admin.layouts.app')

@section('title', 'Category')

@section('heading', 'Category')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Category Title <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" aria-describedby="emailHelp" required="">
                </div>
                <div class="form-group">
                    <label for="image">Category Image <strong class="text-danger">*</strong></label>
                    <input type="file" class="form-control-file" value="{{ old('image') }}" id="image" name="image" required="">
                    <br><img id="preview_img" src="" alt="your image" width="150px" hidden="hidden"><br>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#image').change(function() {
            $('#preview_img').attr('hidden', false);
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
    </script>
@endsection