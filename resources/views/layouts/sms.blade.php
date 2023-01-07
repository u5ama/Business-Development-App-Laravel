@extends('index')

@section('pageTitle', 'SMS')


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
                        <div class="col-lg-5 text-center text-lg-left mb-3 mb-lg-0">
                            <h2 class="m-0">Customize Review SMS</h2>
                        </div>
                        <div class="col-lg-7 text-right">
                            <button class="btn btn-green-transparent btn-with-toggle d-inline-flex" id="setting-active">
                                <span class="pr-2">Active </span>
                                <input type="checkbox" id="switch" checked />
                                <label for="switch"></label>
                            </button>


                            <button class="btn btn-green">
                                <i class="fas fa-check"></i>
                                <span>Save</span>
                            </button>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- card 1 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">1. Review Request with Image</h3>
                                            <a href="#." class="float-right text-muted ml-2"> <i class="fas fa-eye"></i></a>
                                            <div class="float-right btn-with-toggle d-flex text-muted">Image Turned On!
                                                <input type="checkbox" id="image_toggle" />
                                                <label for="image_toggle" class="mx-2"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="review_request_with_image_form" action="" method="post">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class=" h-100 p-3 d-flex justify-content-between" style="flex-direction: column;min-height: 250px; background: #f2f7fa;">
                                                        <div class="text-right">
                                                            <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                                <input type="checkbox" name="" id="checkbox-1">
                                                                <label for="checkbox-1" class="dark-color m-0 position-static"></label>
                                                            </div>
                                                        </div>
                                                        @if ($CrmSettings->sms_image)
                                                        <img id="review_request_with_image_preview" src="{{ asset('public/storage/'.$CrmSettings->sms_image) }}" alt="" class="img-fluid mt-3 mb-4">
                                                        @else
                                                        <img id="review_request_with_image_preview" src="{{ asset('public/images/avatardp.png') }}" alt="" class="img-fluid mt-3 mb-4">
                                                        @endif
                                                        
                                                        <label for="review_request_with_image_input" class="btn btn-light-blue w-100 m-0" style="background-color: #ddecfa;">Add Image</label>
                                                        <input type="file" id="review_request_with_image_input" class="d-none" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="review_request_with_image_button_submit" type="submit" class="btn btn-green float-right">
                                            <i class="fas fa-check"></i>
                                            <span>Save</span>
                                        </button>
                                    </form>
                                </div>
                            </div>





                            <!-- card 2 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="d-inline m-0">2. SMS sent to user</h3>
                                            <a href="#" class="float-right text-muted"> <i class="fas fa-eye"></i></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="sms_sent_to_user_message_form" action="" method="post">
                                        <div class="container">
                                            <div class="row mb-3">
                                                <div class="col-sm-12 mb-4">
                                                    <label for="sms_sent_to_user_message_textarea">Message</label>
                                                    <textarea type="text" id="sms_sent_to_user_message_textarea" class="settings-input form-control w-100" style="min-height: 140px; max-height: 400px;">{{ $CrmSettings->sms_message }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="sms_sent_to_user_message_button_submit" type="submit" class="btn btn-green float-right">
                                            <i class="fas fa-check"></i>
                                            <span>Save</span>
                                        </button>
                                    </form>
                                    

                                </div>
                            </div>


                            <!-- card 3 -->
                            <div class="card  shadow overflow-hidden" style="display: none">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="m-0">2. Leave a Review Link</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row mb-3">


                                            <div class="col-sm-12">
                                                <label for="rev-1">Review Link #1</label>
                                                <input type="text" id="rev-1" class="settings-input form-control w-100" value="http://google.com/">
                                            </div>


                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>









                        <div class="col-lg-4 col-md-8 mx-auto">
                            <div class="mobile-cont">
                                <div class="inner-mobile">

                                    <!-- mobile header -->
                                    <div class="p-3 border-bottom text-muted">
                                        <a href="#.">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                    </div>
                                    <!-- mobile body -->
                                    <div class="mobile-body py-3 px-2">
                                        <div class="d-flex mb-3">
                                            @if ($CrmSettings->sms_image)
                                              <img id="mobile_sms_image_preview" class="sms-profile-avatar" src="{{ asset('public/storage/'.$CrmSettings->sms_image) }}" alt="" style="display: none;">
                                                
                                            @else
                                             <img id="mobile_sms_image_preview" class="sms-profile-avatar" src="{{ asset('public/images/avatardp.png') }}" alt="" style="display: none;">
                                                
                                            @endif
                                            <div class="message sent">
                                                @if ($CrmSettings->sms_message)
                                                <span id="mobile_sms_message_preview">{{$CrmSettings->sms_message}}</span>
                                                @else
                                                <span id="mobile_sms_message_preview">Thank you for recommending us to family and friends. Would you mind writing a short review?</span>
                                                
                                                @endif
                                                 
                                                <a href="#.">https://bit.ly/gty52</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex align-items-center my-2 py-2 px-2 border-top justify-content-between">
                                        <p class="m-0">Enter message</p>
                                        <button type="button" class="btn btn-light-green ">Send</button>
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
        $(document).ready(function () {
            $('#image_toggle').click(function() {
                if ($(this).is(':checked')) {
                    // Do stuff
                    $('#mobile_sms_image_preview').show();
                } else {
                    $('#mobile_sms_image_preview').hide();
                }
            });
            
            // file upload starts
            var review_request_with_image_input = $('#review_request_with_image_input');
            var review_request_with_image_preview = $('#review_request_with_image_preview');
            review_request_with_image_input.on( "change", function (param) { 
                let file = review_request_with_image_input[0].files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function (param) { 
                    review_request_with_image_preview.attr('src', this.result);
                 });
                 reader.readAsDataURL(file);
             });
            //  file upload ends
            
            
            console.log(sms_sent_to_user_message_textarea);
            $('#review_request_with_image_form').submit(function (event) { 
                console.log(event);
                event.preventDefault();

                var sms_image = $('#review_request_with_image_input')[0].files[0];
                console.log(sms_image);
                
                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('sms_image', sms_image);
                showPreloader();
                $.ajax({
                    type: "POST",
                    url: "{{ route('smsImage') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function (data) { 
                    hidePreloader();
                    console.log(data);
                    if (data[0].sms_image) {
                        $('#mobile_sms_image_preview').attr('src', 'public/storage/'+data[0].sms_image);
                        console.log('public/storage/'+data[0].sms_image);
                    }
                    swal({
                            title: "Successful!",
                            text: 'Sms Image updated successfully',
                            type: "success"
                        }, function () {});

                }).fail(function (error) { 
                    hidePreloader();
                    console.log(error);
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                    
                });

             });

            $('#sms_sent_to_user_message_form').submit(function (event) { 
                event.preventDefault();

                var sms_message = $('#sms_sent_to_user_message_textarea').val();

                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('sms_message', sms_message);
                showPreloader();
                $.ajax({
                    type: "POST",
                    url: "{{ route('smsMessage') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function (data) { 
                    hidePreloader();
                    console.log(data);
                    $('#mobile_sms_message_preview').text(data[0].sms_message);
                    swal({
                            title: "Successful!",
                            text: 'Sms Message updated successfully',
                            type: "success"
                        }, function () {});
                }).fail(function (error) { 
                    hidePreloader();
                    console.log(error);
                    swal({
                            title: "OOPS!",
                            text: error.statusText,
                            type: "error"
                        }, function () {});
                });

            });
        });
    </script>
@endsection
