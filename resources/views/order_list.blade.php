@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>#</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Ordered On</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($orders as $order)
                    <tr id="row-{{ $order->id }}">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle" id="price-{{ $order->id }}">${{ $order->order_detail->sum('total') }}</td>
                        <td class="align-middle">{{ $order->status }}</td>
                        <td class="align-middle" id="details-{{ $order->id }}"><a href="{{ route('orders', $order->id) }}" class="btn btn-primary">Details</a></td>
                        <td class="align-middle total-price" id="total-{{ $order->id }}">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection