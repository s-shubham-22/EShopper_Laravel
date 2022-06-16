@extends('admin.layouts.app')

@section('title', 'Product')

@section('heading', 'Product')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('product.create') }}">
            <button class="btn btn-primary mb-4">Add Product</button>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset('uploads/product/'.$product->image) }}" alt="{{ $product->name }}" height="50px">
                            </td>
                            @if ($product->status == 1)
                                @php
                                    $status_checked = 'checked';
                                @endphp
                            @else
                                @php
                                    $status_checked = '';
                                @endphp                            
                            @endif
                            <td class="text-center"><input type="checkbox" id="status-{{ $product->id }}" {{ $status_checked }} onclick="change_status({{$product->id}});"></td>
                            <td class="text-center">
                                <a href="{{ route('variant.show', $product->id) }}">
                                    <button class="btn btn-primary">Variants</button>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('product.edit', $product->id) }}">
                                    <button class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirmation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
        function confirmation() {
            return confirm('Are you sure you want to delete this item?');
        }

        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        function change_status(id) {
            var status = $('#status-'+id).is(':checked');
            if(status) {
                status = 1;
            } else {
                status = 0;
            }
            $.ajax({
                url: "/admin/product/change_status",
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    console.log(response);
                    toastr.options.timeOut = 2000;
                    if (response.success){
                        toastr.success(response.success);
                    } else {
                        toastr.error(response.success);
                    }
                }
            });
        }
    </script>
@endsection