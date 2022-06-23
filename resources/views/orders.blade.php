@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($order_details as $order_detail)
                    <tr id="row-{{ $order_detail->id }}">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle"><img src="{{ asset('uploads/variant/').'/'.$order_detail->variant->image }}" alt="" style="width: 100px;"> {{ $order_detail->product->name }} ( <span style="display: inline-block; height:15px; width:15px; background-color:{{$order_detail->variant->color}}; border-radius:3px;"></span> , {{ $order_detail->variant->size }} )</td>
                        <td class="align-middle" id="price-{{ $order_detail->id }}">${{ $order_detail->price }}</td>
                        <td class="align-middle" id="quantity-{{ $order_detail->id }}">{{ $order_detail->quantity }}</td>
                        <td class="align-middle" id="total-{{ $order_detail->id }}">${{ $order_detail->price * $order_detail->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection