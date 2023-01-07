@extends('index')

@section('pageTitle', 'Customers List')

@section('content')
    <?php $dynamicAppName = 'Trustyy'; ?>
    <div id="page-wrapper" class="customers-list">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head page-header">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="heading customers-heading">
                                <h2 class="customers-header page-title">Customers List</h2>
                                <span style="color: #000000; margin-left: 15px;font-weight: 600;"><span id="total_customers">0</span> <span id="total_customers_text"> Total customers</span></span>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="header-right" style="padding-top: 0px;">
                                {{--<a href="{{ route('reviews-recipients') }}" class="btn btn-default header-info-btn"><i class="fa mdi mdi-star" aria-hidden="true" style="font-size: 14px;"></i> Review Requests History</a>--}}

                                <div class="form-group">
                                    <div class="user-search">
                                        <span class="search-user"><i class="search-user mdi mdi-magnify" aria-hidden="true"></i></span>
                                        <input id="searchRecords" type="text" class="search-user form-control" placeholder="Search for Name, Email, Phone">
                                        <span class="closeSearch hide"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="form-group hide">
                                        <button id="delete_customers_button" class="btn btn-default header-info-btn hide">
                                            <i class="fa fa-trash-o" aria-hidden="true" style="font-size: 14px;"></i>
                                            {{--Selected (<span id="num_selected_records"></span>)--}}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button id="upload_CSV_button" class="btn btn-default header-primary-btn">Import File
{{--                                            <i class="mdi  mdi-upload" aria-hidden="true"></i>--}}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button id="add_contact_button" class="btn btn-info header-primary-btn">
{{--                                            <i class="mdi  mdi-plus"></i>--}}
                                            Add Contact</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="page-content">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-content">
                                            <div class="table-body">
                                                <div class="table-responsive">
                                                    <table id="customers-list" class="table custom-table" style="border: none;">
                                                        <thead>
                                                        <tr style="height: 60px;background: #EDEFF1;">
                                                            <th></th>
                                                            <th>
                                                                <span>Name</span>
                                                            </th>
                                                            <th style="display: none;">
                                                                    <span data-trigger="hover" data-container="body"
                                                                          data-toggle="popover"
                                                                          data-placement="auto right"
                                                                          data-content="This is the last name of the customer.">Last Name</span>
                                                            </th>

                                                            <th>
                                                                <span>Email Address</span>
                                                            </th>
                                                            <th>
                                                                <span>Phone Number</span>
                                                            </th>
                                                            <th>
                                                                <span>Created Date</span>
                                                            </th>
                                                            {{--<th>--}}
                                                            {{--<span id="info_cont"></span>--}}
                                                            {{--<span id="pagination_cont"></span>--}}
                                                            {{--</th>--}}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- Modal -->
    @include('layouts.crm-customers.crm-add-customers-modals')

    <input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />

    <input type="hidden" id="currentPage" value="patient_list" />
    {{ csrf_field() }}
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css') }}" />
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
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    {{--<script src="{{ asset('public/js/plugins/datatables/jquery.dataTables.min.js?ver='.$version) }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

{{--    <script src=" https://cdn.datatables.net/scroller/2.0.0/js/dataTables.scroller.min.js"></script>--}}

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
        var dynamicAppName= "<?php  echo $dynamicAppName; ?>";
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
    <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
@endsection
