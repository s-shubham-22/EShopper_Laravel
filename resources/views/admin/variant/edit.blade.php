@extends('admin.layouts.app')

@section('title', 'Variant')

@section('heading', 'Edit Variant')
    
@section('content')
<div class="d-flex justify-content-end">
    <a href="{{ route('variant.show', $variant->product_id) }}">
        <button class="btn btn-primary mb-4">Back</button>
    </a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Variant</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('variant.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="color">Color <strong class="text-danger">*</strong></label>
                <input type="color" value="{{ $variant->color }}" name="color" id="color" class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="size">Size <strong class="text-danger">*</strong></label>
                <input type="text" value="{{ $variant->size }}" name="size" id="size" class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="price">Price <strong class="text-danger">*</strong></label>
                <input type="number" value="{{ $variant->price }}" min="0" name="price" id="price" class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="sale_price">Sale Price <strong class="text-danger">*</strong></label>
                <input type="number" value="{{ $variant->sale_price }}" min="0" name="sale_price" id="sale_price" class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity <strong class="text-danger">*</strong></label>
                <input type="number" value="{{ $variant->quantity }}" min="0" name="quantity" id="quantity" class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="image">Variant Image <strong class="text-danger">*</strong></label>
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