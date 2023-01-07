<?php
    $HowtoSendReviewRequestsTooltip = '';
    $smartRoutingTooltip = '';
?>

<div class="modal fade add-contact-step1" id="addWidgetStep1" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="st-1-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h3 class="heading">Add Contact Details</h3>
                    </div>
                    <div class="col-sm-7">
                        <div
                            class="steps-nav-right <?php echo  strtolower($enable_get_reviews)=='enabled'? '': 'hide';?>">
                            <ul>
                                <li class="completed">
                                    <div class="stip active"></div>
                                    <h4>1: Contact Details</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Review Request</h4>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tip-label <?php echo  strtolower($enable_get_reviews)=='enabled'? 'hide': '';?>">
                    {{--<i class="fa fa-lightbulb-o"></i><label>Tip: Increase your Reviews and Rating by sending review requests. <a href="{{ route('crm-widgets-settings') }}">Click
                    here to enable</a></label>--}}
                    <i class="fa fa-lightbulb-o"></i><label>Tip: Increase your Reviews and Rating by sending review
                        requests.</label>
                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName2">First Name</label>
                                <input type="text" class="form-control" id="first_name" autocomplete="new-first-name"
                                    placeholder="Enter First Name Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName2">Last Name</label>
                                <input type="text" class="form-control" id="last_name" autocomplete="new-last-name"
                                    placeholder="Enter Last Name Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail2">Email</label>
                                <input type="email" class="form-control" id="email" autocomplete="new-email"
                                    placeholder="Enter Email Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName2">Country</label>

                                <select id="countryList" autocomplete="new-country" title="Select Country"
                                    class="form-control" data-style="btn btn-white">
                                    @if(isset($countryCodes))
                                    @foreach($countryCodes as $countryCode)
                                    <option
                                        data-dial-code="<?php echo str_replace("+","",$countryCode['phonecode']); ?>">
                                        {{$countryCode['name']}}</option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group country-code">
                                <label for="exampleInputName2">Code</label>
                                <select id="countryCodesList" title=" " class="form-control" disabled
                                    data-style="btn btn-white">
                                    @if(isset($countryCodes))
                                    @foreach($countryCodes as $countryCode)
                                    <option><?php echo str_replace("+","",$countryCode['phonecode']); ?></option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" id="phone_number"
                                    autocomplete="new-phone-number" placeholder="Enter Phone Number Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <span class="error_Msg help-block hide-me"><small></small></span>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-cancel closeAddSingleWidgetStep1">Cancel</button>
                        <button id="add-single-widget-next-step" type="button"
                            class="btn btn-primary btn-save"><?php echo  strtolower($enable_get_reviews)=='enabled'? 'Next Step': 'Save';?></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addWidgetStep2" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <button type="button" class="close closeAddWidgetStep2">&times;</button>--}}
            {{--            </div>--}}
            <div class="st-1-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h3 class="heading text-nowrap">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-7">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Contact Details</h4>
                                </li>

                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>2: Review Request</h4>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading text-nowrap">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip "></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip active"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="st-3-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading text-nowrap">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-6">

                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="">

                    <div class="row">
                        <div style="display: none;" class="col-md-6">
                            <div id="enable_get_reviews_panel" class="form-group crm-widgets-settings-panel">
                                <label for="">Send Review Requests</label><span
                                    class="send_review_requests_tooltip crm_tooltip hide"><i
                                        class="crm_tooltip mdi mdi-information-outline"></i></span>
                                <select class="form-control selectpicker" id="enable_get_reviews" data-width="100%"
                                    data-style="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="sending_option_panel" class="form-group crm-widgets-settings-panel hide">
                                <label for="">How to Send Review Requests</label>

                                <a href="<?php echo $HowtoSendReviewRequestsTooltip; ?>" onclick="return false;">
                                    <span class="how_to_send_review_requests_tooltip crm_tooltip" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum placeat">
                                        <i class="mdi mdi-information-outline"></i>
                                    </span>
                                </a>
                                <select class="form-control selectpicker" id="sending_option" data-width="100%"
                                    data-style="form-control">
                                    <option value="1">Email Primary</option>
                                    <option value="2">SMS Primary</option>
                                    <option value="3">Email Only</option>
                                    <option value="4">SMS Only</option>
                                    <option value="5">Require Email and SMS</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="smart_routing_panel" class="form-group crm-widgets-settings-panel hide">
                                <label for="">Smart Routing </label>
                                <a href="<?php echo $smartRoutingTooltip; ?>" onclick="return false;">
                                    <span class="smart_routing_tooltip crm_tooltip" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum placeat">
                                        <i class="mdi mdi-information-outline"></i>
                                    </span>
                                </a>

                                <select id="smart_routing" class="form-control selectpicker" data-style="form-control">
                                    <option>Enable</option>
                                    <option>Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="send_reminder_panel" class="form-group crm-widgets-settings-panel hide">
                                <label for="">Send Reminder</label><span
                                    class="send_reminder_tooltip crm_tooltip hide"><i
                                        class="crm_tooltip mdi mdi-information-outline"></i></span>
                                <select id="send_reminder" class="form-control selectpicker" data-style="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="review_site_panel" class="form-group crm-widgets-settings-panel hide">
                                <label for="">Review Site</label><span class="review_site_tooltip crm_tooltip hide"><i
                                        class="crm_tooltip mdi mdi-information-outline"></i></span>
                                <select id="review_site" class="form-control selectpicker" data-style="form-control">
                                    @foreach($third_parties_list as $third_party)
                                    <option value="{{$third_party['type']}}">{{$third_party['type']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="preview_panel" class="crm-widgets-settings-panel hide">

                        <div id="email-preview-wrap" class="email-preview-wrap editor-content">
                            <a href="javascript:;" class="reset-default-preview" id="reset-email-default-preview"><label
                                    class="reset-label">Reset to Default</label></a>
                            <label class="editor-label">Email Content</label>
                            <div class="content-body" data-default="true"></div>
                        </div>

                        <div id="sms-preview-wrap" class="editor-content">
                            <label class="editor-label">Text Content</label>
                            <a href="javascript:;" class="reset-default-preview" id="reset-sms-default-preview"><label
                                    class="reset-label">Reset to Default</label></a>
                            <div class="content-body" data-default="true"></div>
                        </div>
                    </div>

                    <span class="error_Msg help-block hide-me"><small></small></span>
                </div>
            </div>
            <div class="modal-footer step2">
                <div class="row">
                    <div class="col-md-12">
                        <button id="add-single-widget-back-step" type="button" class="btn btn-cancel">Back</button>
                        <button id="customizeReviewRequestsBtn" type="button"
                            class="btn btn-primary btn-save btn-upload">Add Contact and Send Review Request</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addMultipleWidgetStep1" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h3 class="heading">Download CSV File</h3>
                    </div>
                    <div class="col-sm-7">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip active"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="step-body">
                        <h3>

                            First step is to download the CSV file. <br>
                            This file contains the correct format that you need to follow when adding your contacts <br>
                            to the CSV file.

                        </h3>
                        <div class="download-csv-section">

                            <img src="{{ asset('public/images/download-csv.png') }}">
                            <div class="download-link">
                                <a href="https://dev-app.netblaze.com/public/files/widgets_template.csv"
                                    download="">Download CSV File</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button id="showAddMultipleWidgetStep2Modal" type="button"
                            class="btn btn-primary btn-save btn-upload">Next Step</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addMultipleWidgetStep2" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <button type="button" class="close closeAddMultipleWidgetStep2">&times;</button>--}}
            {{--            </div>--}}
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h3 class="heading">Paste Contacts to CSV</h3>
                    </div>
                    <div class="col-sm-7">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip "></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div>
                    <div class="step-body">
                        <h3>

                            Add your contacts to the CSV file you downloaded. Follow the format shown in the CSV. <br>
                            When you’re done adding the contacts, save the file as a CSV file

                        </h3>
                        <div class="table-contacts">
                            <div class="table-responsive">
                                <span class="label label-preview-csv">Preview</span>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Email_Address</th>
                                            <th>First_Name</th>
                                            <th>Last_Name</th>
                                            <th>Phone_Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>calvinbarry@gmail.com</td>
                                            <td>Calvin</td>
                                            <td>Barry</td>
                                            <td>+ 12 345 678910</td>

                                        </tr>
                                        <tr>
                                            <td>danieldanny@gmail.com</td>
                                            <td>Daniel</td>
                                            <td>Danny</td>
                                            <td>+ 12 345 678910</td>

                                        </tr>
                                        <tr>
                                            <td>haroldfelix@gmail.com</td>
                                            <td>Harold</td>
                                            <td>Felix</td>
                                            <td>+ 12 345 678910</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{--                    <div><p style="text-align: center;color: #000;font-size: 15px;">Having difficulty?  Send us your original file and we will import your patients for you. <a href="javascript:void(0);" class="sendFileOnly" style="color: red;">Learn More</a></p></div>--}}


                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" id="backToAddMultipleWidgetStep1Modal"
                            class="btn btn-cancel">Back</button>
                        <button id="showAddMultipleWidgetStep3Modal" type="button"
                            class="btn btn-primary btn-save btn-next">Next Step</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addMultipleWidgetStep3" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <button type="button" class="close closeAddMultipleWidgetStep3">&times;</button>--}}
            {{--            </div>--}}
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-5">
                        <h3 class="heading">Upload CSV File</h3>
                    </div>
                    <div class="col-sm-7">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="step-body">
                        <h3>
                            After adding all of your contacts to the CSV file, you can upload the file here using drag
                            <br> and drop or by clicking on the Browse button and selecting the CSV file.
                        </h3>
                        <div class="upload-csv-section">
                            <div id="drop-files" ondragover="return false">
                                <img src="{{ asset('public/images/download-csv.png') }}">
                                <div class="upload-link">
                                    <h3>Drag and drop to upload</h3>
                                    <label>or <span>browse<form id="fileUploadForm"><input type="file" name="file"
                                                    id="uploadWidgetsCSVFile" style="display: none;"></form></span> to
                                        choose a file</label>
                                    <div id="csvFileName"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" id="backToAddMultipleWidgetStep2Modal"
                            class="btn btn-cancel">Back</button>
                        @if(!empty($actionStatus) && $actionStatus == 'only_save')
                        <button id="upload_csv" type="button"
                            class="btn btn-primary btn-save btn-upload">Upload</button>
                        @else
                        <button id="upload_csv" type="button" class="btn btn-primary btn-save btn-upload">Next
                            Step</button>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="widgetInfoModel" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog user-info-modal user-info-web" role="document">
        <div class="modal-content">
            {{--                    <div class="modal-header">--}}
            {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
            {{--                            <span aria-hidden="true">&times;</span>--}}
            {{--                        </button>--}}
            {{--                    </div>--}}
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="heading">Widget Info</h3>
                        <input type="hidden" class="edit-widget-id">
                        <div class="user-details">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inputContainer-name">
                                        <div class="bg-divider"></div>
                                        <input type="text" placeholder="First Name"
                                            class="form-control widgetFirstName" name="email" value="">
                                        <span class="help-block hide-me">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="inputContainer-name">
                                        <div class="bg-divider"></div>
                                        <input type="text" placeholder="Last Name" class="form-control widgetLastName"
                                            name="email" value="">
                                        <span class="help-block hide-me">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inputContainer-mail">
                                        <div class="bg-divider"></div>
                                        <input type="email" class="form-control widgetInfoEmail"
                                            placeholder="Enter email">
                                        <span class="help-block hide-me">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="inputContainer-phone">
                                        <div class="bg-divider"></div>
                                        <input type="text" class="form-control widgetInfoPhone"
                                            placeholder="Email phone number">
                                        <span class="help-block hide-me">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-widget-update btn-block btn-widgetupdate"
                                        id="update-contact" data-title="There are no changes to update.">Update</button>
                                </div>
                            </div>

                            {{--<div class="row">--}}
                            {{--<div class="col-md-5">--}}
                            {{--<div class="user-email">--}}
                            {{--<i class="mdi mdi-email"></i>--}}
                            {{--<input type="text" class="form-control widgetInfoEmail" placeholder="Enter email">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-5">--}}
                            {{--<div class="user-phone">--}}
                            {{--<i class="mdi mdi-phone-in-talk"></i>--}}
                            {{--<input type="email" class="form-control widgetInfoPhone" placeholder="Email phone number">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                            {{--<button class="btn btn-widgetupdate" id="update-contact" data-title="There are no changes to update.">Update</button>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="" id="">
                    <div class="step-body">
                        <h3>Review Requests</h3>
                        <div class="table-contacts" id="widgetInfoReviewRequestsTableContainer">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="widgetInfoReviewRequestsTable">
                                    <thead>
                                        <tr>
                                            <th>Date Sent</th>
                                            <th>Type</th>
                                            <th>Smart Routing</th>
                                            <th>Site Reviewed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addWidgetFIle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
            {{--            </div>--}}

            <div class="modal-body" style="padding-top: 0;">
                <div class="" id="">
                    <div class="step-body">
                        <h3 style="color: #000;font-weight: 600;margin-bottom: 20px;">Want {{ appName() }} to import
                            your practice data for free?</h3>
                        <p style="font-size: 15px;">
                            If your patient data file is not compatible with our file format, send us your file and
                            {{ appName() }} will import your data (patient name, email and phone number) for free. Your
                            data will be placed in your account within 24 hours and you will receive an email
                            confirmation once completed.
                        </p>
                        <div class="upload-csv-section">
                            <div id="drop-files-section" ondragover="return false">
                                <img src="http://nichepractice.test/public/images/download-csv.png">
                                <div class="upload-link">
                                    <h3>Drag and drop to upload</h3>
                                    <label>or <span>browse<form id="fileUploadInterfaceForm"><input type="file"
                                                    name="file" id="uploadWidgetsFile" style="display: none;"></form>
                                            </span> to choose a file</label>
                                    <div id="uploadFileName"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <button id="upload_csv_file" type="button" class="btn btn-save btn-upload">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
