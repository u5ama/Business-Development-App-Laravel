@extends('index-splash')

@section('pageTitle', 'Register')

@section('content')
    <div class="limiter">
        <div class="text-center py-3 border-bottom">
            {{--            <img src="{{ asset('public/images/logo-green.png') }}" alt="" style="max-width: 100px;" />--}}
            <img style="max-width: 100px;"  src="{{ asset('public/images/brand/logo-black.png') }}" />
        </div>

        <div class="container">
            <div class="row">

                <div class="col-lg-5 col-md-8 col-sm-12 mx-auto py-5">
                    <form class="form-horizontal validate-me new-lg-form" role="form" method="POST">
                        <h2 class="login-heading">Let's Create Your Account</h2>
                        <h5 class="mb-4 login-subheading">Already have a Trustyy account?
                            <a href="{{ route('login') }}" class="default-color text-underline">Sign In</a></h5>

                        <div class="form-group business-section mb-3">
                            <div class="practice-container">
                                <div class="putin">
                                    <h6 class="dark-color m-0 font-14"><label for="name">Business Name *</label></h6>
                                    <input type="text" class="input-field form-control" id="practice-name" name="practice_name" placeholder="Your Business Name" value="" data-required="true" autocomplete="off" />
                                    <input type="hidden" id="business-address" name="address" placeholder="" value="">
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>

                            <div class="business-selected-box" style="display: none;">
                                <div class="selected-business">
                                    <a href="javascript:void(0);" class="close-me">x</a>
                                    <span class="item-query"><span class="pac-matched"></span></span>
                                    <span class="address-detail"></span>
                                </div>
                            </div>


                            <div class="manual-business-box" style="display: none;">
                                <div class="manual-add-business"><span class="item-query" style="display: inline-block;font-weight: 400;font-size: 14px;color: #7c889c !important;"><span class="pac-matched">Can't find your business?</span></span>
                                    Add your business manually </div>
                            </div>

                            {{--auto, manual--}}
                            <input type="hidden" class="business-discovery-status" name="practice_status" id="practice-status" value="manual" />
                        </div>

                        <div class="form-group">
                            <div class="optional-section" style="display: none !important;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="putin">
                                            <input type="text" class="input-field form-control" id="website" name="website" value="">
                                            <label class="input-label" for="website">
                                                <span class="label-text">Website URL</span>
                                            </label>
                                            <span class="help-block hide-me"><small></small></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="putin">
                                            <input type="text" class="input-field form-control" id="phone" name="phone" value="">
                                            <label class="input-label" for="phone">
                                                <span class="label-text">Phone Number *</span>
                                            </label>
                                            <span class="help-block hide-me"><small></small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <h6 class="dark-color m-0 font-14"><label for="name">First Name *</label></h6>
                                <input type="text" class="input-field form-control" id="first-name" name="first_name" value="" placeholder="Your First Name" data-required="true">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                            <div class="mb-3">
                                <h6 class="dark-color m-0 font-14"><label for="name">Last Name *</label></h6>
                                <input type="text" class="input-field form-control" id="last-name" name="last_name" value="" placeholder="Your Last Name" data-required="true" />
                                <span class="help-block hide-me"><small></small></span>
                            </div>

                            <div class="mb-3">
                                <h6 class="dark-color m-0 font-14"><label for="email">Work Email *</label></h6>
                                <input class="input" type="text" name="email" placeholder="you@company.com" id="email" data-required="true">
                                <span class="help-block hide-me"><small></small></span>
                            </div>

                            <div class="">
                                <h6 class="dark-color m-0 font-14"><label for="pass">Create a Password *</label></h6>
                                <input class="input" type="password" name="password" placeholder="Enter a strong password" id="password" data-required="true">
                                <span class="help-block hide-me"><small></small></span>
                            </div>

                            <div class="mt-3">
{{--                                disabled-btn--}}
                                <button class="form-submit-btn btn submit full-btn" type="submit">Create a Account</button>

                                <div class="register-checkbox mb-0 heading-default" style="
    margin-top: 10px;
">
                                    <span class="txt1">
                                    By creating a account, you agree to our Terms &amp; conditions and Privacy policy
                                </span>
                                </div>
                            </div>

                            <div class="text-center pt-2">
                                <span class="txt1">
                                    Forgot
                                </span>
                                <a class="txt2 default-color text-underline" href="{{ route('forgot-password') }}">
                                    Username / Password?
                                </a>
                            </div>

                            <div class="form-group m-b-0 response-message" style="display: none;margin-top: 10px;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link type="text/css" href="{{ asset('public/plugins/custom-select/custom-select.css') }}" rel="stylesheet" />

{{--    <style>--}}

{{--        .putin {--}}
{{--            position: relative;--}}
{{--            /*margin-top: 20px;*/--}}
{{--        }--}}
{{--        .putin .input-field {--}}
{{--            width: 100%;--}}
{{--            position: relative;--}}
{{--            -webkit-transition: all 300ms;--}}
{{--            transition: all 300ms;--}}
{{--            /*margin-bottom: 10px;*/--}}
{{--            border-radius: 3px;--}}
{{--            border: 1px solid #aaaaaa !important;--}}
{{--            height: 45px !important;--}}
{{--            box-shadow: none !important;--}}
{{--        }--}}
{{--        .putin.active .input-field{--}}
{{--            padding-top: 25px;--}}
{{--            /*box-shadow: 0 0 3px 2px rgba(1, 161, 254, 0.51);*/--}}
{{--            /*border-color: transparent;*/--}}
{{--        }--}}
{{--        /*.putin .input-field:focus,*/--}}
{{--        /*.putin .input-field:active{*/--}}
{{--        /*border-color: transparent !important;*/--}}
{{--        /*outline: none !important;*/--}}
{{--        /*}*/--}}

{{--        .putin .input-label {--}}
{{--            position: absolute;--}}
{{--            bottom: 0;--}}
{{--            left: 0;--}}
{{--            margin-bottom: 0;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            pointer-events: none;--}}
{{--            -webkit-user-select: none;--}}
{{--            -moz-user-select: none;--}}
{{--            -ms-user-select: none;--}}
{{--            user-select: none;--}}
{{--        }--}}
{{--        .putin .input-label .label-text {--}}
{{--            display: inline-block;--}}
{{--            position: absolute;--}}
{{--            left: 6px;--}}
{{--            top: 23px;--}}
{{--            -webkit-transform: translateY(-50%);--}}
{{--            transform: translateY(-50%);--}}
{{--            z-index: 100;--}}
{{--            -webkit-transition: all 300ms;--}}
{{--            transition: all 300ms;--}}
{{--            pointer-events: none;--}}
{{--            color: #323232;--}}
{{--            padding: 0.5em 0.3em;--}}
{{--        }--}}

{{--        .putin.active .input-label .label-text {--}}
{{--            top: 10px;--}}
{{--            font-size: 13px;--}}
{{--        }--}}

{{--        /*    select*/--}}

{{--        .new-login-box .white-box .form-control{--}}

{{--        }--}}
{{--        .new-login-box .white-box .form-control:focus{--}}
{{--            border-width: 1px;--}}
{{--            /*border-color: transparent !important;*/--}}
{{--            /*box-shadow: 0 0 3px 2px rgba(1, 161, 254, 0.51);*/--}}
{{--        }--}}

{{--    </style>--}}
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/custom-select/custom-select.min.js') }}"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDs4NnJzPINOOmFuOrcO4Kn-OhJQsl9ALg&libraries=places"></script>
    <script type="text/javascript" src="{{ asset('public/js/register.js?ver='.$appFileVersion) }}"></script>

    <script>
        // (function(){
        //     $('input.input-field').each(function(e){
        //         if( $(this).val() !== '' ) {
        //             $(this).parent().addClass('active')
        //         }
        //         $(this).on('focus', focus);
        //         $(this).on('blur', blur);
        //     });
        //     function focus(e) {
        //         $(this).parent().addClass('active')
        //     }
        //     function blur(e) {
        //         if( e.target.value.trim() === '' ) {
        //             $(this).parent().removeClass('active')
        //         }
        //     }
        // })();
    </script>
@endsection
