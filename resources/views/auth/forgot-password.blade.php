@extends('index-splash')

@section('pageTitle', 'Forgot Password')

@section('content')
    <div class="limiter">

        <div class="container">
            <div class="row" style="min-height: 100vh; align-items: center;">

                <div class="col-lg-5 col-md-8 col-sm-12 mx-auto py-5">
                    <form class=" validate-form bg-white px-4 pb-5">
                        <div class="login-img">
                            <div class="login-img-center">
                                {{--                                <img src="{{ asset('public/images/logo-green-thumb.png') }}" alt="">--}}
                                <img src="{{ asset('public/images/brand/logo-icon.png') }}">
                            </div>
                        </div>

                        <h2 class="login-heading my-4">Reset Your Password</h2>



                        <div class=" mb-3">
                            <h6 class="dark-color m-0 font-14"><label for="email">Email *</label></h6>
                            <input class="input" type="text" name="email"  id="email">
                        </div>

                        <div class="mt-3">
                            <button class="form-submit-btn btn full-btn default-color" type="button">
                                Send Reset Email
                            </button>
                        </div>

                        <div class="text-center pt-3">
							<span class="txt1">
								Already have an account?
							</span>
                            <a class="txt2 default-color text-underline" href="{{ route('login') }}">
                                Sign in
                            </a>
                        </div>

                        <div class="text-center">
							<span class="txt1">
								Don’t have an account?
							</span>
                            <a class="txt2 default-color text-underline" href="{{ route('register') }}">
                                Sign up
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        body{
            background-color: #F7F8FA;
        }
    </style>
@endsection

@section('js')

@endsection
