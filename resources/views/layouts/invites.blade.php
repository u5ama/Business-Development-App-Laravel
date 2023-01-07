@extends('index')

@section('pageTitle', 'Review Requests')

@section('content')
    <div class="app-content">
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
                                            <button class="btn btn-primary-trans bg-transparent">View Reviews</button>
                                            <div class=" dropleft">
                                                <button type="button" class="btn btn-side-transparent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <button class="dropdown-item" type="button">Action</button>
                                                    <button class="dropdown-item" type="button">Another action</button>
                                                    <button class="dropdown-item" type="button">Something else here</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table w-100 text-nowrap customer-view-table">
                                            <thead>
                                            <tr>
                                                <th class="wd-25p">Invite Setnt to</th>
                                                <th class="wd-25p">Email Sent to</th>
                                                <th class="wd-15p">Sent by</th>
                                                <th class="wd-20p">Date Sent</th>
                                                <th class="wd-20p">Status</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/male/5.jpg') }}" class="mr-2">
                                                        <span>Amanda Nunes</span>
                                                    </div>
                                                </td>
                                                <td>leou@myteam.com</td>

                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/female/4.jpg') }}" class="mr-2">
                                                        <span>Martin Lois</span>
                                                    </div>
                                                </td>
                                                <td>12 Jun 2019</td>

                                                <td>
                                                    <div class="customer-table js-content-btw">
                                                        <div>
                                                            <span class="status status-sent"></span> Sent
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-primary-trans">View</button>
                                                            <div class=" dropleft">
                                                                <button type="button" class="btn btn-side-transparent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <!-- Dropdown menu links -->
                                                                    <button class="dropdown-item" type="button">Action</button>
                                                                    <button class="dropdown-item" type="button">Another action</button>
                                                                    <button class="dropdown-item" type="button">Something else here</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/male/6.jpg') }}" class="mr-2">
                                                        <span>Amanda Nunes</span>
                                                    </div>
                                                </td>
                                                <td>leou@myteam.com</td>

                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/male/3.jpg') }}" class="mr-2">
                                                        <span>Martin Lois</span>
                                                    </div>
                                                </td>
                                                <td>12 Jun 2019</td>

                                                <td>
                                                    <div class="customer-table js-content-btw">
                                                        <div>
                                                            <span class="status status-click"></span> Clicked
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-primary-trans">View</button>
                                                            <div class=" dropleft">
                                                                <button type="button" class="btn btn-side-transparent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <!-- Dropdown menu links -->
                                                                    <button class="dropdown-item" type="button">Action</button>
                                                                    <button class="dropdown-item" type="button">Another action</button>
                                                                    <button class="dropdown-item" type="button">Something else here</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/female/1.jpg') }}" class="mr-2">
                                                        <span>Amanda Nunes</span>
                                                    </div>
                                                </td>
                                                <td>leou@myteam.com</td>

                                                <td>
                                                    <div class="customer-table">
                                                        <img src="{{ asset('public/images/faces/male/2.jpg') }}" class="mr-2">
                                                        <span>Martin Lois</span>
                                                    </div>
                                                </td>
                                                <td>12 Jun 2019</td>

                                                <td>
                                                    <div class="customer-table js-content-btw">
                                                        <div>
                                                            <span class="status status-open"></span> Opened
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-primary-trans">View</button>
                                                            <div class=" dropleft">
                                                                <button type="button" class="btn btn-side-transparent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <!-- Dropdown menu links -->
                                                                    <button class="dropdown-item" type="button">Action</button>
                                                                    <button class="dropdown-item" type="button">Another action</button>
                                                                    <button class="dropdown-item" type="button">Something else here</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- Footer -->
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>

        $(function() {
            $('#example').DataTable();
        } );

    </script>
@endsection


