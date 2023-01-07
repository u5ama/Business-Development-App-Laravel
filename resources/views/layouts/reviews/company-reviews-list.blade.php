<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap-4.3.1.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/fontawesome-5/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/company-reviews.css?ver='.$appFileVersion) }}" rel="stylesheet">
    <link href="{{ asset('public/css/custom.css?ver='.$appFileVersion) }}" rel="stylesheet">
    <title>Reviews</title>


</head>
<body>


<header class="header-main">
    <div class="container-fluid">
        <nav>
            <div class="row mx-3 main-nav">
                <!-- logo -->
                <a href="{{ route('home') }}">
                    <img src="{{ imageReturn('brand/logo-black.png') }}" alt="" style="max-height: 2.5rem;text-align: center;display: block;" class="img-fluid" />
                </a>
                <!-- nav button -->
                <div class="d-flex align-items-center">

                    {{-- <a href="#" class="search-btn mr-4">
                        <i class="fas fa-search"></i>
                    </a> --}}

{{--                    <a href="#" class="search-btn mr-4">--}}
{{--                        <i class="fas fa-search"></i>--}}
{{--                    </a>--}}

                    <button class="btn btn-green-border">Are you a business? Click Here</button>
                </div>
            </div>
        </nav>

    </div>

</header>

<section class="bg-light-gray mt-80">
    <div class="container pt-5 px-sm-0">
        <div class="row">
            <div class="col-md-11 col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="font-size: 1.75rem;" class="font-bold">{{ $userBusiness['practice_name'] }}</h2>
                        <h3 style="color: #ff7849;" class="py-1">
                            @for ($i = 0; $i < floor($overAllRating); $i++)
                            <i class="fas fa-star"></i>

                            @endfor
                            {{-- <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i> --}}

                        </h3>
                        {{-- <span class="rating">
                                <span class="rating-value" style="{{'width:'.$overAllRating*'20'.'%'}}"></span>
                            </span> --}}
                        <p>
                            <b id="ratings">{{ round($overAllRating,2) ?? '0'}}</b>
                            <span>Ratings</span>
                            <b id="reviews">{{ $publicReviews }}</b>
                            <span>Reviews</span>
                        </p>

                        {{-- <a class="btn company-btn" href="#">
                            <img src="{{ imageReturn('icon-company-reviews.svg') }}" alt="" class="company-img">
                            <b>Company Reviews</b>
                        </a> --}}
                    </div>
{{--<<<<<<< HEAD--}}
                    {{-- <div class="col-md-4 mb-md-0 mb-4">
=======
                    <div class="col-md-4 mb-md-0 mb-4 ">
                        <div class="right-box mr-md-0 mr-auto">
                            <div class="stats-circle">
                                <div class="half-circle"></div>
                                <div class="half-circle prog"></div>
                                <div class="prog-text">
                                    <span class="prog-per">94</span>
                                    <span class="prog-sign">%</span>
                                </div>
                            </div>
                            <span style="font-family: 'Gotham_Light'; font-size:15px;display: block;margin: 8px 0 -4px 0;">of reviewers recommend</span>
                            <span style="font-family: 'Gotham_Medium'; font-size:15px">{{ $userBusiness['practice_name'] }}</span>
                        </div>



                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>





<section class="body-cont mt-5">
    <div class="container px-0">
        <div class="row">
            <div class="col-lg-11 col-md-12 mx-auto">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div>
                            <div class="MapPreview" id="MapPreview">
                            </div>

                            <script>
                                setTimeout(function(){
                                    document.getElementById('MapPreview').innerHTML = '<iframe loading="lazy" \
                                    style="border:0;width:100%" \
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAhqTpH_emIUh33S3w1YYjl1yoXcq-7lwc&q=EX2+8QW" \
                                     \
                            > \
                            </iframe>';
                                }, 1000);
                            </script>

                            <div class="row">
                                <div class="col-sm-12 text-center">

                                    @if ($userData['business'][0]['logo'])
                                    <img src="{{ asset('storage/app/'.$userData['business'][0]['logo']) }}" alt=""  class="p-3 img-fluid"/>
                                    @else
                                    <img src="{{ asset('public/images/brand/logounavailable.png') }}" alt=""  class="p-3 img-fluid"/>
                                    @endif

                                </div>
                                @if ($userData['business'][0]['website'])
                                <div class="col-sm-12 text-center mt-5">
                                <a class="btn btn-black-border w-100" href="{{ $userData['business'][0]['website'] }}">Visit Website</a>
                                </div>
                                @endif


                                <div class="col-sm-12 mt-4">
                                    <h6 class="font-bold mb-0">Phone:</h6>
                                    <h6 class="font-light mb-3">{{ $userData['business'][0]['phone'] ?? '+92 123 456 7890' }}</h6>

                                    <h6 class="font-bold mb-0">Email:</h6>
                                    <h6 class="font-light mb-0">{{ $userData['email'] }}</h6>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8 col-ms-12 border-md-none" style="border-left: 1px solid rgba(73,73,79,.1);">


                        <div class="review-box">

                            <div class="review-inner">
                                <div class="review-buttons">
                                    <h4 class="font-bold">Write Your review</h4>
                                    <div class="d-flex" style="flex-direction: row-reverse;">
                                        <a rel="nofollow" data-rating="5" class="review-link" data-text="Tell us how Trustyy made you happy">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a rel="nofollow" data-rating="4" class="review-link" data-text="Tell us how Trustyy made you happy">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a rel="nofollow" data-rating="3" class="review-link" data-text="Tell us how Trustyy made you happy">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a rel="nofollow" data-rating="2" class="review-link" data-text="Sorry to hear that you had a bad experience with Trustyy, What went wrong?">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a rel="nofollow" data-rating="1" class="review-link" data-text="Sorry to hear that you had a bad experience with Trustyy, What went wrong?">
                                            <i class="fas fa-star"></i>
                                        </a>
                                    </div>
                                </div>


                                <div class="bg-shapes">
                                    <picture>
                                        <img class="shapes-left" src="{{ imageReturn('shape_dots.png') }}">
                                    </picture>
                                    <picture>
                                        <img class="shapes-right" src="{{ imageReturn('shape_dots.png') }}">
                                    </picture>
                                </div>
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-sm-12 d-none" id="review-form">
                                <form class="WriteReviewForm  bg-light px-3 py-4 mb-4" onsubmit="event.preventDefault();">
                                    <div class="WriteReviewForm__inner">
                                        <div class="WriteReviewForm__list">
                                            <div class="WriteReviewForm__item">
                                                <div id="commentsLabel" class="WriteReviewForm__heading">
                                                    Tell us how Trustyy made you happy
                                                </div>
                                                <div class="WriteReviewForm__subheading">
                                                    Help future customers by talking about customer service, price, delivery, returns &amp; refunds.
                                                </div>
                                                <textarea id="comments" class="WriteReviewForm__textarea w-100" required minlength="10"></textarea>
                                                <div id="commentscount" class="WriteReviewForm__smalltext">
                                                    Minimum 10 characters
                                                </div>
                                                <div id="review_error_comment_output" class="pull-left" style="color: #c70606; font-size: 11px;"></div>
                                            </div>



                                            <div class="WriteReviewForm__item">
                                                <div class="WriteReviewForm__heading">
                                                    What&#039;s your name?
                                                </div>
                                                <div class="WriteReviewForm__subheading">
                                                    Leave this blank if you&#039;d like to publish your review anonymously.
                                                </div>
                                                <input id="name" type="text" class="WriteReviewForm__input">
                                                <div class="WriteReviewForm__smalltext">
                                                    (Optional)
                                                </div>
                                                <div id="review_error_name_output" class="pull-left" style="color: #c70606; font-size: 11px;"></div>
                                            </div>
                                            <div class="WriteReviewForm__item">
                                                <div class="WriteReviewForm__heading">
                                                    What&#039;s your email?
                                                </div>
                                                <div class="WriteReviewForm__subheading">
                                                    We need your email address to verify that your review is genuine
                                                </div>
                                                <input id="email" type="email" class="WriteReviewForm__input" required>
                                                <div id="review_error_email_output" class="pull-left" style="color: #c70606; font-size: 11px;"></div>
                                            </div>
                                        </div>
                                        <div class="WriteReviewForm__footer">
                                            <button id="submitReview" class="btn Button--green" onclick="createReview(false)">
                                                <div id="review_submit_loading" class="ruk_loading pull-left" style="height: 14px; width: 14px; margin-right: 15px; display: none;"></div>
                                                Submit Review
                                            </button>
                                            <div id="review_error_main_output" class="pull-left" style="color: #c70606; font-size: 13px;"></div>
                                            <div style="font-size: 11px; padding: 10px; color: #757575; text-align: center;padding-bottom:20px;">
                                                You will be contacted by email to verify your review.<br />
                                                By submitting your review you agree to the Reviews.io <a href="/front/termsconditions">terms &amp; conditions</a>.<br />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 text-right">
                                <div class="dropdown d-inline">
                                    <button class="btn btn-transparent dropdown-toggle font-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Sort by: <span class="font-bold">Most Recent</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Most Recent</a>
                                        <a class="dropdown-item" href="#">Most Rated</a>
                                        <a class="dropdown-item" href="#">Top Viewed</a>
                                    </div>
                                </div>


                                <div class="dropdown d-inline">
                                    <button class="btn btn-transparent dropdown-toggle font-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter: <span class="font-bold">None</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">None</a>
                                        <a class="dropdown-item" href="#">5 Star</a>
                                        <a class="dropdown-item" href="#">4 Star</a>
                                        <a class="dropdown-item" href="#">3 Star</a>
                                        <a class="dropdown-item" href="#">2 Star</a>
                                        <a class="dropdown-item" href="#">1 Star</a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- all reviews -->

                        <div class="row">
                            <div class="col-sm-12">
                                @forelse ($allReviews as $review)
                                    <!-- rating box -->
                                <div class="rating-box">
                                    <div class="rating-heading">
                                        <h5 class="font-bold">{{ $review->reviewer }}</h5>
                                        <h5 style="color: #ff7849;" class="pl-2">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </h5>
                                        <span class="ml-2" data-toggle="tooltip" data-placement="top" title="Self-verified Reviewer">
                                            <img src="{{ imageReturn('tick.svg') }}" alt="" style="width: 25px; height: 25px;">
                                        </span>
                                    </div>

                                    <div class="discription">
                                        @if ($review->message)
                                            <div class="review-column">
                                                <p>
                                                    <span class="quote-up">“</span>
                                                        {!! $review->message !!}
                                                    <span class="quote-down">”</span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <h6 class="text-right font-light text-small">
                                        Posted {{ date_diff(date_create($review->review_date), date_create(date('yy-m-d')))->format("%a") }} days ago
                                    </h6>
                                    <hr class="my-4">
                                </div>
                                @empty
                                    <h3 class="text-center"> No Review found.</h3>
                                @endforelse


                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-12 text-center">
                                {{ $allReviews->links()}}

                                <p class="text-muted small-text font-noraml"><a href="#." class="text-dark font-bold">{{ $userBusiness['practice_name'] }}</a> is rated {{ round($overAllRating,2) ?? '0'}} based on {{ $publicReviews }} reviews</p>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- footer -->


<footer style="box-shadow: 0 0 10px 45px #00000005; display: none">
    <div class="container py-5 px-0">
        <div class="row">
            <div class="col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-sm-6 footer-list">
                        <h6>Our Company</h6>
                        <h6>
                            <a href="#." class="text-dark font-light text-small">Business Solutions</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">Impressum</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">Terms & Conditions</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">User Privacy Policy</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">Business User Privacy Policy</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">Data Protection</a>
                        </h6>

                        <h6>
                            <a href="#." class="text-dark font-light text-small">Data Request</a>
                        </h6>

                    </div>


                    <div class="col-sm-6 text-right">
                        <a href="{{ route('home') }}">
                            <img src="{{ imageReturn('brand/logo-black.png') }}" alt="" style="max-height: 2.5rem;text-align: center;" class="footer-logo" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/popper.js') }}"></script>
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>
<script>
    
    $('.review-column p').fewlines(
        {
            lines : 3,
            openMark : ' See More',
            closeMark : ' See Less',
            newLine: false,
        }
    );
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()

        $(".review-link").on("click", function () {
            $(this).addClass("active").nextAll().addClass("active");
            $(this).prevAll().removeClass("active");

            $("#commentsLabel").text($(this).data('text'));

            $("#review-form").removeClass("d-none")
        })
    })


</script>
</body>
</html>
