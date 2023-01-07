<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
{{--    <meta content="Invites Reviews and Rating panel" name="description">--}}
{{--    <meta content="Spruko" name="author">--}}

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>{{ appName() . ' - ' }} @yield('pageTitle')</title>
    <!-- Favicon -->
    <link href="{{ asset('public/images/brand/logo-icon.png') }}" rel="icon" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('public/css/icons.css') }}" rel="stylesheet"><link href="{{ asset('public/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/dashboard.css') }}" rel="stylesheet">


    <link href="{{ asset('public/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/fontawesome-5/css/fontawesome.min.css') }}" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/sweet-alert/sweetalert.css') }}">

    <link href="{{ asset('public/plugins/toggle-sidebar/css/sidemenu.css') }}" rel="stylesheet">

    <link href="{{ asset('public/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/style.css?ver='.$appFileVersion) }}" rel="stylesheet">
    <link href="{{ asset('public/css/custom.css?ver='.$appFileVersion) }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" />

    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />

    @yield('css')
</head>
<body class="app sidebar-mini rtl" >
<?php
$crmModuleData = getCRMDataHelper();

$moduleView = $crmModuleData['moduleView'];
$userData = $crmModuleData['userData'];

$enable_get_reviews = $crmModuleData['enable_get_reviews'];
$countryCodes = $crmModuleData['countryCodes'];

$third_parties_list = $crmModuleData['third_parties_list'];
$reviewRequestSettings = $crmModuleData['reviewRequestSettings'];

    // print_r($crmModuleData);
    // exit;

    ?>

<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>

<div id="global-loader" ></div>




<div class="page">
    <div class="page-main">
        @include('partials.sidebar')

        @yield('content')
        @include('layouts.crm-customers.crm-add-customers-modals')


        <input type="hidden" id="currentPage" value="get_more_reviews" />

        @include('partials.popup-manager')

        <input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
        {{ csrf_field() }}
    </div>
</div>

<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

{{--<script src="{{ asset('public/js/jquery-2.1.4.min.js') }}"></script>--}}

<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/popper.js') }}"></script>
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/plugins/fontawesome-5/js/fontawesome.min.js') }}"></script>
<script src="{{ asset('public/plugins/toggle-sidebar/js/sidemenu.js') }}"></script>
<script src="{{ asset('public/plugins/customscroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('public/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('public/plugins/peitychart/jquery.peity.min.js') }}"></script>
<script src="{{ asset('public/plugins/peitychart/peitychart.init.js') }}"></script>

<script src="{{ asset('public/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('public/plugins/bootstrap-select-1.13.9/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('public/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/js/custom.js?ver='.$appFileVersion) }}"></script>
<script type="text/javascript" src="{{ asset('public/js/validator.js?ver='.$appFileVersion) }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>


<script>
//     // console.log('sdsad');
//     Tawk_API.onLoad = function() {
// // without a specific API, you may try a similar load function
// // perhaps with a setTimeout to ensure the iframe's content is fully loaded
// $('iframe').contents().find("head").append($("<style type='text/css'>  .bg-primary-color{display: none !important;}  </style>"));
// };


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
<script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
<script>
    $(document).ready({
        $("#add_contact_send_invite_button").click(function(){
        $("#addCustomerStep2 .validate-check").remove();
        $("#addMultipleCustomerStep3 .validate-check").remove();

        $('#first_name,#last_name,#email,#phone_number').val('');
        $('#countryList').selectpicker('val', '');
        $('#countryCodesList').selectpicker('val', '');
        $('#add-single-customer-next-step').attr('data-already-added', 'false');

        $('span.help-block small').text('');
        $('span.help-block').closest('.form-group').removeClass('has-error');
        $('span.help-block').addClass('hide-me').removeClass('errorMsg');
        $("#addCustomerStep1 .error_Msg").addClass('hide-me');

        $('#addCustomerStep1 .st-1-header').show();

        $('#addCustomerStep1').modal('show');
    });
    });
</script>

<script>
    var stripeKey="<?php echo $stripeKey; ?>";
    // var stripeKey = 'pk_test_7g2B5KnqbEwVUO6hVmsBmORE00V3s4jnvx';
</script>

<script src="https://js.stripe.com/v3/"></script>
@yield('js')
</body>

</html>
