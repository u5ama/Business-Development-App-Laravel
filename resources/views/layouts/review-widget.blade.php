@extends('index')

@section('pageTitle', 'Review')


@section('content')

    <div class="app-content ">
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

                    <div class="row m-0 pt-2 pb-5 align-items-center">
                        <div class="col-xl-12">
                            <h2 class="m-0">Review Widget</h2>
                        </div>

                    </div>

                    <div class="row mb-5">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label for="header-title" class="text-muted">Header Title</label>
                                    <input type="text" placeholder="Header Title" class="form-control text-dark" id="header-title" value="Reviews">
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label class="text-muted">Disabled Powered By</label>
                                    <div class="form-control btn-with-toggle text-center">
                                        <input type="checkbox" id="switch" checked="">
                                        <label for="switch"></label>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label for="titleColor" class="text-muted">Title Color</label>
                                    <div class="form-control btn-with-toggle setting-color-picker-cont">
                                        <div class="text-dark">
                                            #<input type="text" id="titleColor" value="2a3136" style="background-color: transparent; border: none; outline: none;">
                                        </div>
                                        <button class=" btn-color-picker jscolor {valueElement:'titleColor' , value:'2a3136'}"></button>
                                    </div>
                                </div>


                                <div class="col-sm-12 mb-3">
                                    <label for="ratingColor" class="text-muted">Rating Color</label>
                                    <div class="form-control btn-with-toggle setting-color-picker-cont">
                                        <div class="text-dark">
                                            #<input type="text" id="ratingColor" value="ffbc00" style="background-color: transparent; border: none; outline: none;">
                                        </div>
                                        <button class=" btn-color-picker jscolor {valueElement:'ratingColor' , value:'ffbc00'}"></button>
                                    </div>
                                </div>


                                <div class="col-sm-12 mb-3">
                                    <label for="bgColor" class="text-muted">Background Color</label>
                                    <div class="form-control btn-with-toggle setting-color-picker-cont">
                                        <div class="text-dark">
                                            #<input type="text" id="bgColor" value="ffffff" style="background-color: transparent; border: none; outline: none;">
                                        </div>
                                        <button class=" btn-color-picker jscolor {valueElement:'bgColor' , value:'ffffff'}"></button>
                                    </div>
                                </div>




                            </div>
                        </div>

                        <div class="col-sm-8">
                            <!-- results code here -->
                            <iframe src="https://msgsndr.com/reviews/get_widget/lyYYipj6bOMCkVojFEhT" frameborder="0" scrolling="auto" width="100%" height="500" id="hl_visual-preview"></iframe>
                        </div>
                    </div>

                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/plugins/jscolor/jscolor.js') }}"></script>
@endsection
