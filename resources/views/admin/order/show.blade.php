@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('heading', 'Order Details')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row px-xl-5">
    <div class="col-lg-4 mx-auto border shadow p-3 mb-5 bg-white rounded">
        <h3 class="font-weight-bold">Billing Address</h4>
        <h4>{{ $order->b_fname }} {{ $order->b_lname }}</h4>
        <p class="mb-0">{{ $order->b_addr_1 }},</p>
        <p class="mb-0">{{ $order->b_addr_2 }},</p>
        <p class="mb-0">{{ $order->b_city }}, {{ $order->b_state }}</p>
        <p class="mb-0">{{ $order->b_country }} - {{ $order->b_zip }}.</p>
        <p class="mb-0">Mobile: {{ $order->b_mobile }}</p>
        <p class="mb-0">E-Mail: {{ $order->b_email }}</p>
    </div>
    <div class="col-lg-4 mx-auto border shadow p-3 mb-5 bg-white rounded">
        <h3 class="font-weight-bold">Shipping Address</h4>
        <h4>{{ $order->s_fname }} {{ $order->s_lname }}</h4>
        <p class="mb-0">{{ $order->s_addr_1 }},</p>
        <p class="mb-0">{{ $order->s_addr_2 }},</p>
        <p class="mb-0">{{ $order->s_city }}, {{ $order->s_state }}</p>
        <p class="mb-0">{{ $order->s_country }} - {{ $order->s_zip }}.</p>
        <p class="mb-0">Mobile: {{ $order->s_mobile }}</p>
        <p class="mb-0">E-Mail: {{ $order->s_email }}</p>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Products in Order</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_details as $order_detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center" id="price-{{ $order_detail->id }}"><img src="{{ asset('uploads/variant/').'/'.$order_detail->variant->image }}" alt="" style="width: 100px;"> {{ $order_detail->product->name }} ( <span style="display: inline-block; height:15px; width:15px; background-color:{{$order_detail->variant->color}}; border-radius:3px;"></span> , {{ $order_detail->variant->size }} )</td>
                        <td class="text-center">${{ $order_detail->price }}</td>
                        <td class="text-center" id="details-{{ $order_detail->id }}">{{ $order_detail->quantity }}</td>
                        <td class="text-center total-price" id="total-{{ $order->id }}">${{ $order_detail->total }}</td>
                    </tr>
                    @endforeach                    
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection