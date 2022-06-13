@extends('layouts.app')

@section('title', 'Register')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Register</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Register</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Register Start -->
    <div class="container-fluid pt-5" id="register">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Register Here</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-8 mb-5 mx-auto">
                <div class="register-form">
                    <form method="POST" action="" id="contact-form">
                        <div class="control-group">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required="required" maxlength="80" data-validation-required-message="Please Enter Username" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" name="fname" class="form-control" id="fname" placeholder="Enter First Name" required="required" maxlength="80" data-validation-required-message="Please Enter First Name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" name="lname" class="form-control" id="lname" placeholder="Enter Last Name" required="required" maxlength="80" data-validation-required-message="Please Enter Last Name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="tel" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile No." required="required" maxlength="10" data-validation-required-message="Please Enter Mobile No." />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email ID" required="required" maxlength="10" data-validation-required-message="Please Enter Email ID" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label>Gender: </label><br>
                            <input type="radio" name="gender" id="male" value="male" required="required" data-validation-required-message="Please Enter Email ID" />
                            <label for="male">Male</label>
                            <input type="radio" name="gender" id="female" value="female" required="required" data-validation-required-message="Please Enter Email ID" />
                            <label for="female">Female</label>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" name="address" rows="6" id="address" placeholder="Enter Address" required="required" data-validation-required-message="Please Enter Address"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required="required" data-validation-required-message="Please Enter password" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm password" required="required" data-validation-required-message="Please Confirm password" />
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
    <!-- Register End -->
@endsection