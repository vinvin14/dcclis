@extends('layout.app-sbamin')
@section('body_class', 'bg-gradient-success')
@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg w-50 my-5">
            <div class="card-body">
                <!-- Nested Row within Card Body -->
                <div class="p-3">
                    <div class="text-center">
                        <img src="{{asset('includes/images/doh-logo.png')}}" style="vertical-align:middle;width:120px;height:120px;" alt="">
                        <h1 class="h4 text-gray-900 mb-4">DCCLIS</h1>
                    </div>
                    <form class="user">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address...">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember
                                    Me</label>
                            </div>
                        </div>
                        <a href="index.html" class="btn btn-light btn-user btn-block">
                            Login
                        </a>
                        
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="register.html">Create an Account!</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection