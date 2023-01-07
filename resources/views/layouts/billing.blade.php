@extends('index')

@section('pageTitle', 'Billing')


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

                    <div class="row mb-30 align-items-center">
                        <div class="col-xl-12">
                            <h2 class="m-0">Payment Setup</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- card 1 -->
                            <div style="height: calc(100% - 30px)" class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">Select payment method</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="border h-100 p-3 d-flex justify-content-between" style="flex-direction: column;">
                                                    <div class="text-right">
                                                        <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                            <input type="checkbox" name="" id="checkbox-1" checked>
                                                            <label for="checkbox-1" class="dark-color m-0 position-static"></label>
                                                        </div>
                                                    </div>

                                                    <img src="{{ imageReturn('master-card.png') }}" alt="" class="img-fluid mt-3 mx-auto" style="width: 70%;">

                                                    <h3 class="text-center mb-0">Mastercard</h3>
                                                    <h4 class="text-center text-muted mb-4">8771</h4>


                                                    <button class="btn btn-light-green w-100 m-0">Selected - Edit</button>


                                                </div>
                                            </div>

                                            {{-- <div class="col-sm-6">
                                                <div class="border h-100 p-3 d-flex justify-content-between" style="flex-direction: column;">
                                                    <div class="text-right">
                                                        <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                            <input type="checkbox" name="" id="checkbox-2">
                                                            <label for="checkbox-2" class="dark-color m-0 position-static"></label>
                                                        </div>
                                                    </div>

                                                    <img src="{{ imageReturn('ach-bank.png') }}" alt="" class="img-fluid mt-3 mx-auto" style="width: 45%;">

                                                    <h3 class="text-center mb-0">ACH Check</h3>
                                                    <h4 class="text-center text-muted mb-4">Connect your bank account</h4>


                                                    <button class="btn btn-light-blue w-100 m-0">Setup</button>


                                                </div>
                                            </div> --}}
                                        </div>


                                    </div>

                                </div>
                            </div>



                        </div>









                        <div class="col-lg-4 col-md-6 col-sm-9 mx-auto">
                            <!-- card side -->
                            <div class="card  shadow overflow-hidden" style="height: calc(100% - 30px)">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">My Plan</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body h-100 d-flex justify-content-around" style="flex-direction: column;">


                                    <div class="mx-auto" style="width: 70%;">
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 pr-0">
                                                <img src="{{ imageReturn('setting-billing-plan.png') }}" alt="" class="img-fluid  mx-auto" style="width: 75%;">
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <h2 class="text-green m-0">X 6</h2>
                                            </div>
                                        </div>
                                    </div>




                                    <div>
                                        <h3>Regular ( <span>6 Locations</span> )</h3>
                                        <h4 class=" text-muted mb-4">You have regular plan with 6 locations, each location costs $249/month and will be billed to you selected payment method each month</h4>
                                    </div>


                                    <a href="{{ route('upgrade')}}" class="btn btn-light-green w-100 mb-2">Change Plan</a>

                                    <a href="#" class="text-light-dark text-underline text-center">Cancel Membership</a>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0 pb-4 align-items-center">
                        <div class="col-xl-12">
                            <h2 class="m-0">Billing</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card shadow">

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table w-100 text-nowrap customer-view-table">
                                            <thead>
                                            <tr>
                                                <th class="wd-25p pl-4">Invoice</th>
                                                <th class="wd-25p">Description</th>
                                                <th class="wd-15p">Service Period</th>
                                                <th class="wd-20p">Payment Method</th>
                                                <th class="wd-20p">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($invoices))
                                                @forelse ($invoices as $invoice)
                                               
                                                <tr>
                                                    <td class="pl-4">{{  $invoice->asStripeInvoice()->id}}</td>
    
                                                <td>
                                                    {{ $invoice->asStripeInvoice()->lines->data[0]->description }}
                                                </td>
    
                                                    <td>
                                                        <span>{{ date("Y-m-d H:i:s", $invoice->asStripeInvoice()->lines->data[0]->period->start) }}</span> -
                                                        <span>{{ date("Y-m-d H:i:s", $invoice->asStripeInvoice()->lines->data[0]->period->end) }}</span>
                                                    </td>
    
                                                    <td>
                                                        <div class="customer-table">
                                                            <img src="{{ imageReturn('master-card.png') }}" alt="" class="mr-1" style="border-radius: 0 !important;width: 40px; height: auto;">
                                                        <span>{{ $invoice->asStripeInvoice()->number }}</span>
                                                        </div>
                                                    </td>
    
                                                    <td>
                                                        <div class="customer-table js-content-btw">
                                                            <div>
                                                                {{ $invoice->total() }}
                                                            </div>
    
                                                            <div>
                                                                <button class="btn btn-primary-trans">View</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                        
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: center;">
                                                        No Data Yet.
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforelse
                                            
                                            @else
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: center;">
                                                    No Data Yet.
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endif
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
@endsection

@section('js')
    <script>
        $("#message").on('blur keyup', function()
        {
            var message = $(this).val();

            message += '<br>';
            message += '<a href="javascript:void(0)">https://bit.ly/gty52</a>';
            $(".sent").html(message);
        });
    </script>
@endsection
