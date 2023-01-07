<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

    <title>Email Template</title>

    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/email.css') }}" rel="stylesheet">

</head>
<body class="app sidebar-mini rtl" >


<div class="container-mail bg-white my-5">
    <div class="container">
        <div class="row py-4">
            <div class="col-6">
                <h3>
                    <img style="max-height: 2.5rem;text-align: center;display: block;" class="navbar-brand-img main-logo" src="{{ asset('public/images/brand/logo-black.png') }}" />
                </h3>
            </div>
            <div class="col-6 text-right py-2">
                5.0 <span class="rating">
					<span class="rating-value" style="width:100%"></span>
				</span>
            </div>
        </div>
    </div><hr class="m-0">
    <div class="container pt-5 px-5 text-center">
        <h1 class="font-weight-light">Would you be so kind to recommend us?</h1>
        <p>Thank you for your business! Would you be so kind to recommed us to your family and friends?</p>
        <button class="btn btn-green d-block w-100 mb-3 py-3">Yes</button>
        <a style="color: #000000;" href="{{ route('home') }}" class="btn btn-transparent d-block w-100 mb-5 py-3">No, Thanks</a>
        <p>Sincerely,</p>
        <p>Adam, Q Lang, Customer Relations</p>
        <img src="{{ asset('public/images/faces/male/2.jpg') }}" class="mail-img mb-4">

    </div>
    <hr class="m-0">
    <div class="container py-4 px-5 text-center">
        <p class="m-0 text-muted">Help Trustyy Accounting</p>
        <p class="m-0 text-muted">302 Anderson Road, Appartment 301</p>
        <p class="m-0 text-muted">San Francisco, CA</p>
        <p class="m-0 text-muted">(0800) 5633 3422 &nbsp;&nbsp; help@trustyy.com &nbsp;&nbsp; www.trustyy.com</p>
    </div>
</div>
<div class="container pb-5 text-center">
    <p class="m-0">Powered by <a href="#."><u>Trustyy</u></a></p>
    <p class="m-0">@ Trustyy 2020</p>
    <p class="m-0"><a href="#." class="text-muted"><u>Unsubscribe</u></a> from list</p>
</div>

</body>

</html>
