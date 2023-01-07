@extends('index')

@section('pageTitle', 'Review Requests History')

@section('content')
    <?php $dynamicAppName = appName(); ?>

    <div class="app-content recipient-list">
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
                        <div class="col-xl-12">
                            <div class="card shadow">
                                <div class="card-header">

                                    <div class="customer-table js-content-btw">
                                        <div>
                                            <h2 class="mb-0">Latest Review Requests</h2>
                                        </div>
                                        <div>
                                            <a href="{{ route('reviews') }}" class="btn btn-primary-trans bg-transparent">View Reviews</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-content">
                                        <div class="table-body">
                                            <div class="table-responsive">
{{--                                                <div class="recipient-stats" style="display:none; min-width: 40px !important; padding-left: 0px; padding-right: 10px !important; display: flex; float: right; justify-content: flex-end;">--}}
{{--                                                    <span id="info_cont"></span>--}}
{{--                                                    <span id="pagination_cont"></span>--}}
{{--                                                </div>--}}
                                                <table id="recipient-list" class="table w-100 text-nowrap customer-view-table custom-table" style="border: none;">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <span>Invite Sent To</span>
                                                        </th>
                                                        <th>
                                                            <span>Type</span>
                                                        </th>
                                                        <th>
                                                            <span>Sent To</span>
                                                        </th>
                                                        <th>
                                                            <span>Date Sent</span>
                                                        </th>

                                                        <th style="min-width: 160px">
                                                            <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                  data-content="This shows if Smart Routing was enabled for this recipient. If enabled, {{$dynamicAppName}} automatically routes the recipient to the review site that needs more reviews and higher rating.">
                                                                Smart Routing
{{--                                                            <i class="mdi mdi-information-outline" style="font-size: 18px;margin-left: 3px;"></i>--}}
                                                            </span>
                                                        </th>

                                                        <th>
                                                            <span>Status</span>
                                                        </th>

                                                        <th style="padding-right: 20px !important;">
                                                            <span>Site Reviewed</span>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($records))
                                                        @foreach($records as $record)
                                                            <tr>
                                                                <td>{{ $record['first_name'] }} {{ $record['last_name'] }}</td>

                                                                <td style="min-width: 60px !important;">
                                                                    @if(empty($record['type']))
                                                                        N/A
                                                                    @else
                                                                        @if($record['type']=='email')
                                                                            Email
                                                                        @elseif($record['type']=='sms')
                                                                            SMS
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($record['type']=='email')
                                                                        <span>{{ $record['email'] }} <!-- text-info --></span>
                                                                    @elseif($record['type']=='sms')
                                                                        <span>{{ $record['phone_number'] }}</span>
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td style="min-width: 100px !important;">
                                                                    <?php
//                                                                    $date = date_create($record['date_sent']);
//                                                                    echo date_format($date, "Y-m-d");

//                                                                    echo Date('Y-M-D', $record['date_sent']);
                                                                    echo $record['date_sent'];
                                                                    ?>
                                                                </td>

                                                                <td style="min-width: 115px !important;">
                                                                    @if($record['smart_routing'] == 'enable')
                                                                        <span class="label label-success">YES</span>
                                                                    @else
                                                                        <span class="label label-default">No</span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    <span>Sent</span>
                                                                </td>

                                                                <td style="">
                                                                    @if(!empty($record['site']))
                                                                        <div class="site-label">
                                                                            <?php
                                                                            $site = getThirdPartyTypeShortToLongForm($record['site']);
                                                                            $reviewType = str_replace(" ", "", strtolower($site));

                                                                            if($site == 'Google Places')
                                                                            {
                                                                                $site = 'Google';
                                                                            }
                                                                            ?>
                                                                            <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

                                                                            {{ $site }}
                                                                        </div>
                                                                    @else
                                                                        <div class="site-label awaiting">
                                                                            <i class="mdi mdi-clock"></i>  Awaiting Response
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
{{--    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />--}}

{{--    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />--}}
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />

    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/reviews-recipient/reviews-recipient.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css?ver='.$appFileVersion) }}">
    <style>
        .site-label img {
            max-width: 42px;
        }
    </style>
@endsection

@section('js')
{{--    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>--}}
{{--    <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js?ver='.$appFileVersion) }}"></script>

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
        console.log(enable_get_reviews);

        var internationalCallingCountryCodes = '<?php echo json_encode(internationalCallingCountryCodes()); ?>';
        internationalCallingCountryCodes=JSON.parse(internationalCallingCountryCodes);

        var businessName= "<?php  echo $userData['business'][0]['practice_name']; ?>";
        console.log(businessName);

        var HowtoSendReviewRequestsTooltip= "<?php  echo  $HowtoSendReviewRequestsTooltip; ?>";
        console.log(HowtoSendReviewRequestsTooltip);
        var smartRoutingTooltip= "<?php  echo $smartRoutingTooltip; ?>";
        console.log(smartRoutingTooltip);
    </script>

{{--    <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>--}}
    <script type="text/javascript" src="{{ asset('public/js/recipient/reviews-recipient.js?ver='.$appFileVersion) }}"></script>
@endsection
