@extends('admin.layouts.app')

@section('title', 'Orders')

@section('heading', 'Orders')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Order</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Mobile No.</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                        <th class="text-center">Ordered On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $order->user->name }}</td>
                        <td class="text-center">{{ $order->user->email }}</td>
                        <td class="text-center">{{ $order->b_mobile }}</td>
                        <td class="text-center" id="price-{{ $order->id }}">${{ $order->order_detail->sum('total') }}</td>
                        {{-- <td class="text-center">{{ $order->status }}</td> --}}
                        <td class="text-center">
                            <div class="form-group disabled">
                                <select class="form-control" onchange="change_status({{ $order->id }})" id="order-status-{{ $order->id }}" {{ $order->status === 'Success' || $order->status === 'Failed' ? 'disabled' : '' }}>
                                    <option value="Success" {{ $order->status ===  'Success' ? 'selected' : '' }}>Success</option>
                                    <option value="Pending" {{ $order->status ===  'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Failed" {{ $order->status ===  'Failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                        </td>
                        <td class="text-center" id="details-{{ $order->id }}"><a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">Details</a></td>
                        <td class="text-center total-price" id="total-{{ $order->id }}">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    </tr>
                    @endforeach                    
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Mobile No.</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                        <th class="text-center">Ordered On</th>
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

        function change_status(id) {
            status = $('#order-status-'+id).val();
            console.log(id, status);
            $.ajax({
                url: "/admin/order/change-status",
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    $('#order-status-'+id).attr('disabled', true);
                    console.log(response);
                    toastr.options.timeOut = 2000;
                    if (response.status === 'success'){
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    </script>
@endsection