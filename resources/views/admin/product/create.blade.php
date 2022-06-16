@extends('admin.layouts.app')

@section('title', 'Product')

@section('heading', 'Add Product')

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
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Product Title <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" aria-describedby="emailHelp" required="">
                </div>
                <div class="form-group">
                    <label for="color">Color <strong class="text-danger">*</strong></label>
                    <input type="color" name="color" id="color" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="size">Size <strong class="text-danger">*</strong></label>
                    <input type="text" name="size" id="size" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="price">Price <strong class="text-danger">*</strong></label>
                    <input type="number" name="price" min="0" id="price" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="sale_price">Sale Price <strong class="text-danger">*</strong></label>
                    <input type="number" name="sale_price" min="0" id="sale_price" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity <strong class="text-danger">*</strong></label>
                    <input type="number" name="quantity" min="0" id="quantity" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="category_id">Category <strong class="text-danger">*</strong></label>
                    <select name="category_id" id="category_id" class="form-control" required="">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand <strong class="text-danger">*</strong></label>
                    <select name="brand_id" id="brand_id" class="form-control" required="">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description  <strong class="text-danger">*</strong></label>
                    <textarea name="description" id="description" class="form-control" required="">{{old('description')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="full_description">Full Description <strong class="text-danger">*</strong></label>
                    <textarea name="full_description" id="full_description" class="form-control" required="">{{old('full_description')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Product Image <strong class="text-danger">*</strong></label>
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