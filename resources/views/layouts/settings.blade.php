@extends('index')

@section('pageTitle', 'Settings')


@section('content')

    <div class="app-content ">
        <div class="side-app">
            <div class="main-content">
                <div class="p-2 d-block d-sm-none navbar-sm-search">
                    <!-- Form -->
                    <form class="navbar-search navbar-search-dark form-inline ml-lg-auto">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div><input class="form-control" placeholder="Search" type="text">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="container-fluid pt-30px">

                    @include('partials.topnavbar')

                    <div class="row m-0 pt-2 pb-5 align-items-center">
                        <div class="col-xl-5 col-lg-4 text-center text-lg-left mb-3 mb-lg-0">
                            <h2 class="m-0">"Will you review us" Email</h2>
                        </div>
                        
                        <div class="col-xl-7 col-lg-8 text-right d-none">
                            <button class="btn btn-green-transparent btn-with-toggle d-inline-flex" id="setting-active">
                                <span class="pr-2">Active </span>
                                <input type="checkbox" id="switch" checked />
                                <label for="switch"></label>
                            </button>
                            <button class="btn btn-blue-transparent">
                                <i class="fas fa-paper-plane"></i>
                            </button>

                            <button class="btn btn-blue-transparent">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-green">
                                <i class="fas fa-check"></i>
                                <span>Save</span>
                            </button>

                            <div class="d-inline ">
                                <a href="#." class="btn btn-white text-light-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding: 10px 18px;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(480px, 53px, 0px);">
                                    <!-- Dropdown menu links -->
                                    <button class="dropdown-item" type="button">Action</button>
                                    <button class="dropdown-item" type="button">Another action</button>
                                    <button class="dropdown-item" type="button">Something else here</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- card 1 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">1. Personalize Design</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                <form id="personalize_design_form" action="{{ route('emailPersonalizeDesign') }}" method="post"  enctype="multipart/form-data">
                                    
                                    @csrf
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="border p-3 d-flex justify-content-between" style="flex-direction: column;">
                                                    <div class="text-right">
                                                        <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                            <input type="checkbox" name="" id="checkbox-1" checked>
                                                            <label for="checkbox-1" class="dark-color m-0 position-static"></label>
                                                        </div>
                                                    </div>
                                                    @if ($CrmSettings->logo_image_src)
                                                    <img id="logo-image-preview" src="{{ asset('public/storage/'.$CrmSettings->logo_image_src) }}" alt="" class="img-fluid mt-3 mb-4">
                                                        
                                                    @else
                                                    <img id="logo-image-preview" src="{{ asset('public/images/default-logo.png') }}" alt="" class="img-fluid mt-3 mb-4">
                                                        
                                                    @endif


                                                    <label for="logo-image-button" class="btn btn-light-blue w-100 m-0">Change</label>
                                                    <input type="file" id="logo-image-button" name="logo-image-button" class="d-none" accept="image/*">

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="border h-100 p-3 d-flex justify-content-between" style="flex-direction: column;">
                                                    <div class="text-right">
                                                        <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                            <input type="checkbox" name="" id="checkbox-2">
                                                            <label for="checkbox-2" class="dark-color m-0 position-static"></label>
                                                        </div>
                                                    </div>
                                                    @if (!$CrmSettings->background_image_src)
                                                    <div id="background-image-description" class="mt-3 mb-4">
                                                        <p class="m-0 font-weight-normal">Background Image <span class="text-blue">*</span></p>
                                                        <p class="m-0 text-muted">The proposed size is 650*110px</p>
                                                        <p class="text-muted">.jpg , .png , .gif</p>
                                                    </div>
                                                    @endif
                                                    
                                                    <img id="background-image-preview" src="{{ asset('public/storage/'.$CrmSettings->background_image_src) }}" alt="" class="img-fluid mt-3 mb-4">
                                                    <label for="background-image-button" class="btn btn-light-blue w-100 m-0">Upload Image</label>
                                                    <input type="file" id="background-image-button" name="background-image-button" class="d-none" accept="image/*">

                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p class="m-0 text-muted">Top Background Color</p>
                                                <div class="position-relative">
                                                    @if ($CrmSettings->top_background_color)
                                                    <input type="text" class="settings-input form-control w-100" value="{{$CrmSettings->top_background_color}}">
                                                    <input type="color" id="top_background_color" name="top_background_color" value="{{$CrmSettings->top_background_color}}" class="color-changing-btn">
                                                    @else
                                                    <input type="text" class="settings-input form-control w-100" value="#ffffff">
                                                    <input type="color" id="top_background_color" name="top_background_color" value="#ffffff" class="color-changing-btn">
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-0 text-muted">Review Number Color</p>
                                                <div class="position-relative">
                                                    <input type="text" class="settings-input form-control w-100" value="{{$CrmSettings->review_number_color}}">
                                                    <input type="color" id="review_number_color" name="review_number_color" value="{{$CrmSettings->review_number_color}}" class="color-changing-btn">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-0 text-muted">Star Rating Color</p>
                                                <div class="position-relative">
                                                    @if ($CrmSettings->star_rating_color)
                                                    <input type="text" class="settings-input form-control w-100" value="{{$CrmSettings->star_rating_color}}">
                                                    <input type="color" id="star_rating_color" name="star_rating_color" value="{{$CrmSettings->star_rating_color}}" class="color-changing-btn">
                                                    @else
                                                    <input type="text" class="settings-input form-control w-100" value="#d5d5d5">
                                                    <input type="color" id="star_rating_color" name="star_rating_color" value="#d5d5d5" class="color-changing-btn">
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mt-3">
                                                <p><span class="text-blue">*</span> If you use an image as background, top background color will be hidden</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="personalize_design_submit" type="submit" class="btn btn-green float-right">
                                        <i class="fas fa-check"></i>
                                        <span>Save</span>
                                    </button>
                                </form>
                                </div>
                            </div>




                            <!-- card 2 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header active bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">2. Email Sent to the User</h3>
                                            <a href="#." class="float-right text-muted"> <i class="fas fa-eye"></i></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="email_sent_to_user_form" action="" method="post">
                                        @csrf
                                        <div class="container">
                                            <div class="row mb-3">
                                                <div class="col-sm-12 mb-4">
                                                    <label for="email_subject">Subject</label>
                                                    @if ($CrmSettings->email_subject)
                                                    <input type="text" id="email_subject" class="settings-input form-control w-100" value="{{$CrmSettings->email_subject}}">
                                                        
                                                    @else
                                                    <input type="text" id="email_subject" class="settings-input form-control w-100" value="{{'Your Experience with '.$user_data['business'][0]['practice_name']}}">
                                                        
                                                    @endif
                                                </div>
    
                                                <div class="col-sm-12 mb-4">
                                                    <label for="email_heading">Heading</label>
                                                    @if ($CrmSettings->email_heading)
                                                    <input type="text" id="email_heading" class="settings-input form-control w-100" value="{{$CrmSettings->email_heading}}">
                                                        
                                                    @else
                                                    <input type="text" id="email_heading" class="settings-input form-control w-100" value="Would you be so kind to recommend us?">
                                                        
                                                    @endif
                                                </div>
    
                                                <div class="col-sm-12 mb-4">
                                                    <label for="email_message">Message</label>
                                                    @if ($CrmSettings->email_message)
                                                    <textarea type="text" id="email_message" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">{{$CrmSettings->email_message}}</textarea>
                                                        
                                                    @else
                                                    <textarea type="text" id="email_message" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">Thanks for choosing {{$user_data['business'][0]['practice_name']}}. If you have a few minutes, I'd like to invite you to tell us about your experience. Your feedback is very important to us and it would be awesome if you can share it with us and our potential customers.</textarea>
                                                        
                                                    @endif
                                                </div>
    
                                                <div class="col-sm-6">
                                                    <label for="email_positive_anwser">Postive Answer</label>
                                                    <input type="text" id="email_positive_anwser" class="settings-input form-control w-100" value="Yes">
                                                </div>
    
                                                <div class="col-sm-6">
                                                    <label for="email_negative_anwser">Negative Answer</label>
                                                    <input type="text" id="email_negative_anwser" class="settings-input form-control w-100" value="No, Thanks">
                                                </div>
    
                                            </div>
    
    
                                        </div>
                                        <button id="email_sent_to_user_submit" type="submit" class="btn btn-green float-right">
                                            <i class="fas fa-check"></i>
                                            <span>Save</span>
                                        </button>
                                    </form>
                                    

                                </div>
                            </div>

                            <!-- card plus between 2 and 3 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">3. Personalized Touch <span class="badge badge-green badge-pill" style="transform: translateY(-4px);">NEW</span></h3>
                                            <a href="#." class="float-right text-muted ml-3"> <i class="fas fa-eye"></i></a>
                                            <div class="float-right btn-with-toggle d-flex text-muted">Turned On!
                                                <input type="checkbox" id="switch-1" checked />
                                                <label for="switch-1" class="mx-2"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="personalize_touch_form" action="" method="post"  enctype="multipart/form-data">

                                        <div class="container">
                                            <div class="row mb-3">
                                                <div class="col-sm-12">
                                                    <p class="mb-4">This function allows you to add a "personalized touch" by adding your image at the
                                                        bottom of the email</p>
                                                    <hr>
                                                </div>
    
                                                <div class="col-sm-12">
                                                    <div class="row mx-0 mb-4 align-items-center">
                                                        <div class="image">
                                                            <div class="image-preview-box">
                                                                @if (!$CrmSettings->personal_avatar_src)
                                                                <img id="image_preview_box" src="{{ asset('public/images/avatardp.png') }}" alt="" class="img-fluid">
                                                                @endif
                                                                <img src="{{ asset('public/storage/'.$CrmSettings->personal_avatar_src) }}" alt="" id="personal_avatar_preview" class="img-fluid">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="image-content">
                                                            <p class="font-weight-bold">Personal Avatar</p>
                                                            <p class="m-0 text-muted">The proposed size is 650*110px</p>
                                                            <p class="text-muted">.jpg , .png , .gif</p>
    
                                                            <label for="personal_avatar_input" class="btn btn-light-blue m-0">Upload</label>
                                                            <input type="file" id="personal_avatar_input" class="d-none" accept="image/*">
    
                                                        </div>
                                                    </div>
                                                </div>
    
    
                                                <div class="col-sm-12 mb-4">
                                                    <label for="full_name">Full Name</label>
                                                    @if ($CrmSettings->full_name)
                                                    <input type="text" id="full_name" class="settings-input form-control w-100" value="{{$CrmSettings->full_name}}">
                                                        
                                                    @else
                                                    <input type="text" id="full_name" class="settings-input form-control w-100" value="{{$user_data['first_name'].' '.$user_data['last_name']}}">
                                                        
                                                    @endif
                                                </div>
    
                                                <div class="col-sm-12">
                                                    <label for="company_role">Company Role</label>
                                                    @if ($CrmSettings->company_role)
                                                    <input type="text" id="company_role" class="settings-input form-control w-100" value="{{$CrmSettings->company_role}}">
                                                        
                                                    @else
                                                    <input type="text" id="company_role" class="settings-input form-control w-100" value="Business Manager">
                                                        
                                                    @endif
                                                </div>
    
                                            </div>
    
    
                                        </div>
                                        <button id="personalize_touch_submit" type="submit" class="btn btn-green float-right">
                                            <i class="fas fa-check"></i>
                                            <span>Save</span>
                                        </button>
                                    </form>
                                    

                                </div>
                            </div>

                            <!-- card 3 -->
                            <div class="card  shadow overflow-hidden" style="display: none">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">4. Postive Answer Setup</h3>
                                            <a href="#." class="float-right text-muted"> <i class="fas fa-eye"></i></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row mb-3">


                                            <div class="col-sm-12 mb-4">
                                                <label for="heading-1">Heading</label>
                                                <input type="text" id="heading-1" class="settings-input form-control w-100" value="How was your experience?">
                                            </div>

                                            <div class="col-sm-12 mb-4">
                                                <label for="message">Message</label>
                                                <textarea type="text" id="message" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">Thank you for recommending us to family and friends. Would you mind writing a short review?</textarea>
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="rev-1">Review Link #1</label>
                                                <input type="text" id="rev-1" class="settings-input form-control w-100" value="http://google.com/">
                                            </div>



                                        </div>


                                    </div>

                                </div>
                            </div>


                            <!-- card 4 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">4. Negative Answer Setup</h3>
                                            <a href="#." class="float-right text-muted"> <i class="fas fa-eye"></i></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="email_negative_answer_setup_form" action="" method="post">
                                        <div class="container">
                                            <div class="row mb-3">
                                                <div class="col-sm-12 mb-4">
                                                    <label for="email_negative_answer_setup_heading">Heading</label>
                                                    @if ($CrmSettings->email_negative_answer_setup_heading)
                                                    <input type="text" id="email_negative_answer_setup_heading" class="settings-input form-control w-100" value="{{$CrmSettings->email_negative_answer_setup_heading}}">
                                                        
                                                    @else
                                                    <input type="text" id="email_negative_answer_setup_heading" class="settings-input form-control w-100" value="We apologize for that.">
                                                        
                                                    @endif
                                                </div>
                                                <div class="col-sm-12 mb-4">
                                                    <label for="email_negative_answer_setup_message">Message</label>
                                                    @if ($CrmSettings->email_negative_answer_setup_message)
                                                    <textarea type="text" id="email_negative_answer_setup_message" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">{{$CrmSettings->email_negative_answer_setup_message}}</textarea>
                                                        
                                                    @else
                                                    <textarea type="text" id="email_negative_answer_setup_message" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">Sorry that your experience was not up to par. Would you mind writing how we could improve?</textarea>
                                                        
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button id="email_negative_answer_setup_submit" type="submit" class="btn btn-green float-right">
                                            <i class="fas fa-check"></i>
                                            <span>Save</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>









                        <div class="col-lg-4 col-md-8 mx-auto">
                            {{-- <img src="{{ asset('public/images/mobile.png') }}" alt="" class="img-fluid"> --}}
                            <div class="px-3 py-5 text-center" style="border-radius: 45px; background-color:#D1DCE4;">
                                <div class="bg-white my-4">
                                    <div id="mobile_top_background_color" class="row mx-0" style="background-color:{{$CrmSettings->top_background_color}}; ">
                                        <div class="col-5">
                                            @if ($CrmSettings->logo_image_src)
                                                <img id="mobile_logo_image_src" src="{{ asset('public/storage/'.$CrmSettings->logo_image_src) }}" alt="" class="img-fluid p-1" style="max-height: 5rem;">
                                            @else
                                                <img id="mobile_logo_image_src" src="{{ asset('public/images/default-logo.png') }}" alt="" class="img-fluid p-1" style="max-height: 5rem;">
                                            @endif
                                            
                                        </div>
                                        <div class="col-7 d-flex align-items-center justify-content-end">
                                            <p class="text-right mb-0 px-2">
                                                @if ($CrmSettings->review_number_color)
                                                <span id="mobile_review_number_color" class="px-2 font-weight-bold" style="font-size: 14px; color:{{$CrmSettings->review_number_color}};">5.0</span>
                                                    
                                                @else
                                                <span id="mobile_review_number_color" class="px-2 font-weight-bold" style="font-size: 14px; color:#D2D2D2;">N/A</span>
                                                    
                                                @endif
                                                @if ($CrmSettings->star_rating_color)
                                                    <span>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:{{$CrmSettings->star_rating_color}}; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:{{$CrmSettings->star_rating_color}}; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:{{$CrmSettings->star_rating_color}}; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:{{$CrmSettings->star_rating_color}}; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:{{$CrmSettings->star_rating_color}}; font-size:10px;"></i>
                                                    </span>
                                                @else
                                                    <span>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:#D2D2D2; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:#D2D2D2; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:#D2D2D2; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:#D2D2D2; font-size:10px;"></i>
                                                        <i class="fa fa-star mobile_star_rating_color" style="color:#D2D2D2; font-size:10px;"></i>
                                                    </span>
                                                @endif
                                                
                                            </p>
                                        
                                            
                                        </div>
                                    </div>
                                    {{-- <hr class="mx-3 my-1"> --}}
                                    @if ($CrmSettings->background_image_src)
                                    <div id="mobile-background_image_src" class="px-3" style="background-image: url('{{"public/storage/".$CrmSettings->background_image_src}}')">
                                        
                                    @else
                                    <div id="mobile-background_image_src" class="px-3">
                                        
                                    @endif
                                        <div class="pt-5" style="max-height: 115px; overflow: hidden;">
                                            @if ($CrmSettings->email_heading)
                                            <h1 id="mobile_email_heading">{{$CrmSettings->email_heading}} </h1>
                                                
                                            @else
                                            <h1 id="mobile_email_heading">Would you be so kind to recommend us?</h1>
                                                
                                            @endif
                                        </div>
                                        <div class="pt-4" style="max-height: 130px; overflow: hidden;">
                                            @if ($CrmSettings->email_message)
                                            <p id="mobile_email_message" class="font-weight-bold">{{$CrmSettings->email_message}}</p>
                                                
                                            @else
                                            <p id="mobile_email_message" class="font-weight-bold">Hi there! <br>
                                                Thanks for choosing {{$user_data['business'][0]['practice_name']}}. If you have a few minutes, I'd like to invite you to tell us about your experience. Your feedback is very important to us and it would be awesome if you can share it with us and our potential customers.</p>
                                                
                                            @endif
                                        </div>
                                        <div class="pt-4">
                                            <button class="btn btn-green btn-block mb-3 rounded-0">
                                                <span id="mobile_email_positive_anwser">Yes</span>
                                            </button>
                                            <button class="text-dark btn btn-light btn-block mb-3 rounded-0 border-0" style="background-color: #F1F7FA;">
                                                <span id="mobile_email_negative_anwser">No, Thanks</span>
                                            </button>
                                        </div>
                                        <div class="pt-4 pb-5">
                                            <p class="font-weight-bold">Sincerely,</p>
                                            <p class="font-weight-bold">
                                                @if ($CrmSettings->full_name)
                                                    <span id="mobile_full_name">{{$CrmSettings->full_name}}</span>,
                                                @else
                                                    <span id="mobile_full_name">{{$user_data['first_name'].' '.$user_data['last_name']}}</span>,
                                                @endif
                                                @if ($CrmSettings->company_role)
                                                    <span id="mobile_company_role">{{$CrmSettings->company_role}}</span>
                                                @else
                                                    <span id="mobile_company_role">Business Manager</span>
                                                @endif
                                            </p>
                                            <div>
                                                @if ($CrmSettings->personal_avatar_src)
                                                    <img id="mobile_personal_avatar_src" src="{{ asset('public/storage/'.$CrmSettings->personal_avatar_src) }}" alt="" class="img-fluid rounded-circle" style="max-height: 40px;">
                                                @else
                                                    <img id="mobile_personal_avatar_src" src="{{ asset('public/images/avatardp.png') }}" alt="" class="img-fluid rounded-circle" style="max-height: 40px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Footer -->
                    <footer class="footer">
                        <div class="row align-items-center justify-content-xl-between">
                            <div class="col-xl-12">
                                <div class="copyright text-center text-muted">
                                    <p class="text-sm font-weight-500">Copyright 2020 © All Rights Reserved</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- Footer -->
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            
            /* Logo image upload */
            var logoImageButton = document.getElementById('logo-image-button');
            var logoImagePreview = document.getElementById('logo-image-preview');

            logoImageButton.addEventListener("change", function (param) { 
                var file = logoImageButton.files[0];
                var reader = new FileReader();
                reader.addEventListener("load", function (param) { 
                    logoImagePreview.setAttribute("src", this.result);
                });
                reader.readAsDataURL(file);
            });
            
            /* background image upload */
            var backgroundImageButton = document.getElementById('background-image-button');
            var backgroundImagePreview = document.getElementById('background-image-preview');

            backgroundImageButton.addEventListener("change", function (param) { 
                var file = backgroundImageButton.files[0];
                var reader = new FileReader();
                reader.addEventListener("load", function (param) { 
                    if (document.getElementById('background-image-description')) {
                    document.getElementById('background-image-description').style.display = 'none';
                        
                    }
                    backgroundImagePreview.style.display = 'block';
                    backgroundImagePreview.setAttribute("src", this.result);
                });
                reader.readAsDataURL(file);
            });
            
            // 
            $("#personalize_design_form").submit(function(event){
                event.preventDefault();

                var logo_image_src = document.getElementById('logo-image-button').files[0];
                var background_image_src = document.getElementById('background-image-button').files[0];
                var top_background_color = document.getElementById('top_background_color').value;
                var review_number_color = document.getElementById('review_number_color').value;
                var star_rating_color = document.getElementById('star_rating_color').value;

                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('logo_image_src',logo_image_src);
                formData.append('background_image_src',background_image_src);
                formData.append('top_background_color',top_background_color);
                formData.append('review_number_color',review_number_color);
                formData.append('star_rating_color',star_rating_color);
                showPreloader();
                $.ajax({
                    type: "POST",
                    url: "{{ route('emailPersonalizeDesign') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                })
                .done(function(data, status) {
                    console.log(data);
                    console.log(status);
                    hidePreloader();
                    swal({
                            title: "Successful!",
                            text: 'Personalize Design updated successfully',
                            type: "success"
                        }, function () {});
                    if (data[0].logo_image_src) {
                        $('#mobile_logo_image_src').attr('src', 'public/storage/'+data[0].logo_image_src);
                    }
                    if (data[0].background_image_src) {
                        $('#mobile-background_image_src').css('background-image', 'url("public/storage/'+data[0].background_image_src+'")');
                    }
                    $('#mobile_top_background_color').css("background-color", data[0].top_background_color);
                    $('#mobile_review_number_color').css("color", data[0].review_number_color);
                    $('.mobile_star_rating_color').each(function(index, element) {
                        element.style.color = data[0].star_rating_color;
                    });
                })
                .fail(function(error) {
                    console.log(error);
                    hidePreloader();
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                })
                .always(function() {
                    console.log("emailPersonalizeDesign finished");
                });

            });
           
            // 
            $('#email_sent_to_user_form').submit(function (event) { 
                event.preventDefault();

                var email_subject = document.getElementById('email_subject').value;
                var email_heading = document.getElementById('email_heading').value;
                var email_message = document.getElementById('email_message').value;
                var email_positive_anwser = document.getElementById('email_positive_anwser').value;
                var email_negative_anwser = document.getElementById('email_negative_anwser').value;
                
                showPreloader();
                $.post("{{ route('emailSentUser') }}", 
                {
                    _token: "{{ csrf_token() }}",
                    email_subject: email_subject,
                    email_heading: email_heading,
                    email_message: email_message,
                    email_positive_anwser: email_positive_anwser,
                    email_negative_anwser: email_negative_anwser
                },
                function (data, textStatus, jqXHR) {
                    console.log(data);
                    console.log(textStatus);
                    console.log(jqXHR);
                })
                .done(function(data) {
                    hidePreloader();
                    swal({
                            title: "Successful!",
                            text: 'Email Setting updated successfully',
                            type: "success"
                        }, function () {});
                    $('#mobile_email_heading').text(data[0].email_heading);
                    $('#mobile_email_message').text(data[0].email_message);
                    $('#mobile_email_positive_anwser').text(data[0].email_positive_anwser);
                    $('#mobile_email_negative_anwser').text(data[0].email_negative_anwser);
                })
                .fail(function(error) {
                    console.log(error);
                    hidePreloader();
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                })
                .always(function() {
                    console.log("emailSentUser finished");
                });

             });

             /* Logo image upload */
            var personal_avatar_input = document.getElementById('personal_avatar_input');
            var personal_avatar_preview = document.getElementById('personal_avatar_preview');

            personal_avatar_input.addEventListener("change", function (param) { 
                var file = personal_avatar_input.files[0];
                var reader = new FileReader();
                reader.addEventListener("load", function (param) { 
                    if (document.getElementById('image_preview_box')) {
                        document.getElementById('image_preview_box').style.display = 'none';
                    }
                    personal_avatar_preview.style.display = 'block';
                    personal_avatar_preview.setAttribute("src", this.result);
                });
                reader.readAsDataURL(file);
            });
            // 
            $('#personalize_touch_form').submit(function (event) { 
                event.preventDefault();

                var personal_avatar_src = document.getElementById('personal_avatar_input').files[0];
                var full_name = document.getElementById('full_name').value;
                var company_role = document.getElementById('company_role').value;

                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('personal_avatar_src',personal_avatar_src);
                formData.append('full_name',full_name);
                formData.append('company_role',company_role);
                showPreloader();
                $.ajax({
                    type: "POST",
                    url: "{{ route('personalizeTouch') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function(data) {
                    hidePreloader();
                    swal({
                            title: "Successful!",
                            text: 'Personalized Touch updated successfully',
                            type: "success"
                        }, function () {});
                    $('#mobile_full_name').text(data[0].full_name);
                    $('#mobile_company_role').text(data[0].company_role);
                    if (data[0].personal_avatar_src) {
                        $('#mobile_personal_avatar_src').attr('src', 'public/storage/'+data[0].personal_avatar_src);
                    }
                })
                .fail(function(error) {
                    console.error(error);
                    hidePreloader();
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                })
                .always(function() {
                    console.log("personalizeTouch finished");
                });

             });

             $('#email_negative_answer_setup_form').submit(function (event) { 
                event.preventDefault();
                console.log('email_negative_answer_setup_form');

                var email_negative_answer_setup_heading = document.getElementById('email_negative_answer_setup_heading').value;
                var email_negative_answer_setup_message = document.getElementById('email_negative_answer_setup_message').value;
                showPreloader();
                $.post("{{ route('emailNegativeAnswerSetup') }}", 
                {
                    _token: "{{ csrf_token() }}",
                    email_negative_answer_setup_heading: email_negative_answer_setup_heading,
                    email_negative_answer_setup_message: email_negative_answer_setup_message
                }).done(function(data) {
                    hidePreloader();
                    swal({
                            title: "Successful!",
                            text: 'Negative Answer Setup updated successfully',
                            type: "success"
                        }, function () {});
                    
                }).fail(function(error) {
                    hidePreloader();
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                    
                });
              });
            
        });
        
    </script>
@endsection