@extends('index')

@section('pageTitle', 'Home')

@section('content')
<div class="app-content">
    <div class="side-app">
        <div class="main-content">
            <div class="p-2 d-block d-sm-none navbar-sm-search">
                <!-- Form -->
                <form class="navbar-search navbar-search-dark form-inline ml-lg-auto">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="container-fluid pt-30px">
                @include('partials.topnavbar')
                <!-- charts -->

                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card shadow overflow-hidden" style="height: 400px">
                            <div class="card-body review-card-absolute">
                                <div class="widget">

                                    <h3 class="font-bold mb-0">Overall Rating</h3>
                                    <div class="rating-heading">
                                        <h2 class="display-2 mb-0">{{ round($overAllRating,2) ?? '0'}}</h2>&nbsp;
                                        <span class="rating">
                                            <span class="rating-value"
                                                style="{{'width:'.$overAllRating*'20'.'%'}}"></span>
                                        </span>
                                    </div>
                                    <h5 class="text-muted font-bold"><span style="color: #00da8c">+0.5</span> points
                                        from last month</h5>
                                </div>
                            </div>
                            <div id="review-chart-container"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 order-12 order-lg-one">
                        <div class="card  shadow overflow-hidden" style="min-height: 400px">
                            <div class="card-body">
                                <div class="cahrt-heading-flex">
                                    <h3 class="font-bold mb-0">Public Reviews</h3>
                                    <div style="display: none" class="btn-group">
                                        <button type="button" class="btn-years dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            1 year
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item" type="button">1 year</button>
                                            <button class="dropdown-item" type="button">2 year</button>
                                            <button class="dropdown-item" type="button">3 year</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex" style="justify-content: space-between;">
                                    <div class="d-flex">
                                        <div style="margin-right:15px">
                                            <p class="m-0">Total Reviews</p>
                                            <h3 class="mb-0 font-bold" style="margin-top:-10px; font-size:2rem">
                                                {{$publicReviews}}</h3>
                                        </div>
                                        <div>
                                            <p class="m-0 text-green-1">Since Trustyy</p>
                                            <h2 class="mb-0 font-bold text-green-1"
                                                style="margin-top:-10px; font-size:1.6rem">+1,725</h2>
                                        </div>
                                    </div>
                                    <div class="d-flex">

                                        <div style="margin-right:15px" class="d-flex">
                                            <span class="pateint-circle"></span>
                                            <p class="m-0">Reviews</p>
                                        </div>
                                        <div class="d-flex">
                                            <span class="pateint-circle green"></span>
                                            <p class="m-0">Since Trustyy</p>
                                        </div>


                                    </div>
                                </div>




                            </div>
                            <!-- Chart -->
                            <div id="public-reviews-chart" style="height: 200px"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 order-1">

                        <div class="">
                            <div class="">
                                <div class="row">
                                    <div class="col-xl-12">
                                        @switch($sentiments)
                                            @case('publicReviewsNotAvailable')
                                            <div class="card shadow" style="min-height: 400px">
                                                <div class="card-body">
                                                    <div class="widget">
                                                        <h3 class="font-bold mb-5">Sentiment Analysis</h3>
    
    
                                                        <div style="width: 180px;margin: auto;">
                                                            <div class="stats-circle">
                                                                <div class="half-circle"></div>
                                                                <div class="half-circle prog no" style="transform: rotate(-220deg);"></div>
                                                            </div>
                                                            <div class="text-center">
                                                                
                                                                <img src="{{ asset('public/images/No_Reviews.png') }}"
                                                                    alt="" class="pateint-sentiment-img">
                                                            </div>
                                                        </div>
    
                                                        <div class="pateints-satisfaction-box">
                                                            <div>No reviews yet</div>
                                                        </div>
    
                                                    </div>
                                                </div>
                                            </div>
                                                @break
                                                @case($sentiments >= 90 && $sentiments <= 100)
                                                <div class="card shadow" style="min-height: 400px">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <h3 class="font-bold mb-5">Sentiment Analysis</h3>
        
        
                                                            <div style="width: 180px;margin: auto;">
                                                                <div class="stats-circle">
                                                                    <div class="half-circle"></div>
                                                                <div class="half-circle prog superb" style="transform: rotate({{ (1.7*$sentiments)-220 .'deg' }});"></div>
                                                                </div>
                                                                <div class="text-center">
                                                                    
                                                                    <img src="{{ asset('public/images/Supurb.png') }}"
                                                                        alt="" class="pateint-sentiment-img">
                                                                    <h3 class="font-bold mt-2" style="color: #4AAF57;">Superb!</h3>
                                                                </div>
                                                            </div>
        
                                                            <div class="pateints-satisfaction-box">
                                                                
                                                                <div class="d-flex" style="margin-right: 8px;">
                                                                    <h2 class="font-bold">{{ round($sentiments, 0) ?? '100'}}
                                                                    </h2>
                                                                    <h4 class="font-bold">%</h4>
                                                                </div>
                                                                <div>of your clients are satisfied with your service.</div>
        
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case($sentiments >= 75 && $sentiments < 90)
                                                <div class="card shadow" style="min-height: 400px">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <h3 class="font-bold mb-5">Sentiment Analysis</h3>
        
        
                                                            <div style="width: 180px;margin: auto;">
                                                                <div class="stats-circle">
                                                                    <div class="half-circle"></div>
                                                                    <div class="half-circle prog good" style="transform: rotate({{ (1.7*$sentiments)-220 .'deg' }});"></div>
                                                                </div>
                                                                <div class="text-center">
                                                                    
                                                                    <img src="{{ asset('public/images/Good.png') }}"
                                                                        alt="" class="pateint-sentiment-img">
                                                                    <h3 class="font-bold mt-2" style="color: #87C04E;">Good!</h3>
                                                                </div>
                                                            </div>
        
                                                            <div class="pateints-satisfaction-box">
                                                                
                                                                <div class="d-flex" style="margin-right: 8px;">
                                                                    <h2 class="font-bold">{{ round($sentiments, 0) ?? '100'}}
                                                                    </h2>
                                                                    <h4 class="font-bold">%</h4>
                                                                </div>
                                                                <div>of your clients are satisfied with your service.</div>
        
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case($sentiments >= 55 && $sentiments < 75)
                                                <div class="card shadow" style="min-height: 400px">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <h3 class="font-bold mb-5">Sentiment Analysis</h3>
        
        
                                                            <div style="width: 180px;margin: auto;">
                                                                <div class="stats-circle">
                                                                    <div class="half-circle"></div>
                                                                    <div class="half-circle prog ok" style="transform: rotate({{ (1.7*$sentiments)-220 .'deg' }});"></div>
                                                                </div>
                                                                <div class="text-center">
                                                                    
                                                                    <img src="{{ asset('public/images/OK.png') }}"
                                                                        alt="" class="pateint-sentiment-img">
                                                                    <h3 class="font-bold mt-2" style="color: #F9EC3F;">OK!</h3>
                                                                </div>
                                                            </div>
        
                                                            <div class="pateints-satisfaction-box">
                                                                
                                                                <div class="d-flex" style="margin-right: 8px;">
                                                                    <h2 class="font-bold">{{ round($sentiments, 0) ?? '100'}}
                                                                    </h2>
                                                                    <h4 class="font-bold">%</h4>
                                                                </div>
                                                                <div>of your clients are satisfied with your service.</div>
        
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case($sentiments >= 30 && $sentiments < 55)
                                                <div class="card shadow" style="min-height: 400px">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <h3 class="font-bold mb-5">Sentiment Analysis</h3>
        
        
                                                            <div style="width: 180px;margin: auto;">
                                                                <div class="stats-circle">
                                                                    <div class="half-circle"></div>
                                                                    <div class="half-circle prog nogood" style="transform: rotate({{ (1.7*$sentiments)-220 .'deg' }});"></div>
                                                                </div>
                                                                <div class="text-center">
                                                                    
                                                                    <img src="{{ asset('public/images/Not_So_Good.png') }}"
                                                                        alt="" class="pateint-sentiment-img">
                                                                    <h3 class="font-bold mt-2" style="color: #F4B538;">Not So Good!</h3>
                                                                </div>
                                                            </div>
        
                                                            <div class="pateints-satisfaction-box">
                                                                
                                                                <div class="d-flex" style="margin-right: 8px;">
                                                                    <h2 class="font-bold">{{ round($sentiments, 0) ?? '100'}}
                                                                    </h2>
                                                                    <h4 class="font-bold">%</h4>
                                                                </div>
                                                                <div>of your clients are satisfied with your service.</div>
        
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case($sentiments >= 0 && $sentiments < 30)
                                                <div class="card shadow" style="min-height: 400px">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <h3 class="font-bold mb-5">Sentiment Analysis</h3>
        
        
                                                            <div style="width: 180px;margin: auto;">
                                                                <div class="stats-circle">
                                                                    <div class="half-circle"></div>
                                                                    <div class="half-circle prog bad" style="transform: rotate({{ (1.7*$sentiments)-220 .'deg' }});"></div>
                                                                </div>
                                                                <div class="text-center">
                                                                    
                                                                    <img src="{{ asset('public/images/Bad.png') }}"
                                                                        alt="" class="pateint-sentiment-img">
                                                                    <h3 class="text-danger font-bold mt-2">Bad!</h3>
                                                                </div>
                                                            </div>
        
                                                            <div class="pateints-satisfaction-box">
                                                                
                                                                <div class="d-flex" style="margin-right: 8px;">
                                                                    <h2 class="font-bold">{{ round($sentiments, 0) ?? '100'}}
                                                                    </h2>
                                                                    <h4 class="font-bold">%</h4>
                                                                </div>
                                                                <div>of your clients are satisfied with your service.</div>
        
                                                            </div>
        
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                            @default
                                                
                                        @endswitch


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card  shadow overflow-hidden">
                            <div class="card-header bg-transparent ">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-light ls-1 mb-1">Latest Reviews</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">

                                @forelse ($lastReviews as $review)
                                <div class="rating-box mb-4">
                                    <div class="d-flex">
                                        <div class="rating-profile">
                                            <div class="rating-image">

                                                @if ($review->type == 'Tripadvisor')
                                                <img src="{{ asset('public/images/avatardp.png') }}" alt=""
                                                    class="img-fluid radius-50">
                                                @else
                                                <img src="{{ $review->reviewer_image ?? asset('public/images/rating/avatardp.png') }}"
                                                    alt="" class="img-fluid radius-50">
                                                @endif

                                                <div class="avatar bg-light shadow"
                                                    {{-- style="background-color: #b19cd9;" --}}>
                                                    @switch($review->type)
                                                    @case('Tripadvisor')
                                                    <i class="fab fa-tripadvisor fa-lg text-success"></i>
                                                    @break
                                                    @case('Google Places')
                                                    <i class="fab fa-google fa-lg text-danger"></i>
                                                    @break
                                                    @case('Yelp')
                                                    <i class="fab fa-yelp fa-lg text-danger"></i>
                                                    @break
                                                    @default
                                                    <i class="fab fa-facebook-f fa-lg text-primary"></i>
                                                    @endswitch
                                                </div>
                                            </div>

                                        </div>
                                        <div class="rating-detail">
                                            <h4 class="mb-0">{{ $review->reviewer }}</h4>
                                            <p class="my-2"><span class="rating">
                                                    <span class="rating-value"
                                                        style="{{'width:'.$review->rating*'20'.'%'}}"></span>
                                                </span>
                                                <span class="text-muted font-weight-normal">
                                                    {{ date_diff(date_create($review->review_date), date_create(date('yy-m-d')))->format("%a") }}
                                                    Days ago from <a href="#."
                                                        class="text-bolder">{{ $review->type }}</a></span></p>
                                            <div class="review-column">
                                                <p class="rating-des">{!! $review->message !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <h3 class="text-center"> No Review found.</h3>
                                @endforelse
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-6">
                        <div class="row h-100">
                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                <div class="card website-audit">

                                    <div class="card-body">
                                        <h3 class="">Mail Request</h3>
                                        <div class="grid">
                                            <section class="svg-section">
                                                <svg class="circle-chart w-100 h-100"
                                                    viewBox="0 0 33.83098862 33.83098862" width="120" height="120"
                                                    xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5"
                                                        stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431"
                                                        r="15.91549431" style="/* display: none; */"></circle>
                                                        @if ($emailrequestlogs)
                                                        <circle class="circle-chart__circle" stroke="#00c3ed"
                                                        stroke-width="2.5" stroke-dasharray="{{ $emailrequestlogs->remaining }},100"
                                                        stroke-linecap="round" fill="none" cx="16.91549431"
                                                        cy="16.91549431" r="15.91549431"></circle>
                                                        
                                                    @else
                                                    <circle class="circle-chart__circle" stroke="#00c3ed"
                                                    stroke-width="2.5" stroke-dasharray="{{ 0 }},100"
                                                    stroke-linecap="round" fill="none" cx="16.91549431"
                                                    cy="16.91549431" r="15.91549431"></circle>
                                                    @endif
                                                    

                                                </svg>
                                                <div class="svg-inner">
                                                    <img src="{{ asset('public/images/svg-inner-1.jpg') }}" />
                                                    @if ($emailrequestlogs)
                                                    <h3>{{ $emailrequestlogs->maximum - $emailrequestlogs->remaining }}</h3>

                                                        
                                                    @else
                                                        <h3>0</h3>
                                                    @endif
                                                    <p>Requests</p>
                                                </div>

                                            </section>
                                            <div class="row m-0 circle-info">
                                                <div>
                                                    <div class="circle-small blue-circle"></div>
                                                    {{-- <span class="text-muted">New: </span> --}}
                                                    <span class="text-muted">Max: </span>
                                                    @if ($emailrequestlogs)
                                                    <span>{{ $emailrequestlogs->maximum }}</span>
                                                        
                                                    @else
                                                        <span>0</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="circle-small gray-circle"></div>
                                                    {{-- <span class="text-muted">Returning: </span> --}}
                                                    <span class="text-muted">Remaining: </span>
                                                    @if ($emailrequestlogs)
                                                    <span>{{ $emailrequestlogs->remaining }}</span>
                                                        
                                                    @else
                                                        <span>0</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>
                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                <div class="card website-audit">

                                    <div class="card-body">
                                        <h3 class="">Sms Request</h3>
                                        <div class="grid">
                                            <section class="svg-section">
                                                <svg class="circle-chart w-100 h-100"
                                                    viewBox="0 0 33.83098862 33.83098862" width="120" height="120"
                                                    xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5"
                                                        stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431"
                                                        r="15.91549431" style="/* display: none; */"></circle>
                                                        @if ($smsrequestlogs)
                                                        <circle class="circle-chart__circle" stroke="#00cf00"
                                                        stroke-width="2.5" stroke-dasharray="{{ $smsrequestlogs->remaining*10 }},100"
                                                        stroke-linecap="round" fill="none" cx="16.91549431"
                                                        cy="16.91549431" r="15.91549431"></circle>
                                                        @else
                                                        <circle class="circle-chart__circle" stroke="#00cf00"
                                                        stroke-width="2.5" stroke-dasharray="{{ 0 }},100"
                                                        stroke-linecap="round" fill="none" cx="16.91549431"
                                                        cy="16.91549431" r="15.91549431"></circle>
                                                        @endif
                                                    

                                                </svg>
                                                <div class="svg-inner">
                                                    <img src="{{ asset('public/images/svg-inner-2.jpg') }}" />
                                                    @if ($smsrequestlogs)
                                                    <h3>{{ $smsrequestlogs->maximum - $smsrequestlogs->remaining }}</h3>
                                                        
                                                    @else
                                                        <h3>0</h3>
                                                    @endif
                                                    <p>Requests</p>
                                                </div>

                                            </section>
                                            <div class="row m-0 circle-info">
                                                <div>
                                                    <div class="circle-small blue-circle"></div>
                                                    {{-- <span class="text-muted">New: </span> --}}
                                                    <span class="text-muted">Max: </span>
                                                    @if ($smsrequestlogs)
                                                    <span>{{ $smsrequestlogs->maximum }}</span>
                                                        
                                                    @else
                                                        <span>0</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="circle-small green-circle"></div>
                                                    {{-- <span class="text-muted">Returning: </span> --}}
                                                    <span class="text-muted">Remaining: </span>
                                                    @if ($smsrequestlogs)
                                                    <span>{{ $smsrequestlogs->remaining }}</span>
                                                        
                                                    @else
                                                        <span>0</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                <div class="card website-audit" style="display: none">

                                    <div class="card-body line-card">
                                        <h3 class="">Website Traffic</h3>
                                        <h5>Unique visitors</h5>
                                        <h2>26,751</h2>

                                        <div class="line-chart">
                                            <div style="width: 55%; background-color: #2c99f8;"></div>
                                            <div style="width: 27%; background-color: #23d692;"></div>
                                            <div style="width: 16%; background-color: #fac545;"></div>
                                            <div style="width: 2%; background-color: #ff8e56;"></div>
                                        </div>

                                        <div class="border-bottom pt-4 pb-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <div class="circle-small"></div>
                                                    <span>Direct</span>
                                                </div>
                                                <div>14,750</div>
                                                <div>55%</div>
                                            </div>
                                        </div>
                                        <div class="border-bottom py-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <div class="circle-small green-circle"></div>
                                                    <span>Search</span>
                                                </div>
                                                <div>7,245</div>
                                                <div>27%</div>
                                            </div>
                                        </div>
                                        <div class="border-bottom py-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <div class="circle-small ref-circle"></div>
                                                    <span>Referrals</span>
                                                </div>
                                                <div>4,256</div>
                                                <div>16%</div>
                                            </div>
                                        </div>
                                        <div class="pt-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <div class="circle-small social-circle"></div>
                                                    <span>Social</span>
                                                </div>
                                                <div>500</div>
                                                <div>2%</div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card website-audit">
                                    <div class="card-head" style="width: 100%;padding: 30px 30px 0;">
                                        <h3 class="">SEO Audit Report</h3>

                                        {{--                                            <a href="https://staging.nichepractice.com/seo-audit"><label class="">View Report</label></a>--}}

                                        {{--                                            <p class="header-subtext">--}}
                                        {{--                                                barclayscenter.com--}}
                                        {{--                                            </p>--}}

                                    </div>
                                    <div class="card-body pt-0"
                                        style="display: flex;flex-direction: column;justify-content: space-around;">
                                        <div class="grid">
                                            
                                            @php
                                            if (isset($webResult)) {
                                                # code...
                                                $pageScore = !empty($webResult['score']) ? $webResult['score'] : 0;
                                            } else {
                                                # code...
                                                $pageScore = 0;
                                            }
                                            @endphp
                                            
                                            <section>
                                                <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862"
                                                    width="120" height="120" xmlns="http://www.w3.org/2000/svg"
                                                    style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5"
                                                        stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431"
                                                        r="15.91549431" style="/* display: none; */"></circle>
                                                    <circle class="circle-chart__circle" stroke="#00cf00"
                                                        stroke-width="2.5" stroke-dasharray="{{ $pageScore ?? 0 }} ,100"
                                                        stroke-linecap="round" fill="none" cx="16.91549431"
                                                        cy="16.91549431" r="15.91549431"></circle>

                                                    <g class="circle-chart__info">
                                                        <text class="circle-chart__percent" x="16.91549431" y="15.5"
                                                            alignment-baseline="central" text-anchor="middle"
                                                            font-size="8">{{ $pageScore ?? 0 }}
                                                        </text>
                                                    </g>
                                                </svg>
                                            </section>

                                        </div>
                                        <div class="audit-list">
                                            @if (isset($webResult))
                                                @if ($webResult)
                                                    <ul class="p-0">
                                                        <li>
                                                            <div class="list-item">
                                                                <span class="w-green"></span>
                                                                <span class="w-status">Passed</span>
                                                            </div>
                                                            <span>{{ $pageScore ?? 0 }}</span>
                                                        </li>
                                                        <li>
                                                            <div class="list-item">
                                                                <span class="w-red"></span>
                                                                <span class="w-status">Errors</span>
                                                            </div>
                                                            @if (isset($webResult))
                                                            <span>{{ getIndexedvalue($webResult, 'errorScore', 0) }}</span>
                                                            @else
                                                                <span>0</span>
                                                            @endif
                                                            
                                                        </li>
                                                        <li>
                                                            <div class="list-item">
                                                                <span class="w-orange"></span>
                                                                <span class="w-status">To Improve</span>
                                                            </div>
                                                            @if (isset($webResult))
                                                            <span>{{ getIndexedvalue($webResult, 'improveScore', 0) }}</span>
                                                            @else
                                                            <span>0</span>
                                                            @endif
                                                            
                                                        </li>

                                                    </ul>
                                                @else
                                                    <div>No Website Found</div>
                                                @endif
                                            
                                            @else
                                                <div>No Website Data Found</div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                <div class="card website-audit" style="display: none">

                                    <div class="card-body position-card">
                                        <h3 class="">Search Position Increase</h3>



                                        <div class="border-bottom pt-4 pb-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <a href="#.">Dermatology</a>
                                                </div>
                                                <div>14,750
                                                    <a href="#." class="link"><i class="fas fa-location-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom py-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <a href="#.">Botox</a>
                                                </div>
                                                <div>7,245
                                                    <a href="#." class="link"><i class="fas fa-location-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom py-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <a href="#.">Mole Removal</a>
                                                </div>
                                                <div>4,256
                                                    <a href="#." class="link"><i class="fas fa-location-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom py-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <a href="#.">Laser Surgery</a>
                                                </div>
                                                <div>500
                                                    <a href="#." class="link"><i class="fas fa-location-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" pt-3">
                                            <div class="row px-3 justify-content-between">
                                                <div>
                                                    <a href="#.">Freckles</a>
                                                </div>
                                                <div>1,905
                                                    <a href="#." class="link"><i class="fas fa-location-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card website-audit">
                                    <div class="card-head" style="width: 100%;padding: 30px 30px 0;">
                                        <h3 class="">Citation Listing</h3>

                                        {{--                                            <a href="https://staging.nichepractice.com/seo-audit"><label class="">View Report</label></a>--}}

                                        {{--                                            <p class="header-subtext">--}}
                                        {{--                                                barclayscenter.com--}}
                                        {{--                                            </p>--}}

                                    </div>
                                    <div class="card-body pt-0"
                                        style="display: flex;flex-direction: column;justify-content: space-around;">
                                        <div class="grid">
                                            <section>
                                                <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862"
                                                    width="120" height="120" xmlns="http://www.w3.org/2000/svg"
                                                    style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5"
                                                        stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431"
                                                        r="15.91549431" style="/* display: none; */"></circle>
                                                    <circle class="circle-chart__circle" stroke="#00c3ed"
                                                        stroke-width="2.5" stroke-dasharray="49,100"
                                                        stroke-linecap="round" fill="none" cx="16.91549431"
                                                        cy="16.91549431" r="15.91549431"></circle>

                                                    <g class="circle-chart__info">
                                                        <text class="circle-chart__percent" x="16.91549431" y="15.5"
                                                            alignment-baseline="central" text-anchor="middle"
                                                            font-size="8">49
                                                        </text>
                                                    </g>
                                                </svg>
                                            </section>

                                        </div>
                                        <div class="statuses text-center">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3>6</h3>
                                                    <label>CORRECT</label>
                                                </div>
                                                <div class="col-6">

                                                    <h3>2</h3>
                                                    <label>ERRORS</label>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer -->
                @include('partials.footer')
                <!-- Footer -->
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="status" value="{{ $userData['discovery_status'] }}" />
<input type="hidden" id="first-name" value="{{ $userData['first_name'] }}" />

@if(!empty($userData['business'][0]['website']))
{{--        iframe--}}
@endif
@endsection

@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script src="{{ asset('public/js/home.js?ver='.$appFileVersion) }}"></script>
<script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>
<script>
    var ratingMonths = [];
    var ratingNumbers = [];
    var reviewMonths = [];
    var reviewNumbers = [];

    $('.review-column p').fewlines(
        {
            lines : 3,
            openMark : ' See More',
            closeMark : ' See Less',
            newLine: false,
        }
    );
    // first widget




    $(function () {
        // $("#review-chart-container .highcharts-root").attr("viewBox" , "60 0 230 400")

        // $("#public-reviews-chart .highcharts-root").attr("viewBox" , "0 0 472 200")


        var svgimg = document.createElementNS('http://www.w3.org/2000/svg', 'image');
        svgimg.setAttributeNS(null, 'height', '200');
        svgimg.setAttributeNS(null, 'width', '30');

        svgimg.setAttributeNS('http://www.w3.org/1999/xlink', 'href', "{{ asset('public/images/custom-marker.png') }}");
        svgimg.setAttributeNS(null, 'x', '216');
        svgimg.setAttributeNS(null, 'y', '-50');
        svgimg.setAttributeNS(null, 'visibility', 'visible');

        $("#public-reviews-chart .highcharts-series-0 rect:nth-child(7)").after(svgimg);


        var circleVal = 60;
        var t = -45 - (1.8 * (100 - circleVal))
        if (circleVal >= 75) {
            circleStats = "";
        } else if (circleVal >= 55) {
            circleStats = "good";
        } else if (circleVal >= 0) {
            circleStats = "danger";
        }
        console.log('t')
        console.log(t)
        // $(".half-circle.prog").css({
        //     'transform': 'rotate(' + t + 'deg)'
        // }).addClass(circleStats)

        $.ajax({
            type: "get",
            url: "{{ route('statTrackingReviewData') }}"
        }).done(function (data) { 
            console.log(data);
            var reviewMonths = [];
            var reviewNumbers = [];
            for (let index = 0; index < data.length; index++) {
                reviewMonths[index] = data[index].activity_date;
                reviewNumbers[index] = parseInt(data[index].count);
                
            }
            console.log(reviewNumbers);
                // second widget
    var chart = Highcharts.chart('public-reviews-chart', {

title: {
    text: 'Chart.update',
    visible: false
},

subtitle: {
    text: 'Plain',
    visible: false
},

xAxis: {
    // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    categories: reviewMonths
},
yAxis: [{ // Secondary yAxis

    opposite: true,
    visible: false
}],
tooltip: {
    valueSuffix: ' Reviews'
},
credits: {
    enabled: false
},

series: [{
    name: 'Review',
    type: 'column',
    // colorKey: 'colorValue',
    // color: '#FF0000',
    // colorByPoint: true,
    // data: [70, 185, 135, 230, 195, 180, 220, 230, 350, 290, 320, 360],
    data: reviewNumbers,
    showInLegend: false
}],
responsive: {
    rules: [{
        condition: {
            maxWidth: 400
        },
        chartOptions: {
            legend: {
                align: 'center',
                verticalAlign: 'bottom',
                layout: 'horizontal'
            },
            subtitle: {
                text: null
            },
            credits: {
                enabled: false
            }
        }
    }]
}

});
         }).fail(function (error) { 
            console.log(error);
         });
         $.ajax({
            type: "get",
            url: "{{ route('statTrackingRatingData') }}"
        }).done(function (data) { 
            console.log(data);
            
            for (let index = 0; index < data.length; index++) {
                ratingMonths[index] = data[index].activity_date;
                ratingNumbers[index] = parseInt(data[index].count);

                
            }

            Highcharts.chart('review-chart-container', {
        chart: {
            type: 'column',
            scrollablePlotArea: {
                minWidth: 180,
                scrollPositionX: 1
            }
        },
        title: {
            text: 'Wind speed during two days',
            align: 'left'
        },
        subtitle: {
            text: '13th & 14th of February, 2018 at two locations in Vik i Sogn, Norway',
            align: 'left'
        },
        xAxis: {
            // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            categories: ratingMonths
        },
        yAxis: {
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            visible: false

        },
        tooltip: {
            valueSuffix: ' Star'
        },
        plotOptions: {
            spline: {
                lineWidth: 4,
                states: {
                    hover: {
                        lineWidth: 5
                    }
                },
                marker: {
                    enabled: false
                },

            }
        },
        series: [{
            name: 'Rating',
            // data: [3.1, 4.2, 6.13, 8.05, 6.1, 4.99, 3.2, 4.26, 6.3, 7.35, 5.4]
            data: ratingNumbers

        }/* , {
            name: 'Gray',
            data: [
                3.15, 3.1, 2.95, 2.96, 2.94, 2.95, 2.93, 3.1, 3.15, 3.19, 3.13, 3.2,



            ]
        } */],
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 200
                },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -5
                        },
                        title: {
                            text: null
                        }
                    },
                    subtitle: {
                        text: null
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });

         }).fail(function (error) { 
            console.log(error);
         });




console.log('reviewNumbers');
console.log(reviewNumbers);
    })

</script>
@endsection
