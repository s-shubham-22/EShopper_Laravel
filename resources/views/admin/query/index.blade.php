@extends('admin.layouts.app')

@section('title', 'Query')

@section('heading', 'Query')

@section('css')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('query.create') }}">
            <button class="btn btn-primary mb-4">Add Query</button>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Query</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($queries as $query)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $query->name }}</td>
                            <td>{{ $query->email }}</td>
                            <td>{{ $query->subject }}</td>
                            <td>{{ $query->message }}</td>
                            <td>
                                <form action="{{ route('query.destroy', $query->id) }}" method="POST" onsubmit="return confirmation();">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
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
    </script>
@endsection