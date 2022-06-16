@extends('admin.layouts.app')

@section('title', 'Product')

@section('heading', 'Edit Product')
    
@section('content')
<div class="d-flex justify-content-end">
    <a href="{{ route('product.index') }}">
        <button class="btn btn-primary mb-4">Back</button>
    </a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Product</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Product Title <strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" value="{{ $product->name }}" id="name" name="name" aria-describedby="emailHelp" required="">
            </div>
            <div class="form-group">
                <label for="category_id">Category <strong class="text-danger">*</strong></label>
                <select name="category_id" id="category_id" class="form-control" required="">
                    @foreach ($categories as $category)
                        @if ($category->id == $product->category_id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="brand_id">Brand <strong class="text-danger">*</strong></label>
                <select name="brand_id" id="brand_id" class="form-control" required="">
                    @foreach ($brands as $brand)
                        @if ($brand->id == $product->brand_id)
                            <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                        @else
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description  <strong class="text-danger">*</strong></label>
                <textarea name="description" id="description" class="form-control" required="">{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="full_description">Full Description <strong class="text-danger">*</strong></label>
                <textarea name="full_description" id="full_description" class="form-control" required="">{{ $product->full_description }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Product Image <strong class="text-danger">*</strong></label>
                <input type="file" class="form-control-file" id="image" name="image">
                <br><img id="preview_img" src="" alt="your image" width="150px" hidden="hidden"><br>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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