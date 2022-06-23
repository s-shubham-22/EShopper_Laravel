@extends('layouts.app')

@section('title', 'Shop Detail')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="/">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop Detail</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div>
                <div class="carousel-inner border"> 
                    <div class="carousel-item active">
                        <img class="w-100 h-100" id="productImage" src="{{ asset('uploads/variant/'.$product->variants->first()->image) }}" alt="Image">
                    </div>
                </div>
                {{-- <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a> --}}
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <div class="d-flex justify-content-left">
                <h3 class="font-weight-semi-bold mb-2" id="sale_price">${{ $product->variants->first()->sale_price }}</h3>
                <h3 class="font-weight-semi-bold mb-2 text-muted ml-3"><del id="price">${{ $product->variants->first()->price }}</del></h3>
            </div>
            <p class="mb-4">{{ $product->description }}</p>
            <form action="{{ route('cart.store') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ isset(Auth::user()->id) ? Auth::user()->id : '' }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                <input type="hidden" name="price" value="{{ $product->variants->first()->sale_price }}">
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    @foreach($product->variants->groupBy('size')->pluck('0') as $variant)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" onclick="change_color({{$variant->id}});" class="custom-control-input" id="size-{{ $variant->id }}" name="size" {{ $loop->iteration == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="size-{{ $variant->id }}">{{ $variant->size }}</label>
                    </div>
                    @endforeach()
                </div>
                <div class="d-flex mb-3 color-group">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    @foreach (getColors($product->variants->first()) as $variant)
                        <div class="custom-control custom-radio custom-control-inline color">
                            <input type="radio" onclick="change_image({{$variant->id}});" class="custom-control-input" id="variant-{{ $variant->id }}" name="color" value="{{ $variant->id }}" {{ $loop->iteration == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="variant-{{ $variant->id }}"><span style="display: inline-block; height:15px; width:15px; background-color:{{$variant->color}}; border-radius:3px;"></span></label>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-minus" >
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" name="quantity" value="1">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p>{{ $product->full_description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Related Products</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach (getRelatedProducts($product->id) as $related_product)
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('uploads/product/'.$related_product->image) }}" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $related_product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            @if ( $related_product->variants->count() > 1 )
                                <h6>$ {{ $related_product->variants->min('sale_price') }} - $ {{ $related_product->variants->max('sale_price') }}</h6>
                            @else
                                <h6>$ {{ $related_product->variants->max('sale_price') }}</h6><h6 class="text-muted ml-2"><del>$ {{ $related_product->variants->max('price') }}</del></h6>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach      
            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@endsection

@section('script')
    <script>
        function change_color(id) {
            $.ajax({
                url: '/change-color/' + id,
                type: 'GET',
                success: function(data) {
                    if(data) {
                        $('.color').remove();
                        let output = '';
                        data.forEach((variant, index) => {
                            output += `
                            <div class="custom-control custom-radio custom-control-inline color">
                                <input type="radio" onclick="change_image(${variant.id});" class="custom-control-input" id="variant-${ variant.id }" name="color" value="${variant.id}" ${ index == 0 ? 'checked' : '' }>
                                <label class="custom-control-label" for="variant-${ variant.id }"><span style="display: inline-block; height:15px; width:15px; background-color:${variant.color}; border-radius:3px;"></span></label>
                            </div>
                            `
                        });
                        $('#productImage').attr('src', "{{ asset('uploads/variant/') }}" + '/' + data[0].image);
                        $('#sale_price').text('$'+data[0].sale_price);
                        $('#price').text('$'+data[0].price);
                        $("[name='variant_id']").val(data[0].id);
                        $("[name='price']").val(data[0].sale_price);
                        $("[name='size']").val(data[0].id);
                        $('.color-group').append(output);
                    }
                }
            });
        }

        function change_image(id) {
            $.ajax({
                url: '/change-image/' + id,
                type: 'GET',
                success: function(data) {
                    if(data) {
                        $('#productImage').attr('src', "{{ asset('uploads/variant/') }}" + '/' + data.image);
                        $('#sale_price').text('$'+data.sale_price);
                        $('#price').text('$'+data.price);
                        $("[name='variant_id']").val(data.id);
                        $("[name='price']").val(data.sale_price);
                        $("[name='size']").val(data.id);
                    }
                }
            });
        }
    </script>
@endsection()