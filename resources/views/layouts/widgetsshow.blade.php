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
                <div id="preview_card" class="card"></div>

                @include('partials.footer')
            </div>
        </div>
    </div>
</div>
@endsection


@section('css')
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
<style>
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
</style>

<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('public/css/widgets/widgets.css?ver='.$appFileVersion) }}" />
@endsection

@section('js')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/tableHeadFixer.js?ver='.$appFileVersion) }}"></script>
<script type="text/javascript" src="{{ asset('public/js/widgets/widgets.js?ver='.$appFileVersion) }}"></script>
<script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>
{{-- <script id="widget_script" type="text/javascript" src="{{ asset('public/js/widgets/show-widget.js?id=1036&ver='.$appFileVersion) }}"></script> --}}
<script id="widget_script" type="text/javascript" src="http://localhost/trustyy/public/js/widgets/show-widget.js?id=1051"></script>
@endsection
