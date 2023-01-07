<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
{{--    <link type="text/css" href="{{ asset('public/css/bootstrap-4.min.css') }}" rel="stylesheet" />--}}
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('public/css/reviews-recipient/style.css?ver='.$appFileVersion) }}" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon.png') }}" />

    <title>{{ getDynamicAppName() }}</title>

    <style>
        .pop-box-header h3 {
            word-break: unset !important;
            word-wrap: break-word !important;
        }
    </style>
</head>
<body>

<div class="fb-wrapper">
    <div class="container">
        <div class="row">

        <div class="popup-box">
                <div class="pop-box-header">
                    <div class="popup-back-btn hide-popup-back-btn">
                        <img src="{{ asset('public/images/feedback-review/fb-back.png') }}" alt="Like">
                    </div>

                    <h3 id="bussinessTitle" class="business-title">{{ str_replace('+', ' ', $name) }}</h3>

                    {{--<div class="ppl-logo">--}}
                        {{--<img src="{{ asset(getDynamicLogoPath()) }}" alt="">--}}
                    {{--</div>--}}

                    @if(!empty($message))
                        <h4 class="review-content">{{ $message }}</h4>
                    @else
                        {{--<h4 class="review-content">Your feedback is important to us. Would you recommend us to your friends and family?</h4>--}}
                        <h4 id="reviewContent" class="review-content">Thumbs up if you were happy with our service. <br> Thumbs down if we didn’t meet your expectations.</h4>
                    @endif
                </div>
                @if(empty($message))
                <div class="pop-box-body Interactive-box">
                    <div id="thumbLinksBox" class="row">

                            <div class="col text-right">
                                <a href="javascript:void(0)" class="thumb-action" data-thumb-action="up">
                                    <img src="{{ asset('public/images/feedback-review/like.png') }}" alt="Like">
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:void(0)" class="thumb-action" data-thumb-action="down">
                                    <img src="{{ asset('public/images/feedback-review/dislike.png') }}" alt="Dislike">
                                </a>
                            </div>

                    </div>
                </div>
                @endif
                <div class="alert alert-danger" style="display: none;margin-top: 10px;text-align: center;"></div>
                <img class="loader" style="display: none;" src="{{ asset('public/images/loader.gif') }}">

                <div id="poweredBy" class="pop-box-footer">
                    <label>Powered by <a href="javascript:void(0);"><span>{{getDynamicAppName()}}</span></a></label>
                </div>

            </div>

    </div>
    </div>
</div>

{{ csrf_field() }}

<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
<input type="hidden" id="email" value="{{ $email }}" />
<input type="hidden" id="name" value="{{ $name }}" />
<input type="hidden" id="secret" value="{{ $secret }}" />
<input type="hidden" id="reviewID" value="{{ $reviewID }}" />

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{--<script src="{{ asset('public/js/jquery.min.js') }}"></script>--}}
<script src="{{ asset('public/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('public/js/recipient/popper.min.js') }}"></script>
{{--<script src="{{ asset('public/js/bootstrap-4.min.js') }}"></script>--}}
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

@if(empty($pageType))
<script src="{{ asset('public/js/recipient/business-review.js?ver='.$appFileVersion) }}"></script>
@endif
<script>
    var pathArray = window.location.pathname.split('/');
    var pathArraySize = pathArray.length;
    var pathArrayLastIndex = pathArray[pathArraySize -1];
    if (pathArrayLastIndex == 'positive') {
        console.log('positive');
        $(".Interactive-box").hide();
        $("#bussinessTitle").hide();
        $("#reviewContent").hide();
        $("#thumbLinksBox").hide();
        $("#poweredBy").hide();
                saveFeedback('up');
    } else if (pathArrayLastIndex == 'negative') {
        console.log('negative');
        $("#thumbLinksBox").hide();
        $(".review-content").html("We're sorry to hear that we were not able to meet your expectations. We would like to know more about what happened so we can take the necessary action to improve our products and services in the future.");

                $('.popup-back-btn').removeClass('hide-popup-back-btn');

                var html = "";

                html  = '<div class="form-group">';
                html  += '<textarea id="message" class="form-control" rows="10" style="resize: none;"></textarea>';
                html  += '<span class="error" style="display: none;">Error found.</span>';
                html  += '</div>';
                html  += '<div class="form-group text-center">';
                html  += '<button class="btn btn-info popbox-action-btn send-feedback">Send Feedback</button>';
                html  += '</div>';

                $(".Interactive-box").html(html);
        
    }
</script>
</body>
</html>
