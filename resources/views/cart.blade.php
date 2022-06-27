@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="/">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shopping Cart</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Sale Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle" id="cart-table-body">
                    @php
                        $sum = 0;
                    @endphp
                    @if ($carts->count() == 0)
                        <td colspan="5">No Products in Cart</td>
                    @endif
                    @foreach ($carts as $cart)
                    <tr id="row-{{ $cart->variant_id }}" class="cart-product-row">
                        <td class="align-middle"><img src="{{ asset('uploads/variant/').'/'.$cart->variant->image }}" alt="" style="width: 50px;"> {{ $cart->product->name }} ( <span style="display: inline-block; height:15px; width:15px; background-color:{{$cart->variant->color}}; border-radius:3px;"></span> , {{ $cart->variant->size }} )</td>
                        <td class="align-middle" id="price-{{ $cart->variant_id }}">${{ $cart->variant->sale_price }}</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 110px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary btn-minus" id="{{ $cart->variant->id }}">
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text"  style="display:inline-block; width:10px;" onchange="change_quantity({{ $cart->variant_id }})" class="form-control form-control-sm bg-secondary text-center quantity_ad" id="quantity-{{ $cart->variant_id }}" value="{{ $cart->quantity }}">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary btn-plus" id="{{ $cart->variant->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle total-price" id="total-{{ $cart->variant_id }}">${{ $cart->variant->sale_price * $cart->quantity }}</td>
                        @php
                            $sum += $cart->variant->sale_price * $cart->quantity;
                        @endphp
                        <td class="align-middle"><button type="button" onclick="delete_product({{ $cart->id }}, {{ $cart->variant->id }});" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                        {{-- <td class="align-middle"><form action="{{ route('cart.destroy', $cart->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-times"></i>
                            </button>
                        </form></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium" id="subtotal">$ @php
                            echo $sum;
                        @endphp</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$0</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold" id="total">$@php
                            echo $sum;
                        @endphp</h5>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('script')
    <script>
        // function isvalidated(id){
        //     console.log(($.isNumeric($('#quantity-'+id).val())) && ($.isNumeric($('#quantity-'+id).val()) > 0));
        //     if(!$.isNumeric($('#quantity-'+id).val())){
        //         alert("Please enter numbers");
        //         return false;   
        //     } 
        // }

        function getTotal() {
            var sum = 0;
            $('.total-price').each(function(index) {
                sum += parseInt($(this).text().replace('$', ''));
            });
            
            $('#subtotal').text('$'+sum);
            $('#total').text('$'+sum);
        }

        function change_quantity(id) {
            var quantity = $('#quantity-'+id).val();
            if(!$.isNumeric(quantity) || parseInt(quantity) < 0) {
                toastr.error('Invalid Quantity! Please Try Again!');
            } else {
                $.ajax({
                    url: 'cart/change-quantity/',
                    type: 'POST',
                    data: {
                        id: id,
                        quantity: quantity,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        toastr.options.timeOut = 2000;
                        if(data.status == 'success') {
                            if(data.quantity > 0) {
                                $('#quantity-'+id).val(data.quantity);
                                var price = '$' + parseInt(data.quantity) * parseInt($('#price-'+id).text().replace('$', ''));
                                $('#total-'+id).text(price);
                                getTotal();
                                toastr.success('Quantity Updated Successfully!');
                            } else {
                                $('#row-'+id).remove();
                                if($('.cart-product-row').length == 0){
                                    $('#cart-table-body').html('<td colspan="5">No Products in Cart</td>');
                                }
                                toastr.success('Product Removed From Cart Successfully!');
                            }
                            var sum = 0;
                            $('.quantity_ad').each(function() {
                                sum += parseInt($(this).val());
                            });
                            $('#cart-quantity-badge').text(sum);
                        } else {
                            toastr.error('Product Quantity is Not Updated in Cart! Please Try Again!');
                        }
                    }
                });
            }           
        }

        function delete_product(id, variant_id) {
            if(confirm('Do you want to delete this item from your Cart?'))
            {
                $.ajax({
                    url: 'cart/'+id,
                    type: 'DELETE',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        toastr.options.timeOut = 2000;
                        if (data.success) {
                            $('#row-'+variant_id).remove();
                            if($('.cart-product-row').length == 0){
                                $('#cart-table-body').html('<td colspan="5">No Products in Cart</td>');
                            }
                            var sum = 0;
                            $('.quantity_ad').each(function() {
                                sum += parseInt($(this).val());
                            });
                            $('#cart-quantity-badge').text(sum);
                            getTotal();
                            toastr.success(data.success);
                        } else {
                            toastr.error(data.error);
                        }
                    }
                });
            }
        }
    </script>
@endsection