@extends('layouts.app')

@section('title', 'Shop')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('frontend/css/double_range_slider.css') }}">
@endsection()

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <form id="filter-container">
            <!-- Price Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                <section class="range-slider mx-auto" id="price-slider">
                    <span class="output outputOne"></span>
                    <span class="output outputTwo">1000</span>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input name="minPrice" value="0" min="0" max="1000" step="1" type="range">
                    <input name="maxPrice" value="1000" min="0" max="1000" step="1" type="range">
                </section>
            </div>
            <!-- Price End -->
            
            <!-- Color Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                    @foreach ($colors as $paramName => $paramValue)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input class="custom-control-input" type="checkbox" name="colors[]" id="color-{{$paramName}}" value="{{$paramName}}">
                            <label class="custom-control-label" for="color-{{$paramName}}"><span style="display: inline-block; height:15px; width:15px; background-color:{{$paramName}}; border-radius:3px;"></span></label>
                        </div>
                    @endforeach
            </div>
            <!-- Color End -->

            <!-- Size Start -->
            <div class="mb-5">
                <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                    @foreach ($sizes as $paramName => $paramValue)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input class="custom-control-input" type="checkbox" name="sizes[]" id="size-{{$paramName}}" value="{{$paramName}}">
                            <label class="custom-control-label" for="size-{{$paramName}}">{{$paramName}}</label>
                        </div>
                    @endforeach
            </div>
            <!-- Size End -->
            </form>
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3 product-list">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div></div>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Sort by
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" onclick="sortProducts('latest');" href="#">Latest</a>
                                <a class="dropdown-item" onclick="sortProducts('pricel2h');" href="#">Price Low to High</a>
                                <a class="dropdown-item" onclick="sortProducts('priceh2l');" href="#">Price High to Low</a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($products as $product)
                <a class="col-lg-4 col-md-6 col-sm-12 pb-1 product-item" id="{{ $product->id }}" href="{{ route('shop_detail', $product->slug) }}">
                    <div class="card border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('uploads/product/'.$product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                @if ( $product->variants->count() > 1 )
                                    <h6>$ {{ $product->variants->min('sale_price') }} - $ {{ $product->variants->max('sale_price') }}</h6>
                                @else
                                    <h6>$ {{ $product->variants->max('sale_price') }}</h6><h6 class="text-muted ml-2"><del>$ {{ $product->variants->max('price') }}</del></h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
@endsection()

@section('script')
<script src="{{ asset('frontend/js/double_range_slider.js') }}"></script>

<script>
    function sortProducts(sort) {
        var ids = [];
        $('.product-item').each(function() {
            ids.push($(this).attr('id'));
        });
        $.ajax({
            url: "{{ route('sort_products') }}",
            type: 'POST',
            data: {
                ids: ids,
                sort: sort,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // console.log(data.html);
                $('.product-item').remove();
                $('.product-list').append(data.html);
            }
        });
    }
    
    $('#filter-container').mouseup(function() {
        setTimeout(() => {
            var ids = [];
            $('.product-item').each(function() {
                ids.push($(this).attr('id'));
            });
            $.ajax({
                url: "{{ route('filter_products') }}",
                type: 'POST',
                data: $('#filter-container').serialize() + '&ids=' + ids + '&_token=' + $('meta[name="csrf-token"]').attr('content'),
                success: function(data) {
                    // console.log(data.html);
                    $('.product-item').remove();
                    $('.product-list').append(data.html);
                }
            });
        }, 500);
    })
</script>
@endsection()