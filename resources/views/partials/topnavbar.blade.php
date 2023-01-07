<?php
$requestedUrl = Request::url();

if(isset($showAdditionalBar))
{
//    echo "if";
//    exit;
  $class = 'navbar navbar-top pb-0 d-block navbar-expand-md navbar-dark';
}
else
{
//    echo "Else";
//    exit;
  $class = 'navbar navbar-top  navbar-expand-md navbar-dark';
}
?>

@if(!isset($showAdditionalBar))

<div class="upgrade text-center mb-4 d-block d-md-none">
    7 Days Remaining in Trial
    <a href="{{ route('upgrade')}}" class="btn btn-danger ml-3">UPGRADE</a>
</div>

@endif

<nav class="{{ $class }}" id="navbar-main">
    <div class="container-fluid">
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
        @if(!isset($showAdditionalBar))
        <div class="upgrade text-center d-none d-md-block">
            7 Days Remaining in Trial
            <a href="{{ route('upgrade')}}" class="btn btn-danger ml-3">UPGRADE</a>
        </div>

        @endif

        <a class="navbar-brand pt-0 d-md-none" href="javascript:void(0)">
            <img src="{{ asset('public/images/brand/logo-icon.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <ul class="navbar-nav align-items-center ">
            <li class="nav-item dropdown d-none d-md-flex">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-0" data-toggle="dropdown" href="#" role="button">
                    <div class="media align-items-center">
                        <i class="fe fe-bell f-30 "></i>
                    </div></a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-arrow dropdown-menu-right">
                    <a href="#" class="dropdown-item d-flex">
                        <div>
                            <strong>Someone likes our posts.</strong>
                            <div class="small text-muted">3 hours ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                        <div>
                            <strong> 3 New Comments</strong>
                            <div class="small text-muted">5  hour ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                        <div>
                            <strong> Server Rebooted.</strong>
                            <div class="small text-muted">45 mintues ago</div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center">View all Notification</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-md-0" data-toggle="dropdown" href="#" role="button">
                    <div class="media align-items-center">
                        <div class="media-body mr-2 d-none d-lg-block">
                            <span class="mb-0 ">{{ userName() }}</span>
                        </div>
                        <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder"
                                     src="{{ asset('public/images/avatardp.png') }}"/>
                        </span>
                    </div></a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
{{--                    <a class="dropdown-item" href="user-profile.html"><i class="ni ni-single-02"></i> <span>My profile</span></a>--}}
{{--                    <a class="dropdown-item" href="#"><i class="ni ni-settings-gear-65"></i> <span>Settings</span></a>--}}
{{--                    <a class="dropdown-item" href="#"><i class="ni ni-calendar-grid-58"></i> <span>Activity</span></a>--}}
{{--                    <a class="dropdown-item" href="#"><i class="ni ni-support-16"></i> <span>Support</span></a>--}}
                    <div class="dropdown-divider"></div>
                    <a class="sign-out dropdown-item" href="{{ route('user.logout') }}">
                        <i class="ni ni-user-run"></i> <span>Logout</span></a>
                </div>
            </li>
        </ul>
    </div>

    @if(isset($showAdditionalBar))
        <div class="container-fluid mt-2">
        <ul class="navbar-nav setting-nav">

            <?php
            $parentActive = '';
            $currentRoute = route('company');
            if( $requestedUrl == route('company') )
            {
                $parentActive = 'active';
            }
            ?>

            <li class="nav-item {{ $parentActive }}">
                <a class="nav-link" href="{{ $currentRoute }}">Company</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('email') }}">Email</a>
            </li>

                <?php
                $parentActive = '';
                $currentRoute = route('sms');
                if( $requestedUrl == route('sms') )
                {
                    $parentActive = 'active';
                }
                ?>

                <li class="nav-item {{ $parentActive }}">
                    <a class="nav-link" href="{{ $currentRoute }}">SMS</a>
                </li>




            <?php
            $parentActive = '';
            $currentRoute = route('review-widget');
            if( $requestedUrl == $currentRoute )
            {
                $parentActive = 'active';
            }
            ?>

            <li class="nav-item {{ $parentActive }}" style="display: none">
                <a class="nav-link" href="{{ $currentRoute }}">Review Widget</a>
            </li>

                <?php
                $parentActive = '';
                $currentRoute = route('billing');
                if( $requestedUrl == route('billing') )
                {
                    $parentActive = 'active';
                }
                ?>

            <li class="nav-item {{ $parentActive }}">
                <a class="nav-link" href="{{ $currentRoute }}">Billing</a>
            </li>



                <?php
                                $parentActive = '';
                //                $currentRoute = route('payment');
                //                if( $requestedUrl == route('payment') )
                //                {
                //                    $parentActive = 'active';
                //                }
                ?>


{{--                <li class="nav-item {{ $parentActive }}">--}}
{{--                    <a class="nav-link" href="{{ $currentRoute }}">Payment</a>--}}
{{--                </li>--}}
        </ul>
    </div>
   @endif
</nav>
