@extends('index')

@section('pageTitle', 'Widgets')

@section('content')
    <div class="app-content widgets-list">
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

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-flex mb-30" style="align-items: baseline;" id="res-box">
                                <div class="d-flex" style="align-items: baseline"><h1 class="m-0">Widgets</h1> <span class="text-muted text-nowrap">&nbsp; <span id="total_widgets">0</span> Total</span></div>
                                <div class="side-input-box">

                                    <div class="form-group mr-2 mb-0 hide">
                                        <button id="delete_widgets_button" class="btn btn-default header-info-btn hide">
                                            <i class="fas fa-trash-alt" aria-hidden="true" style="font-size: 18px;"></i>
                                            {{--Selected (<span id="num_selected_records"></span>)--}}
                                        </button>
                                    </div>

                                    <div class="form-group d-inline-block mr-2 mb-0">
                                        <div class="widgets-search">
{{--                                            <input type="text">--}}
                                            <input id="searchRecords" type="text" class="search-user" placeholder="Search contact">
{{--                                            <span class="closeSearch hide"><i class="fa fa-times" aria-hidden="true"></i></span>--}}
                                        </div>
                                    </div>
                                    
                                    <button id="add_contact_button" class="btn btn-green">
                                        <i class="fas fa-plus"></i>
                                        Add Widgets</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card shadow">

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="widgets-list" class="custom-table table text-nowrap widgets-view-table" style="border: none;">
                                            <thead>
                                                <tr>
                                                <th></th>
                                                <th>
                                                    <span>Name</span>
                                                </th>
                                                <th style="display: none;"><span>Last Name</span>
                                                </th>

                                                <th>
                                                    <span>Email</span>
                                                </th>
                                                <th>
                                                    <span>Phone</span>
                                                </th>
                                                <th>
                                                    <span>Created Date</span>
                                                </th>
                                                <th>
                                                <span id="info_cont"></span>
{{--                                                <span id="pagination_cont"></span>--}}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('layouts.crm-widgets.crm-add-widgets-modals')


                    <input type="hidden" id="currentPage" value="get_more_reviews" />

                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
{{--    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />--}}

{{--    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />--}}
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" />

    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />
    <style>
        /*#countryCodesList{*/
        /*opacity: 1;*/
        /*}*/
        .bootstrap-select.btn-group.disabled,
        .bootstrap-select.btn-group>.disabled {
            cursor: default;
        }
        .bootstrap-select.disabled button.disabled{
            background-color: #ffffff;
            cursor: default;
        }
        .bootstrap-select .filter-option{
            font-weight: 600;
        }
        .bootstrap-select.disabled .filter-option{
            font-weight: 700;
        }

        /*.btn-default:hover,*/
        /*.btn-default.disabled:hover,*/
        /*.btn-default:focus,*/
        /*.btn-default.disabled:focus,*/
        /*.btn-default.focus,*/
        /*.btn-default.disabled.focus {*/
        /*opacity: 1;*/
        /*border: 1px solid #e4e7ea;*/
        /*background: #ffffff;*/
        /*}*/
    </style>
@endsection

@section('js')
{{--    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

    <script>

        $(function() {
            // $('#example').DataTable();
        } );

    </script>

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>

    <?php
    $noOfRecords=!empty($records) ? count($records) : 0;

    $HowtoSendReviewRequestsTooltip = '';
    $smartRoutingTooltip= '';

    if(isset($reviewRequestSettings)){
        $reviewRequestSettingsData=json_encode($reviewRequestSettings);
        echo '<script>var reviewRequestSettingsData='.$reviewRequestSettingsData.';</script>';
    }
    else{
        echo '<script>var reviewRequestSettingsData={}; </script>';
    }
    ?>
    <script>
        var dynamicAppName= "<?php  echo appName(); ?>";
        var noOfRecords= "<?php  echo $noOfRecords; ?>";
        var enable_get_reviews= "<?php  echo $enable_get_reviews; ?>";
        var internationalCallingCountryCodes = '<?php echo json_encode(internationalCallingCountryCodes()); ?>';
        internationalCallingCountryCodes=JSON.parse(internationalCallingCountryCodes);

        var businessName= "<?php  echo $userData['business'][0]['practice_name']; ?>";
        console.log(businessName);

        var HowtoSendReviewRequestsTooltip= "<?php  echo  $HowtoSendReviewRequestsTooltip; ?>";
        console.log(HowtoSendReviewRequestsTooltip);
        var smartRoutingTooltip= "<?php  echo $smartRoutingTooltip; ?>";
        console.log(smartRoutingTooltip);

    </script>

    <script type="text/javascript" src="{{ asset('public/js/tableHeadFixer.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/crm-widgets/crm-widgets.js?ver='.$appFileVersion) }}"></script>
@endsection


