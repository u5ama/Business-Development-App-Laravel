@extends('index')

@section('pageTitle', 'Home')
@section('css')
<style>
.bg-primary-color{
    display: none !important;
}
iframe { overflow:hidden; }
</style>

@endsection
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
                                </div>
                                <input class="form-control" placeholder="Search" type="text" />
                            </div>
                        </div>
                    </form>
                </div>

                <div class="container-fluid pt-30px">
                @include('partials.topnavbar')
                <!-- charts -->

                {{-- <iframe style="border:none; width: 100%;height: 100vh" src="https://reviewer.trustyy.io/domain/dollareast.com" allowfullscreen><p>Unable to load report this time.</p></iframe> --}}
                {{-- <iframe style="border:none; width: 100%;height: 550px"
                src="https://reviewer.trustyy.io/domain/{{ getUrlDomain($webResult['domain']) }}">
                <p>Unable to load report this time.</p>
            </iframe> --}}
            <iframe style="border:none; width: 100%;height: 550px"
                src="https://reviewer.trustyy.io/domain/{{ getUrlDomain($userData['business'][0]['website']) }}">
                <p>Unable to load report this time.</p>
            </iframe>
                    <!-- Footer -->
                    <footer class="footer">
                        <div class="row align-items-center justify-content-xl-between">
                            <div class="col-xl-12">
                                <div class="copyright text-center text-muted">
                                    <p class="text-sm font-weight-500">Copyright 2020 © All Rights Reserved</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- Footer -->
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="source" value="https://reviewer.trustyy.com/domain/{{ getUrlDomain($userData['business'][0]['website']) }}" />

@endsection

@section('js')
    <script>

        $(function () {
            $(".choose-plan-list li, .choose-plan-list li button").click(function (e) {
                console.log(e);
                e.stopPropagation();
                var packageSection = $(".upgrade-elite");
                var packageDetail = $(".upgrade-detail");
                var paymentSection = $(".payment-section");

                $(".choose-plan-list li").removeClass("active");

                console.log($(this));

                packageDetail.hide();
                paymentSection.hide();
                packageSection.hide();

                if($(this).hasClass("btn-package-select"))
                {
                    var parentElement = $(this).closest('li');

                    parentElement.addClass('active');

                    $(".action-plan").html("of " + parentElement.find('.package-title').html() + " Plan");
                    $(".price").html(parentElement.find(".pack-price").html());

                    // console.log("action ");
                    packageSection.hide();
                    paymentSection.show();
                }
                else
                {
                    if($(this).hasClass("selected") || $(this).hasClass("current-package-selected"))
                    {
                        $(this).addClass('active');

                        console.log($(this).find('.package-title').html());

                        // var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                        $(".package-title", packageDetail).html($('.current-package-selected').find('.package-title').html());
                        packageDetail.show();
                        packageSection.hide();
                    }
                    else
                    {
                        console.log("elll");
                        $(this).addClass('active');
                        $(".package-title", packageSection).html($(this).find('.package-title').html());
                        paymentSection.hide();
                        packageSection.show();
                    }
                }
            });

            var selectedPackage = $("#package-selected").val();

            if(selectedPackage !== '')
            {
                var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                currentPackageSelector.html('Selected');
                currentPackageSelector.addClass('selected');
                currentPackageSelector.removeClass('btn-package-select');

                $("ul").find($(currentPackageSelector).closest('li')).addClass('current-package-selected');

                // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
                // var parentElement = $($(currentPackageSelector).closest('li'), "ul");
                // var parentElement = $($(currentPackageSelector).closest('li'));

                // $($(currentPackageSelector).closest('li')).closest('ul').show();


                var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();
                elementIndex++;

                console.log("elementIndex " + elementIndex);

                $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();
            }
            else
            {
                $(".choose-plan-list li:first").click();
            }
        });
        function detectIndex() {
            console.log("h");
            var selectedPackage = $("#package-selected").val();
            var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

            currentPackageSelector.html('Selected');
            currentPackageSelector.addClass('selected');

            // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
            var parentElement = $($(currentPackageSelector).closest('li'), "ul");

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();

            $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            parentElement.hide();

        }


    </script>
    @endsection
