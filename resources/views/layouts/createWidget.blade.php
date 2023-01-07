@extends('index')

@section('pageTitle', 'Widgets')
@section('css')
<style>
    .carousel-indicators li {

        border-radius: 50%;
        width: 10px;
        height: 10px;

        background-color: rgba(255, 255, 255, .5);

    }

    .widget-selected {
        border: #00C3ED 3px solid;
        /* border-radius: 10px; */
    }

    .slide a:hover {
        background: transparent !important;
    }

    .field-expnd {
        width: 97%;
    }

    .settings-input {
        background-color: #f5fafd;
        border: 1px solid #dae0ef;
    }

    .settings-input:focus {
        background-color: #e4f3ff;
        color: #000;
    }

    .color-changing-btn {
        width: 30px;
        height: 30px;
        background-color: transparent;
        border: none;
        outline: none !important;
        box-shadow: none !important;
        border-radius: 4px;
        cursor: pointer;
        position: absolute;
        top: 72%;
        right: 10px;
        transform: translateY(-50%);
    }

    .col-after::after {
        content: " ";
        display: block;
        position: absolute;
        height: 100%;
        background-color: #cccccc;
        width: 1px;
        right: -10%;
        top: 0;
    }

    .card-title {
        margin: 0;
    }

    .widget-search {
        padding: 7px;
        border-radius: 5px;
        border: none;
        background: #fff;
        outline: none;
        box-shadow: none;
        position: relative;
        display: inline-block;
    }

    .widget-search input {
        border: none;
        background-color: transparent;
        outline: none;
        box-shadow: none;
        padding-left: 25px;
    }
    q {
    quotes: "“" "”" "‘" "’";
}

/* insert the quotes using pseudo-elements and the `content` property */

    q:before {
    content: open-quote;
}

q:after {
    content: close-quote;
}

q:before, q:after {
    color: #F97777;
    /* font-size: 20px; */
    padding-left: 4px;
    padding-right: 4px;
}
</style>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
<link type="text/css" rel="stylesheet"
    href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">

@endsection
@section('content')

{{-- <div id="single_quote" class="mt-5">
    <div class="container rounded shadow mb-3 p-3">
        <div class="text-center">
            <img src="http://localhost/trustyy/public/images/avatardp.png" alt="" class="rounded-circle"
            style="
            width: 60px;
            height: 60px;
            position: relative;
            top: -40px;">
            <span style="position: relative;
            top: -15px;
            left: -15px;"><i class="fab fa-google text-right"></i></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="three-multi-review quote_font_color review-column text-center">
                    <p><q>No review for this user.</q></p>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <h4 class="author_font_color three-multi-review">Ibtisam Tahir</h4>
            </div>
            <div class="col-md-6 text-center text-md-left">
                <div class="three-multi-review">
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img class="img-fluid" src="http://localhost/trustyy/public/images/brand/logo-black.png" style="height:28px;">
        </div>
    </div>
</div> --}}

{{-- <div id="grid" class="mt-5">
    <div class="container rounded shadow mb-3 p-3">
        <div class="text-center">
            <img src="http://localhost/trustyy/public/images/avatardp.png" alt="" class="rounded-circle"
            style="
            width: 60px;
            height: 60px;
            position: relative;
            top: -40px;">
            <span style="position: relative;
            top: -15px;
            left: -15px;"><i class="fab fa-google text-right"></i></span>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="author_font_color three-multi-review">Ibtisam Tahir</h4>
            </div>
            <div class="col-md-12">
                <div class="three-multi-review quote_font_color review-column text-center">
                    <p><q>No review for this user.</q></p>
                </div>
            </div>
          
            <div class="col-md-12 text-center">
                <div class="three-multi-review">
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                    <span><i class="fa fa-star" style="color:#F7B707;"></i></span>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img class="img-fluid" src="http://localhost/trustyy/public/images/brand/logo-black.png" style="height:28px;">
        </div>
    </div>
</div> --}}

<div class="app-content widgets-list">
    <div class="side-app">
        <div class="main-content">
            <div class="p-2 d-block d-sm-none navbar-sm-search">
                <div class="form-group mb-0">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div><input class="form-control" placeholder="Search" type="text">
                    </div>
                </div>
            </div>

            <div class="container-fluid pt-30px">
                @include('partials.topnavbar')

                <form id="createWidgetForm">
                    <div class="container-fluid pt-5">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="h4">Create a New Widget</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="h5" for="widget_name">1. Name Your Widget</label>
                                    <input type="text" class="form-control" id="widget_name" name="widget_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="WidgetTypeContainer" style="display: none;">
                        <div class="container-fluid pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="h4">2. Select Your Widget Type</h4>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid p-1">
                            <div class="row">
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="Slider">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">Slider</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/Slider.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="MultiSlider">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">Multi Slider</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/multiSlider.png') }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="List">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">List</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/Grid.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="Grid">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">Grid</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/Grid.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="SingleQuote">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">Single Quote</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/singleQuote.png') }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card widget-type" data-value="Badge">
                                        <div class="card-header p-3">
                                            <h5 class="card-title">Badge</h5>
                                        </div>
                                        <div class="card-body p-5">
                                            <img src="{{ asset('public/images/singleQuote.png') }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="WidgetSettingPreviewContainer" style="display: none;">
                        <div class="container-fluid pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="h4">3. Settings</h4>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid p-3">
                            <div class="row position-relative">
                                <div class="col-md-3 border-right">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                role="tab" aria-controls="home" aria-selected="true">Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                                role="tab" aria-controls="profile" aria-selected="false">Theme</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                            aria-labelledby="home-tab">
                                            <div class="p-4 position-relative">
                                                <h3>Number of Reviews</h3>
                                                <input id="number_of_reviews" type="range" min="1" max="10" value="3"
                                                    class="form-control-range">
                                                <span id="number_of_reviews_preview"></span>
                                            </div>
                                            <div class="p-4 position-relative">
                                                <h3>Minimum Rating</h3>
                                                <input id="minimum_rating" type="range" min="1" max="5" value="3"
                                                    type="range" class="form-control-range">
                                                <span id="minimum_rating_preview"></span>
                                            </div>
                                            <div class="p-4">
                                                <div class="form-group">
                                                    <label for="sort_review_by">Sort Reviews By</label>
                                                    <select class="form-control" name="sort_review_by"
                                                        id="sort_review_by">
                                                        <option value="Date">Date</option>
                                                        <option value="Rating">Rating</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="pl-4 d-flex w-100">
                                                <div>
                                                    <h3>Scheme Markup</h3>
                                                </div>
                                                <div class="float-right btn-with-toggle ml-auto ">
                                                    <input type="checkbox" name="schema_markup" value="1"
                                                        id="schema_markup">
                                                    <label for="schema_markup" class="mr-4"></label>
                                                </div>
                                            </div>
                                            <button id="settingWidgetButton"
                                                class="btn text-center btn-green mt-3 float-right"
                                                type="button">Save</button>
                                        </div>

                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="p-4">
                                                <div class="form-group w-100">
                                                    <label for="font_style">Font</label>
                                                    <select class="form-control" name="font_style" id="font_style">
                                                        <option value="'Roboto', sans-serif">'Roboto', sans-serif
                                                        </option>
                                                        <option value="'Open Sans', sans-serif">'Open Sans', sans-serif
                                                        </option>
                                                        <option value="'Ubuntu', sans-serif">'Ubuntu', sans-serif
                                                        </option>
                                                        <option value="'Sriracha', cursive">'Sriracha', cursive</option>
                                                        <option value="'Metal Mania', cursive">'Metal Mania', cursive
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="pl-4 pt-1 position-relative field-expnd">
                                                <label for="background_color">Background</label><br />
                                                <input type="text" name="background_color" id="background_color_text"
                                                    class="settings-input form-control" value="#ededed">
                                                <input type="color" id="background_color" name="background_color"
                                                    value="#ededed" class="color-changing-btn">
                                            </div>
                                            <div class="pl-4 pt-1 position-relative field-expnd">
                                                <label for="star_color">Stars</label><br />
                                                <input type="text" id="star_color_text" name="star_color"
                                                    class="settings-input form-control" value="#F7B707">
                                                <input type="color" id="star_color" name="star_color" value="#F7B707"
                                                    class="color-changing-btn">
                                            </div>
                                            <div class="pl-4 pt-1 position-relative field-expnd">
                                                <label for="author_font_color">Author Font Color</label><br />
                                                <input type="text" id="author_font_color_text" name="author_font_color"
                                                    class="settings-input form-control" value="#000000">
                                                <input type="color" id="author_font_color" name="author_font_color"
                                                    value="#000000" class="color-changing-btn">
                                            </div>
                                            <div class="pl-4 pt-1 position-relative field-expnd">
                                                <label for="quote_font_color">Quote Font Color</label><br />
                                                <input type="text" id="quote_font_color_text" name="quote_font_color"
                                                    class="settings-input form-control" value="#000000">
                                                <input type="color" id="quote_font_color" name="quote_font_color"
                                                    value="#000000" class="color-changing-btn">
                                            </div>
                                            <div class="pl-4 pt-1 position-relative field-expnd">
                                                <label for="date_color">Date Font Color</label><br />
                                                <input type="text" id="date_color_text" name="date_color"
                                                    class="settings-input form-control" value="#000000">
                                                <input type="color" id="date_color" name="date_color" value="#000000"
                                                    class="color-changing-btn">
                                            </div>
                                            <button id="themeWidgetButton"
                                                class="btn text-center btn-green mt-3 float-right"
                                                type="button">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="text-center">Preview</h4>
                                    {{-- preview card starts --}}
                                    <div id="preview_card" class="card"></div>
                                    {{-- preview card ends --}}
                                </div>
                            </div>
                            <div class="container-fluid p-5">
                                <div class="row">
                                    <div class="col-11 text-center pt-3">
                                        <button id="createWidget" class="btn text-center btn-green"
                                            style="display: none;" type="button">Create Widget</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="WidgetEmbededCodeContainer" class="card" style="display: none;">
                    <div class="card-header">
                        Embed Code
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="codetextarea" style="width:100%;height:80px"
                            placeholder="Emded code here"></textarea>
                        <button onclick="copyClipBoard()" class="mt-4 btn float-right btn-primary" type="button">Copy to
                            Clipboard</button>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button type="button" class="btn mr-3 btn-green">Create Another Widget</button>
                        <button type="button" class="btn btn-primary">Done</button>
                    </div>
                </div>



                <!-- <img src="{{ asset('public/images/createWidget.png') }}" alt="" class="img-fluid"> -->

                @include('partials.footer')

            </div>

        </div>
    </div>
</div>
@endsection

@section('js')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/widgets/create-widgets.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>
<script>
    $(document).ready(function () {
        // seemore
        $('.review-column p').fewlines({
            lines: 4,
            openMark: ' See More',
            closeMark: ' See Less',
            newLine: false,
        });
    });

</script>
@endsection
