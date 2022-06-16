@extends('admin.layouts.app')

@section('title', 'Contact')

@section('heading', 'Contact')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Contact</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($contacts->count() > 0)
                    @method('POST')
                @endif
                <div class="form-group">
                    <label for="email">Email <strong class="text-danger">*</strong></label>
                    <input type="email" class="form-control" value="{{ isset($contacts->first()->email) ? $contacts->first()->email :'' }}" id="email" name="email" aria-describedby="emailHelp" required="">
                </div>
                <div class="form-group">
                    <label for="phone">Phone No. <strong class="text-danger">*</strong></label>
                    <input type="tel" class="form-control" value="{{ isset($contacts->first()->phone) ? $contacts->first()->phone :'' }}" id="phone" name="phone" aria-describedby="emailHelp" required="">
                </div>
                <div class="form-group">
                    <label for="phone">Address <strong class="text-danger">*</strong></label>
                    <textarea class="form-control" name="address" id="address" required>{{ isset($contacts->first()->address) ? $contacts->first()->address :'' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection()