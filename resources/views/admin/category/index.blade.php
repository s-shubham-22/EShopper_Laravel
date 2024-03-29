@extends('admin.layouts.app')

@section('title', 'Category')

@section('heading', 'Category')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('category.create') }}">
            <button class="btn btn-primary mb-4">Add Category</button>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <img src="{{ asset('uploads/category/'.$category->image) }}" alt="{{ $category->name }}" height="50px">
                            </td>
                            @if ($category->status == 1)
                                @php
                                    $status_checked = 'checked';
                                @endphp
                            @else
                                @php
                                    $status_checked = '';
                                @endphp                            
                            @endif
                            <td class="text-center"><input type="checkbox" id="status-{{ $category->id }}" {{ $status_checked }} onclick="change_status({{$category->id}});"></td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}">
                                    <button class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirmation();">
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
                            <th>Category Name</th>
                            <th>Image</th>
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
                url: "/admin/category/change_status",
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