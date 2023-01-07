@extends('index')

@section('pageTitle', 'Connections')

@section('content')
<div class="app-content ">
    <div class="side-app">
        <div class="main-content apps-connection">
            <div class="container-fluid pt-30px">
                @include('partials.topnavbar')
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                <div class="row">

                    <div class="col-sm-12 d-flex align-items-center mb-30 justify-content-between">
                        <div>
                            <h1 class="m-0">Apps Connection</h1>
                        </div>
                        {{-- <input type="text" class="google_suggestion form-control"> --}}

                        <div>
                            <button class="btn btn-warning" style="background: #FDB843;border: 1px solid #FDB843"
                                data-toggle="modal" data-target="#submitApp">Submit App</button>
                        </div>
                    </div>

                    @foreach($sources as $source)
                    <?php
                            $reviewType = str_replace(" ", "", strtolower($source['name']));
                            $originalName = $source['name'];
                            $name = $originalName;

                            if($name == 'Google Places')
                            {
                                $name = 'Google';
                            }
                            ?>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card shadow con-card {{ $reviewType }}-widget">
                            <div class="card-body">

                                @if($source['status'] === 'connected')
                                <div class="text-right unlink-panel">
                                    {{--                                            <a href="#" class="text-dark mr-2">--}}
                                    {{--                                                <i class="fas fa-sync"></i>--}}
                                    {{--                                            </a>--}}

                                    <div class="d-inline">
                                        <a href="javascript:void(0)" class="text-dark" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="left-start"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-2px, 0px, 0px);">
                                            <button class="dropdown-item unlink-app" type="button"
                                                style="color: #FE2F2F;"
                                                data-type="{{ $originalName }}">Disconnect</button>
                                        </div>
                                    </div>
                                </div>
                                @endif


                                <div class="row mx-0 my-3 align-items-center justify-content-between">
                                    {{--                                            <img src="{{ asset('public/images/apps/facebook.png') }}"
                                    alt="" class="img-fluid">--}}

                                    <img class="img-fluid"
                                        src="{{ asset('public/images/apps/'.$reviewType.'.png') }}" />


                                    <div>
                                        @if($source['status'] === 'connected')
                                        <a href="#" class="text-green"><i class="fas fa-check-circle pr-1"></i>
                                            Connected</a>
                                        @else
                                        <button class="btn btn-white connect-app" data-type="{{ $originalName }}"><i
                                                class="fas fa-plus pr-1"></i> Connect</button>
                                        @endif
                                    </div>

                                </div>
                                <h2 class="font-weight-bold">{{ $name }}</h2>

                                @if(!empty($source['appName']))
                                <h5 style="margin-bottom: 0px;">{{ $source['appName'] }}</h5>
                                @else
                                <h5 style="margin-bottom: 0px; color: #FE2F2F;">Not listed</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($socialToken == 1 && $accessTokenType != '')
                    <input type="hidden" id="accessToken" value="{{ $socialToken }}"
                        data-type="{{ $accessTokenType }}" />
                    @endif

                    <input type="hidden" id="currentPage" value="connect_apps" />
                    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}" />


                </div>

                @include('partials.footer')

                <!-- Modal -->

                <form action="{{route('platform.store')}}" method="post">
                    @csrf
                    <div class="modal fade" id="submitApp" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document"
                            style="top: 50%;transform: translateY(-50%);margin: 0;">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h2 class="modal-title mb-2">Add Platform</h2>
                                        <h4>Do you miss a platform you would like to connect to? Submit your platform
                                            and we
                                            look in to it!</h4>
                                    </div>


                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4>Platform name</h4>
                                            <input id="platform_name" type="text" name="platform_name"
                                                class="form-control" placeholder="Enter Name Here">
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Link to platform</h4>
                                            <input id="third_party_link" type="text" name="third_party_link"
                                                class="form-control" placeholder="Enter URL Here">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-center">
                                    <button id="platform_submit_button" type="submit"
                                        class="btn btn-primary mx-auto">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection


@section('css')

<style>
    .pac-container {
    z-index: 10000 !important;
}
.pac-container:after{
    background-image: none !important;
    /* height: 0px; */
    margin: 8px;
    text-align: center;
    font-weight: 700;
    content:"Can't find your business? Add your business manually" !important;
}
    .facebook-connectmodal .modal-content {
        padding: 0;
    }

    .facebook-connectmodal .modal-header {
        border: none;
        padding: 20px 40px 0;
        display: block;
        margin-bottom: 10px;
    }

    .facebook-connectmodal .modal-header .close {
        margin-top: 0;
        font-size: 28px;
        padding: 0;
        float: right;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: unset;
    }

    .facebook-connectmodal .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: #010318;
    }

    .facebook-connectmodal .div-separator {
        height: 1px;
        width: 100%;
        background: #ddd;
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .facebook-connectmodal .modal-body {
        position: relative;
        padding: 15px 40px 0;
    }

    .facebook-connectmodal .modal-body .panel-heading {
        color: #000000;
        font-size: 16px;
        padding: 0;
    }

    .facebook-connectmodal .page-panel {
        width: 100%;
        min-height: 100px;
    }

    .facebook-connectmodal .page-panel img {
        float: left;
        margin: 10px 0;
        max-width: 70px;
    }

    .facebook-connectmodal .page-panel .page-content {
        display: inline-block;
        margin-left: 20px;
    }

    .facebook-connectmodal .page-panel .page-content h3 {
        font-size: 16px;
        color: #010318;
        font-weight: 600;
        margin: 0;
    }

    .facebook-connectmodal .page-panel .page-content p {
        margin: 0;
        font-size: 14px;
        line-height: 1.3;
    }

    .facebook-connectmodal .add-icon {
        float: right;
    }

    .facebook-connectmodal .add-icon i.fa {
        color: #fff;
        -webkit-text-stroke: 2px #3D4A9E;
        background: #3D4A9E;
        padding: 10px 15px;
        border-radius: 3px;
        font-size: 20px;
        margin: 20px 0;
    }

    .facebook-connectmodal .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: #010318;
    }
</style>
@endsection

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDs4NnJzPINOOmFuOrcO4Kn-OhJQsl9ALg&libraries=places"></script>

<script type="text/javascript" src="{{ asset('public/plugins/custom-select/custom-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>

@endsection
