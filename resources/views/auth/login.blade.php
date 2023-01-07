@extends('index-splash')

@section('pageTitle', 'Login')

@section('content')
    <div class="limiter">

        <div class="container">
            <div class="row" style="min-height: 100vh; align-items: center;">

                <div class="col-lg-5 col-md-8 col-sm-12 mx-auto py-5">
                <form method="post" role="form" class="bg-white px-4 pb-5 form-signin validate-me">
                        <div class="login-img">
                            <div class="login-img-center">
                                <img src="{{ asset('public/images/brand/logo-icon.png') }}">
                            </div>
                        </div>

                        <h2 class="login-heading my-4">Log in to Trustyy</h2>

                        <div class="response-message" style="display: none;"></div>

                        <div class=" mb-3">
                            <h6 class="dark-color m-0 font-14"><label for="email">Email *</label></h6>
                            <input class="input" type="text" name="email"  id="email" data-required="true" />
                            <span class="help-block hide-me"><small></small></span>
                        </div>

                        <div class="">
                            <h6 class="dark-color m-0 font-14"><label for="pass">Password *</label></h6>
                            <input class="input" type="password" id="password" name="password" data-required="true" />
                            <span class="help-block hide-me"><small></small></span>
                        </div>

                        <div class=" register-checkbox login-checkbox mb-0">
                            <input type="checkbox" name="" id="checkbox">
                            <label for="checkbox" class="dark-color">Remember me</label>
                        </div>

                        <div class="mt-3">
                            <button class="form-submit-btn btn submit full-btn" type="submit">Login</button>
                        </div>

                        <div class="text-center pt-2">
							<span class="txt1">
								Forgot your password?
							</span>
                            <a class="txt2 default-color text-underline" href="{{ route('forgot-password') }}">
                                Reset your password
                            </a>
                        </div>

                        <div class="text-center pt-2">
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
    <script type="text/javascript" src="{{ asset('public/js/login.js?ver='.$appFileVersion) }}"></script>

    <script>

        (function(){
            $('input.input-field').each(function(e){
                if( $(this).val() !== '' ) {
                    $(this).parent().addClass('active')
                }
                $(this).on('focus', focus);
                $(this).on('blur', blur);
            });
            function focus(e) {
                $(this).parent().addClass('active')
            }
            function blur(e) {
                if( e.target.value.trim() === '' ) {
                    $(this).parent().removeClass('active')
                }
            }
        })();
    </script>
@endsection
