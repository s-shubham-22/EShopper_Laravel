@if ($carts->count() < 1)

@endif

@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="/">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div>
        <form action="{{ route('order') }}" method="post" class="row px-xl-5">
            <div class="col-lg-8">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input id="b_fname" value="{{ old('b_fname') }}" type="text" name="b_fname" class="form-control" type="text" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input id="b_lname" value="{{ old('b_lname') }}" type="text" name="b_lname" class="form-control" type="text" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input id="b_email" value="{{ old('b_email') }}" type="email" name="b_email" class="form-control" type="text" placeholder="Email ID" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input id="b_mobile" value="{{ old('b_mobile') }}" type="tel" name="b_mobile" class="form-control" type="text" placeholder="Mobile No." required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input id="b_addr_1" value="{{ old('b_addr_1') }}" type="text"  name="b_addr_1" class="form-control" type="text" placeholder="Address Line 1" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input id="b_addr_2" value="{{ old('b_addr_2') }}" type="text" name="b_addr_2" class="form-control" type="text" placeholder="Address Line 2" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select id="b_country" value="{{ old('b_country') }}" name="b_country" class="custom-select" required>
                                <option value="India" selected>India</option>
                                <option value="United States">United States</option>
                                <option value="Japan">Japan</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input id="b_city" value="{{ old('b_city') }}" type="text" name="b_city" class="form-control" type="text" placeholder="New York" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input id="b_state" value="{{ old('b_state') }}" type="text" name="b_state" class="form-control" type="text" placeholder="New York" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input id="b_zip" value="{{ old('b_zip') }}" type="tel" name="b_zip" class="form-control" type="text" placeholder="123" required maxlength="6" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="shipto" value=1 type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto">Ship to Same Address as Billing Address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input id="s_fname" value="{{ old('s_fname') }}" name="s_fname" class="form-control" type="text" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input id="s_lname" value="{{ old('s_lname') }}" name="s_lname" class="form-control" type="text" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input id="s_email" value="{{ old('s_email') }}" name="s_email" class="form-control" type="email" placeholder="Email ID" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input id="s_mobile" value="{{ old('s_mobile') }}" name="s_mobile" class="form-control" type="text" placeholder="Mobile No." required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input id="s_addr_1" value="{{ old('s_addr_1') }}" name="s_addr_1" class="form-control" type="text" placeholder="Address Line 1" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input id="s_addr_2" value="{{ old('s_addr_2') }}" name="s_addr_2" class="form-control" type="text" placeholder="Address Line 2" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select id="s_country" value="{{ old('s_country') }}" name="s_country" class="custom-select" required>
                                <option value="India" selected>India</option>
                                <option value="United States">United States</option>
                                <option value="Japan">Japan</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input id="s_city" value="{{ old('s_city') }}" name="s_city" class="form-control" type="text" placeholder="City" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input id="s_state" value="{{ old('s_state') }}" name="s_state" class="form-control" type="text" placeholder="State" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input id="s_zip" value="{{ old('s_zip') }}" name="s_zip" class="form-control" type="text" placeholder="ZIP Code" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <strong><p>Product Name</p></strong>
                            <strong><p>Quantity x Price = Total</p></strong>
                        </div>
                        @php
                            $sum_price = 0;
                        @endphp
                        @foreach ($carts as $cart)    
                        <div class="d-flex justify-content-between">
                            <div>{{ $loop->iteration }}. {{ $cart->product->name }} ( <span style="display: inline-block; height:15px; width:15px; background-color:{{$cart->variant->color}}; border-radius:3px;"></span> , {{ $cart->variant->size }} )</div>
                            <div>${{ $cart->variant->sale_price }} x {{ $cart->quantity }} = ${{ $cart->variant->sale_price * $cart->quantity }}</div>
                            @php
                                $sum_price += $cart->variant->sale_price * $cart->quantity;
                            @endphp
                        </div>
                        @endforeach
                        
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">${{ $sum_price }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$0</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">${{ $sum_price }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="cod" checked>
                                <label class="custom-control-label" for="cod">Cash On Delievery</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout End -->
@endsection

@section('script')
    <script>
        $('#shipto').change(function(){
            console.log($(this).is(':checked'));
            if($(this).is(':checked')){
                $('#s_fname').val($('#b_fname').val());
                $('#s_lname').val($('#b_lname').val());
                $('#s_email').val($('#b_email').val());
                $('#s_mobile').val($('#b_mobile').val());
                $('#s_addr_1').val($('#b_addr_1').val());
                $('#s_addr_2').val($('#b_addr_2').val());
                $('#s_city').val($('#b_city').val());
                $('#s_state').val($('#b_state').val());
                $('#s_country').val($('#b_country').val());
                $('#s_zip').val($('#b_zip').val());
            }
            else{
                $('#s_fname').val('');
                $('#s_lname').val('');
                $('#s_email').val('');
                $('#s_mobile').val('');
                $('#s_addr_1').val('');
                $('#s_addr_2').val('');
                $('#s_city').val('');
                $('#s_state').val('');
                $('#s_country').val('');
                $('#s_zip').val('');
            }
        });
    </script>
@endsection