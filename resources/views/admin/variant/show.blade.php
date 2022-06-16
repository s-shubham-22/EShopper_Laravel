@extends('admin.layouts.app')

@section('title', 'Variant')

@section('heading', 'Variant')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('variant.create', ['id' => $variants->first()->product_id]) }}">
            <button class="btn btn-primary mb-4">Add Variant</button>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Variant</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($variants as $variant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('uploads/variant/'.$variant->image) }}" alt="{{ $variant->name }}" height="50px">
                            </td>
                            <td class="text-center">
                                <span style="display: inline-block; height:40px; width:40px; border-radius:3px; background-color: {{ $variant->color }}"></span>
                            </td>
                            <td>{{ $variant->size }}</td>
                            <td>{{ $variant->price }}</td>
                            <td>{{ $variant->sale_price }}</td>
                            <td>{{ $variant->quantity }}</td>
                            @if ($variant->status == 1)
                                @php
                                    $status_checked = 'checked';
                                @endphp
                            @else
                                @php
                                    $status_checked = '';
                                @endphp                            
                            @endif
                            <td class="text-center"><input type="checkbox" id="status-{{ $variant->id }}" {{ $status_checked }} onclick="change_status({{$variant->id}});"></td>
                            <td class="text-center">
                                <a href="{{ route('variant.edit', $variant->id) }}">
                                    <button class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('variant.destroy', $variant->id) }}" method="POST" onsubmit="return confirmation();">
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
                            <th>Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
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
                url: "/admin/variant/change_status",
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