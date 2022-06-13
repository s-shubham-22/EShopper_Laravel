@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Contact Us</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Login</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Login Start -->
<div class="container-fluid pt-5" id="login">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Login Here</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-8 mb-5 mx-auto">
            <div class="login-form">
                <form method="POST" action="" id="contact-form">
                    <div class="control-group">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Your Username" required="required" data-validation-required-message="Please enter your username" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Your password" required="required" data-validation-required-message="Please enter your password" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login End -->
@endsection()