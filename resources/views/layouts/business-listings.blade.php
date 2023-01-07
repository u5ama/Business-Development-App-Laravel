@extends('index')

@section('pageTitle', 'Business Listings')

@section('content')
    <div class="app-content">
        <div class="side-app">
            <div class="main-content listings-panel">
                <div class="container-fluid pt-30px">
                    @include('partials.topnavbar')

                    <div class="row">
                        <div class="col-sm-12 d-flex align-items-center mb-30 justify-content-between">
                            <div>
                                <h1 class="m-0">Business Listings</h1>
                            </div>

{{--                            <div>--}}
{{--                                <a href="{{ route('apps-connection')}}" class="btn btn-warning" style="background: #FDB843;border: 1px solid #FDB843">Connect Apps</a>--}}
{{--                            </div>--}}
                        </div>

                        <div class="col-sm-12">
                            <div class="card shadow">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="custom-table table text-nowrap customer-view-table" style="width:100%">
                                            <thead>
                                            <tr style="height: 60px;" role="row">
                                                <th>
                                                    <span>Directory</span>
                                                </th>
                                                <th>
                                                    <span>Name</span>
                                                </th>
                                                <th>
                                                    <span>Address</span>
                                                </th>
                                                <th>
                                                    <span>Phone NO.</span>
                                                </th>
                                                <th>
                                                    <span>Status</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sources as $source)
                                                <?php
                                                $reviewType = str_replace(" ", "", strtolower($source['name']));
                                                $originalName = $source['name'];
                                                $name = $originalName;

                                                if ($name == 'Google Places') {
                                                    $name = 'Google';
                                                }

                                                $data = (!empty($source['data'])) ? $source['data'] : '';
                                                ?>
                                                <tr role="row" class="odd">
                                                    <td class="text-verticle-align">
                                                        <div class="listing-business-logo">
                                                            <img
                                                                src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

                                                            <label>{{ $name }}</label>
                                                        </div>
                                                    </td>

                                                    <td class="text-verticle-align">
                                                        <div class="listing-name">
                                                            @if(!empty($data))
                                                                <label>{{ $data['name'] }}</label>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td class="text-verticle-align">

                                                        @if(!empty($data))
                                                            <div class="listing-address">
                                                                <p>{{ $data['street'] }}</p>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="text-verticle-align">

                                                        @if(!empty($data))
                                                            <div class="listing-phone">
                                                                <h5>
                                                                    {{ $data['phone'] }}
                                                                </h5>
                                                            </div>
                                                        @endif

                                                    </td>

                                                    <td class="text-verticle-align review-requests-col">

                                                        <div class="lisitng-status">

                                                            @if(!empty($data) && $source['status'])
                                                                <div class="listed-badge">

                                                                    <label class="listed-label"><span
                                                                            class="listed-notification"></span>Listed</label>
                                                                </div>
                                                            @else
                                                                <div class="incorrect-badge">


                                                                    <a href="{{ route('apps-connection')}}" class="btn btn-incorrect-listing">
                                                                                        <span
                                                                                            class="incorrect-notification"></span>
                                                                        Not Listed</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
{{--    </div>--}}
@endsection

@section('css')
    <style>
        th:nth-child(1), td:nth-child(1) {
            padding-left: 25px !important;
        }
        table td {
            padding: 1rem 1rem 1rem 0 !important;
            vertical-align: middle !important;
            border-top: 1px solid #dae0ef !important;
        }
        .listing-business-logo img {
            width: 28px;
        }
        .listing-business-logo label {
            font-weight: normal;
            color: #1A1A1A;
            margin-left: 5px;
        }
        .listing-name label {
            font-weight: normal;
            color: #3D4A9E;
        }
        .listing-address p {
            color: #1A1A1A;
        }
        .listing-phone h5 {
            color: #1A1A1A;
            font-size: 15px;
            font-weight: normal;
        }
        .lisitng-status .listed-label {
            color: #50B242;
            font-weight: normal;
        }
        .listed-badge label {
            background: #eef8ed;
            padding: 5px 15px;
            border-radius: 25px;
        }
        .lisitng-status .incorrect-label {
            color: #FF4545;
            font-weight: normal;
        }
        .lisitng-status .incorrect-notification {
            background: #ff4545;
            display: inline-block;
            padding: 5px 5px;
            margin-right: 5px;
            border-radius: 10px;
        }
        .lisitng-status .listed-badge .listed-notification {
            background: #50B242;
            display: inline-block;
            padding: 5px 5px;
            margin-right: 5px;
            border-radius: 10px;
        }
        .incorrect-badge label {
            background: #ffeded;
            padding: 5px 15px;
            border-radius: 25px;
        }

    </style>
@endsection

@section('js')
<script>

</script>


@endsection
