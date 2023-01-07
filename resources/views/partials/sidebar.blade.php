<!-- Sidebar menu-->
{{--<div class="app-sidebar__overlay" data-toggle="sidebar"></div>--}}
<div class="app-sidebar__overlay"></div>
<aside class="app-sidebar ">
    <div class="sidebar-img">
        <a class="navbar-brand" href="{{ route('home') }}">
{{--            <img class="navbar-brand-img main-logo" src="{{ asset('public/images/brand/logo-dark.png') }}" />--}}
            <img class="navbar-brand-img main-logo" src="{{ asset('public/images/brand/logo-black.png') }}" />
            <img class="navbar-brand-img logo" src="{{ asset('public/images/brand/logo-icon.png') }}">
        </a>
        
        <button id="add_contact_send_invite_button" class="btn btn-green mb-3" style="width: 70%; margin-left: 15%;"><i class="far fa-envelope"></i> Send Invite</button>
        
        
        <ul class="side-menu">
            <li class="">
                <a class="side-menu__item" href="{{ route('home') }}">
                    <i class="side-menu__icon fas fa-home"></i>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('apps-connection') }}">
{{--                    <i class="side-menu__icon fas fa-home"></i>--}}
                    <i class="side-menu__icon fas fa-plug"></i>
                    <span class="side-menu__label">Connections</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('reviews') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
{{--                    <i class="side-menu__icon mdi mdi mdi-star fa-fw"></i>--}}
                    <i class="side-menu__icon fas fa-star"></i>
                    <span class="side-menu__label">Reviews</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('company-reviews') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
{{--                    <i class="side-menu__icon mdi mdi mdi-star fa-fw"></i>--}}
                    <i class="side-menu__icon fas fa-star"></i>
                    <span class="side-menu__label">Company Reviews</span>
                </a>
            </li>

            <li class="">
{{--                <a class="side-menu__item" href="{{ route('review-requests') }}">--}}
                <a class="side-menu__item" href="{{ route('reviews-recipients') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
                    <img class="rr-icon-sidebar" src="{{ imageReturn('reviewrequests.png') }}" alt="" style="margin-right: 15px;" />
                    <span class="side-menu__label">Review Request</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('widgets') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
                    <i class="side-menu__icon fas fa-tachometer-alt"></i>
                    <span class="side-menu__label">Widgets</span>
                </a>
            </li>


            <li class="">
                <a class="side-menu__item" href="{{ route('customers') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
                    <i class="side-menu__icon fas fa-users"></i>
                    <span class="side-menu__label">Customers</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('citation-listings') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
                    <i class="side-menu__icon fas fa-map-marker-alt"></i>
{{--                    <i class="side-menu__icon fa fa-map-marker" aria-hidden="true"></i>--}}

                    <span class="side-menu__label">Company listings</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('websiteAudit') }}">
{{--                    <i class="side-menu__icon fe fe-user"></i>--}}
                    <i class="side-menu__icon fas fa-globe"></i>
                    <span class="side-menu__label">Website Audit</span>
                </a>
            </li>

            <li class="">
                <a class="side-menu__item" href="{{ route('company') }}">
                    <i class="side-menu__icon fas fa-cog"></i>
                    <span class="side-menu__label">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- Sidebar menu-->
