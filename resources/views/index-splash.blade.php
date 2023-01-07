<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

    <!-- Title -->
    <title>{{ appName() }}</title>

    <!-- Favicon -->
    <link href="{{ asset('public/images/brand/logo-icon.png') }}" rel="icon" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('public/css/icons.css') }}" rel="stylesheet"><link href="{{ asset('public/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/custom.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('public/css/colors/default.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('public/css/user-handler.css') }}" rel="stylesheet" />

    @yield('css')

</head>
<body>

@yield('content')

<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
{{ csrf_field() }}
{{--<script src="{{ asset('public/js/jquery.min.js') }}"></script>--}}
<script src="{{ asset('public/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('public/js/popper.js') }}"></script>
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

{{--<script src="{{ asset('public/js/custom.js') }}"></script>--}}
<script type="text/javascript" src="{{ asset('public/js/validator.js?ver='.$appFileVersion) }}"></script>

@yield('js')

</body>

</html>
