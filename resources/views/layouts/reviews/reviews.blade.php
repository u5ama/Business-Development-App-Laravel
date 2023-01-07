@extends('index')

@section('pageTitle', 'Reviews')

@section('content')
    <div class="app-content">
        <div class="side-app">
            <div class="main-content reviews-panel">
                <div class="container-fluid pt-30px">
                    @include('partials.topnavbar')

                    <div class="row">
                        <div class="col-sm-12">
                                <div class="row py-3">
                                    <div class="col-md-2">
                                        <h1 class="m-0">Reviews</h1> {{-- <span class="text-muted text-nowrap">&nbsp;</span> --}}

                                    </div>
                                    <div class="col-md-4">
                                        <div class="side-input-box">
                                            <div class="head-search-review">
                                                <input id="search-table" type="text" class="form-control" placeholder="Search a Review" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group sources-list">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-text="All Sources">
                                                    <span class="filter-label">All Sources</span>
                                                    <span class="caret"></span>
                                                </button>

                                                <ul data-filter-type="sources-list" data-filter="5" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    {{--<li>--}}
                                                        {{--<a href="javascript:void(0);">--}}
                                                            {{--<div class="checkbox checkbox-primary">--}}
                                                                {{--<input id="checkbox2" class="styled" type="checkbox">--}}
                                                                {{--<label for="checkbox2">--}}
                                                                    {{--Select All--}}
                                                                {{--</label>--}}
                                                            {{--</div>--}}
                                                        {{--</a>--}}
                                                    {{--</li>--}}

                                                    <li role="separator" class="divider"></li>

                                                    {{-- <li class="source-row" data-source="nichepractice">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary"><input id="" class="styled" type="checkbox">
                                                                <label for="checkbox2">
                                                                    <img src="{{ asset('public/images/favicon.png') }}" />
                                                                    Nichepractice
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li> --}}

                                                    <?php
                                                    // $sources = ['Zocdoc', 'Google', 'Facebook', 'Yelp', 'Foursquare'];
                                                    $sources = thirdPartySources();
                                                    foreach($sources as $source)
                                                    {
                                                    $reviewType = trim(str_replace("places", "", strtolower($source)));
                                                    $sourceType = ucFirst($reviewType);
                                                    ?>
                                                    <li class="source-row" data-source="{{ $reviewType }}">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary"><input id="" class="styled" type="checkbox">
                                                                <label for="checkbox2" style="color: black">
                                                                    <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}" style="height: 24px;"/>
                                                                    {{ $sourceType }}
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group ratings-list">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="true" data-text="All Ratings">
                                                    <span class="filter-label">All Ratings</span>
                                                    <span class="caret"></span>
                                                </button>

                                                <ul data-filter-type="ratings-list" data-filter="1" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    @for($i = 5; $i>=1; $i--)
                                                    <li class="source-row" data-source="{{ $i }}">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="{{ $i }}" class="styled" type="checkbox">
                                                                <label for="{{ $i }}"  style="color: black">
                                                                    <div class="g-rating-stars">
                                                                        <span><i class="active fa fa-star" style="color: #FFC000;"></i></span>
                                                                        @if($i == 1)
                                                                            {{ $i }} Star
                                                                        @else
                                                                        {{ $i }} Stars
                                                                        @endif
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle date-ordering" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    All Time
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu ordering-date" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-item p-1"><a href="javascript:void(0);"  style="color: black" data-action="newest">Newest</a></li>
                                                    <li class="dropdown-item p-1"><a href="javascript:void(0);"  style="color: black" data-action="oldest">Oldest</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              All Sources
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @foreach ($sources as $source)
                                                <div class="p-1">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="{{'source-'.$source}}" value="{{$source}}">
                                                        <label class="form-check-label" for="{{'source-'.$source}}">{{$source}}</label>
                                                    </div>
                                                </div>
                                                    
                                                @endforeach
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              All Ratings
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @for($i = 5; $i>=1; $i--) 
                                                    <div class="p-1">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="{{'rating-'.$i}}" value="{{$i}}">
                                                            <label class="form-check-label" for="{{'rating-'.$i}}">
                                                                @if($i == 1)
                                                                    {{ $i }} Star
                                                                @else
                                                                    {{ $i }} Stars
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Newest
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="javascript:void(0);" class="dropdown-item" data-action="newest">Newest</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-action="oldest">Oldest</a>
                                            </div>
                                          </div>
                                    </div> --}}
                                </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card shadow">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="t-email-campaigns" class="email-campaign  reviews-table no-footer" style="" role="grid" aria-describedby="t-email-campaigns_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="select-checkbox"></th>

                                                    <th>
                                                        <span>Rating</span>
                                                    </th>
                                                    <th>
                                                        <span>Reviewer</span>
                                                    </th>
                                                    <th>
                                                        <span>Review</span>
                                                    </th>

                                                    <th>
                                                        <span>Date</span>
                                                    </th>

                                                    <th>
                                                        Source
                                                    </th>

                                                    <th>
                                                        Reply
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @if(!empty($reviewsResult['records']))
                                                    @foreach($reviewsResult['records'] as $index => $businessReviews)

                                                        @foreach($businessReviews as $row)

                                                            <tr role="row" class="odd">
                                                                <td class="select-checkbox"></td>

                                                                <?php
                                                                $count = !empty($row['rating']) ? $row['rating']: 0;
                                                                $starRating = $count * 20;
                                                                ?>

                                                                <td class="text-verticle-align" data-search="<?php echo intval($count); ?>">
                                                                    <div class="rating-column">
                                                                        <div class="g-rating-stars">
                                                                <span class="rating">
                                                                    <span class="rating-value" style="width:{{ $starRating.'%' }}">
                                                                    </span>
                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 100px;">
                                                                    <img src="{{ $row['reviewer_image'] }}" alt="{{ $row['reviewer'] }}" class="rounded-circle" style="width:50px; height:50px;"> 
                                                                </td>
                                                                <td class="text-verticle-align" width="38%">
                                                                    <div class="review-column">
                                                                        <p>{!! $row['message'] !!}</p>
                                                                    </div>


                                                                </td>

                                                                <td class="text-verticle-align">

                                                                    <div class="date-column">
                                                                        <p>{{ $row['review_date'] }}</p>
                                                                    </div>
                                                                </td>

                                                                <?php
                                                                $reviewType = str_replace(" ", "", strtolower($row['type']));
                                                                if ($reviewType == 'googleplaces') {
                                                                    $originalType = 'Google';
                                                                } else {
                                                                    $originalType = ucfirst($reviewType);
                                                                }

                                                                ?>
                                                                <td class="text-verticle-align" width="15%">
                                                                    <div class="source-column">
                                                                        <div class="{{ $reviewType }}">
                                                                            <img src="{{ asset('public/images/icons/'.$reviewType.'.png') }}"/>
                                                                            <label>{{ $originalType }}</label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="status-column">
                                                                        @if(!empty($row['review_url']))
                                                                            <a class="dropdown-item" href="{{ $row['review_url'] }}" target="_blank">
                                                                                <span class="responded"></span>
                                                                                <span class="action-name">Respond</span>
                                                                            </a>
                                                                        @else
                                                                            <a class="dropdown-item" href="javascript:void(0)">
                                                                                <span class="responded"></span>
                                                                                <span class="action-name">Respond</span>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                @if($index == 0)
                                                                    {{--                                                <td class="text-verticle-align review-requests-col" data-search="Do Not Respond">--}}
                                                                    {{--                                                    <div class="status-column">--}}
                                                                    {{--                                                            <div class="dropdown">--}}
                                                                    {{--                                                                <button class="btn btn-secondary dropdown-toggle" type="button"--}}
                                                                    {{--                                                                        id="dropdownMenuButton" data-toggle="dropdown"--}}
                                                                    {{--                                                                        aria-haspopup="true" aria-expanded="false">--}}
                                                                    {{--                                                                    <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                        <span class="notrespond"></span>--}}
                                                                    {{--                                                                        <span class="action-name">Do Not Respond</span>--}}
                                                                    {{--                                                                    </a>--}}
                                                                    {{--                                                                </button>--}}

                                                                    {{--                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

                                                                    {{--                                                                    <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                        <span class="inprogress"></span>--}}
                                                                    {{--                                                                        <span class="action-name">In Progress</span>--}}
                                                                    {{--                                                                    </a>--}}
                                                                    {{--                                                                    <a class="dropdown-item"href="javascript:void(0);"> <span--}}
                                                                    {{--                                                                                class="responded"></span>--}}
                                                                    {{--                                                                        <span class="action-name">Responded</span>--}}
                                                                    {{--                                                                    </a>--}}
                                                                    {{--                                                                </div>--}}
                                                                    {{--                                                            </div>--}}
                                                                    {{--                                                        </div>--}}
                                                                    {{--                                                </td>--}}
                                                                @elseif($index == 1)
                                                                    {{--                                                    <td class="text-verticle-align review-requests-col" data-search="Responded">--}}
                                                                    {{--                                                        <div class="status-column">--}}
                                                                    {{--                                                        <div class="dropdown">--}}
                                                                    {{--                                                            <button class="btn btn-secondary dropdown-toggle" type="button"--}}
                                                                    {{--                                                                    id="dropdownMenuButton" data-toggle="dropdown"--}}
                                                                    {{--                                                                    aria-haspopup="true" aria-expanded="false">--}}
                                                                    {{--                                                                <a class="dropdown-item"href="javascript:void(0);"> <span--}}
                                                                    {{--                                                                            class="responded"></span>--}}
                                                                    {{--                                                                    <span class="action-name">Responded</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                            </button>--}}

                                                                    {{--                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

                                                                    {{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                    <span class="notrespond"></span>--}}
                                                                    {{--                                                                    <span class="action-name">Do Not Respond</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                    <span class="inprogress"></span>--}}
                                                                    {{--                                                                    <span class="action-name">In Progress</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                            </div>--}}
                                                                    {{--                                                        </div>--}}


                                                                    {{--                                                    </div>--}}
                                                                    {{--                                                    </td>--}}
                                                                @else
                                                                    {{--                                                    <td class="text-verticle-align review-requests-col" data-search="In Progress">--}}
                                                                    {{--                                                        <div class="status-column">--}}
                                                                    {{--                                                        <div class="dropdown">--}}
                                                                    {{--                                                            <button class="btn btn-secondary dropdown-toggle" type="button"--}}
                                                                    {{--                                                                    id="dropdownMenuButton" data-toggle="dropdown"--}}
                                                                    {{--                                                                    aria-haspopup="true" aria-expanded="false">--}}
                                                                    {{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                    <span class="inprogress"></span>--}}
                                                                    {{--                                                                    <span class="action-name">In Progress</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                            </button>--}}

                                                                    {{--                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

                                                                    {{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
                                                                    {{--                                                                    <span class="notrespond"></span>--}}
                                                                    {{--                                                                    <span class="action-name">Do Not Respond</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                                <a class="dropdown-item"href="javascript:void(0);"> <span--}}
                                                                    {{--                                                                            class="responded"></span>--}}
                                                                    {{--                                                                    <span class="action-name">Responded</span>--}}
                                                                    {{--                                                                </a>--}}
                                                                    {{--                                                            </div>--}}
                                                                    {{--                                                        </div>--}}


                                                                    {{--                                                    </div>--}}
                                                                    {{--                                                    </td>--}}
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    {{--{{ $reviewsResult['_metadata']['message'] }}--}}
                                                @endif
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.css"/>
    <style>
        .reviews-table
        {
            width: 100% !important;
        }
        /*table {*/
        /*    table-layout: fixed;*/
        /*}*/
    .dataTables_length {
        /*position: absolute;*/
        /*top: -30px;*/
        margin-left: 10px;
        margin-top: 20px;
        margin-bottom: 0px;
    }
    #search-table
    {
        width: 400px;
        float: right;
    }

    .reviews-panel .card-body
    {
        margin-bottom: 20px;
    }
    .reviews-table .select-checkbox
    {
        display: none !important;
    }
    .reviews-table th:nth-child(2), .reviews-table td:nth-child(2) {
        padding-left: 35px !important;
    }
    .d-table {
        background: #fff;
        padding: 20px 0;
    }
    .page-head {
        margin: 30px 0;
        border: none;
    }


    .page-head .btn-review-site {
        float: right;
        font-size: 15px;
        background: #3D4A9E !important;
        font-weight: 600;
        padding: 8px 20px;
        border: 1px solid #3D4A9E;
    }


    .source-column .zocdoc {
        background: #fffde4;
        border-radius: 30px;
        width: 85px;
        text-align: center;
    }
    .source-column .google, .source-column .googleplaces {
        background: #dff1e4;
        border-radius: 30px;
        width: 85px;
        text-align: center;
    }
    .source-column .facebook {
        background: #e7ecf8;
        border-radius: 30px;
        width: 100px;
        text-align: center;
    }
    .source-column .yelp {
        background: #fad9d9;
        border-radius: 30px;
        width: 70px;
        text-align: center;
    }
    .source-column .health {
        background: #d9d9e0;
        border-radius: 30px;
        width: 130px;
        text-align: center;
    }
    .d-table .inprogress {
        background: #ffdd65;
        width: 10px;
        height: 10px;
        display: inline-block;
        border-radius: 25px;
        margin: 0 10px;
    }
    .d-table .responded {
        background: #50b242;
        width: 10px;
        height: 10px;
        display: inline-block;
        border-radius: 25px;
        margin: 0 10px;
    }
    .d-table .notrespond {
        background: #ff4545;
        width: 10px;
        height: 10px;
        display: inline-block;
        border-radius: 25px;
        margin: 0 10px;
    }

    .status-column .dropdown-item {
        display: inherit;
    }

    .status-column .dropdown-toggle::after {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
    }
    .status-column .btn {
        background: #fafafa;
        padding: 0 25px 0 0;
    }
    .status-column .dropdown-toggle
    {
        min-height:32px;
    }

    .status-column .btn:active {
        box-shadow: none;
    }
    .status-column .open>.dropdown-menu {
        display: block;
        padding: 10px 10px;
    }
    .status-column .dropdown-item {
        padding: 5px 0;
    }
    .d-table-head {
        padding: 0 25px;
    }
    .d-table-head .dropdown {
        margin: 0 20px;
    }
    .reviews-panel .d-table-head .dropdown {
        margin: 0 15px;
    }

    table, table th {
        width: auto;
    }

    .d-table-head .btn-default {
        padding: 10px 0;
        border: 1px solid #00074B;
        /*background: #fafafa;*/
        font-size: 15px;
        min-width: 140px;
    }

    .reviews-panel .dropdown-menu {
        border: 1px solid rgba(120, 130, 140, 0.13);
        border-radius: 0px;
        box-shadow: none;
        /* box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05) !important; */
        /* -webkit-box-shadow: 0px!important; */
        /* -moz-box-shadow: 0px!important; */
        padding-bottom: 0px;
        padding-top: 0px;
        margin-top: 0px;
    }


    .reviews-panel .d-table-head .btn-default
    {
        min-width: auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .reviews-panel .d-table-head .btn-default
    {
        min-width: 120px;
        /*padding-left: 20px;*/
        /*padding-right: 20px;*/
    }
    #t-email-campaigns_filter
    {
        display: none;
    }

    .d-table-head .btn-default:active:focus {
        background: #fafafa;
    }
    .d-table-head .btn-default.active, .btn-default:active, .open>.dropdown-toggle.btn-default {
        background: #fafafa;
    }
    .d-table-head .head-search-review .form-control {
        border: 1px solid #a6a7af;
        border-radius: 3px;
    }
    .head-search-review {
        position: relative;
    }
    .reviews-panel .head-search-review:before {
        font-family: "Font Awesome 5 Free";
        content: '\f002';
        color: #CFCFD3;
        position: absolute;
        font-size: 16px;
        width: 20px;
        height: 20px;
        top: 10px;
        right: 10px;
        z-index: 1;
        font-weight: 700;
    }

    table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting::after, table.dataTable thead .sorting_desc::after {
        /*display: none !important;*/
        float: none !important;
        padding-left: 10px;
    }
    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc {
        background : none;
    }
    .reviews-table thead th {
        border-bottom: 0 !important;
        border-top: 0 !important;
    }
    .reviews-table th, .reviews-table td {
        padding: 1rem !important;
        vertical-align: middle !important;
        border-top: 1px solid #dae0ef !important;
    }
    .reviews-table .source-column label {
        font-weight: 600;
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-size: 14px;
    }
    #t-email-campaigns_info {
        margin-left: 30px;
    }
    .reviews-panel a.paginate_button {
        font-size: 14px;
    }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>

    <script>
        // review-column
        $('.review-column p').fewlines(
            {
                lines : 4,
                openMark : ' See More',
                closeMark : ' See Less',
                newLine: false,

            }
        );

        function filterColumn ( colummn, data ) {
            $('#t-email-campaigns').DataTable().column( colummn ).search(
                // "Healthgrades|ratemd", true,
                data, true, false
                // $('#col'+i+'_filter').val(), true,
                // $('#col'+i+'_smart').prop('checked')
            ).draw();
        }

        function serializeData(selector, column, push)
        {
            push = (push && push !== '') ? 'push' : '';

            var count = 0;
            var selectedData = '';

            $(".source-row", selector).each(function (index) {
                var source = $(this).attr('data-source');
                var checked = ($(this).find('.checkbox > input').is(':checked') === true) ? 1 : 0;

                console.log(" source > " + source);
                console.log(" checked > " + checked);

                if(checked === 1)
                {
                    if(selectedData === '')
                    {
                        selectedData = source;
                    }
                    else
                    {
                        selectedData += '|'+source;
                    }
                }
            });
            console.log("selectedData");
            console.log(selectedData);

            console.log("column");
            console.log(column);

            filterColumn(column, selectedData);

            var dropdownSelector = $(".dropdown-toggle", selector);

            if(selectedData === '')
            {
                console.log("empty in " + dropdownSelector.attr("data-text"));
                if(dropdownSelector.attr("data-text") && dropdownSelector.attr("data-text") !== '')
                {
                    $(".filter-label", dropdownSelector).html(dropdownSelector.attr("data-text"));
                }
            }
            else
            {
                // dropdownSelector.attr("data-text", $(".filter-label", dropdownSelector).html());
                $(".filter-label", dropdownSelector).html('Filtered');
            }
        }

        $(function () {
            var table = $('#t-email-campaigns').DataTable(
                {
                    // select: false,
                    ordering: true,
                    // Sortable: true
                    // paging: true,
                    // "dom": '<"top">t<"bottom"><"clear">'
                    // searching: false,
                    // lengthMenu: [ 15, 20, 50 ],
                    //     pageLength: 20
                } );



            $(".ordering-date a").click(function () {
                var action = $(this).attr("data-action");

                $(".date-ordering").html($(this).html() + ' <span class="caret"></span>');

                // $(this).remove();

                if(action === 'newest')
                {
                    $('#t-email-campaigns').DataTable().order([3, 'desc']).draw();
                }
                else
                {
                    $('#t-email-campaigns').DataTable().order([3, 'asc']).draw();
                }

            });


                // table.fnSort([ [3,'desc']] );


            // var table = $('#example').DataTable({
            //     "dom": '<"top"i>rt<"bottom"><"clear">'
            // });

            // Event listener to the two range filtering inputs to redraw on input
            // $('#min, #max').keyup( function() {
            //     table.draw();
            // } );

            $('#search-table').on( 'keyup', function () {
                table.search($('#search-table').val()).draw();
            } );


            // $('input.column_filter').on( 'keyup click', function () {
            // filterColumn( $(this).parents('tr').attr('data-column') );
            // } );

            $(document.body).on('click', '.dropdown-menu .checkbox input', function () {
                var column = $(this).closest('ul').attr("data-filter");
                var source = $(this).closest('ul').attr("data-filter-type");
                // var column = 4;
                console.log("column " + column);
                console.log("source " + source);

                serializeData('.'+source, column);
            });


            // $(document.body).on('click', '.dropdown-menu .dropdown-item', function() {
            //     var targetAction = $(this).html(); // which we want to select
            //     var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
            //
            //
            //     $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
            //     $(this).html(activeAction);
            // });

//             $(".dropdown-menu .dropdown-item").click(function()
//             {
//                 var targetAction = $(this).html(); // which we want to select
// //	var activeAction = $(".dropdown-toggle .dropdown-item").html();
//                 var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
//
//
//                 $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
//                 $(this).html(activeAction);
//
//                 //var targetName = $(".action-name", targetAction).html();
//                 //var targetStatus = $(".action-name", targetAction).html();
//
//                 // console.log("activeAction " + activeAction);
//                 // console.log("targetAction " + targetAction);
//                 // console.log("activeAction 1 " + $(".action-name", targetAction).html());
//             });
        });
    </script>
@endsection
