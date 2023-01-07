@extends('index')

@section('pageTitle', 'Company')


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

                    <div class="row">
                        <div class="col-lg-6">
                            <!-- card 1 -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">Company Data</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="picture-text">
                                                    <h4>Company Logo</h4>
                                                    <p>The proposed size is 350px * 180px</p>
                                                    <p>no bigger than 3mb</p>
                                                </div>
                                                <div class="personal-logo" style="position: relative;">

                                                    <form class="validate-image">
                                                    <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                                    <div class="attachment_container">
                                                        {{--<span class="add-image-btn-disabled-tooltip" style="display: none;">--}}
                                                        {{--<button type="button" id="logo" class="btn btn-info" style="float: right;padding: 8px 25px;margin-right: 0;color: #fff;"><span class="hide_tablet" style="float: right;">Browse</span>--}}
                                                        {{--</button>--}}
                                                        {{--</span>--}}

                                                        <input type="file" id="add_logo_image" name="add_logo_image">
                                                    </div>

                                                    <div class="attached_images_container p-l-image">
                                                        @if(!empty($userBusiness['logo']))
                                                            <div class="small-4 columns show-image" data-attachment-id="{{ $userBusiness['logo'] }}">
                                                                {{--<img data-name="0x.jpg" class="attached_image_ox" src="{{ storage_path('app/'.$userBusiness['avatar']) }}">--}}
                                                                <img data-name="0x.jpg" class="attached_image_ox" src="{{ uploadImagePath($userBusiness['logo']) }}" />
                                                                <span class="remove_image">x</span>
                                                            </div>
                                                        @else
                                                            <div id="logo" class="picture">
                                                            </div>
                                                        @endif
                                                    </div>
                                                        <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                                            <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                            <span class="limit_exceeded_error_msg"></span>
                                                        </div>
                                                    </div>
                                                    </form>
                                                    {{-- @if(!empty($userBusiness['logo'])) --}}
                                                    <div class="picture-text image-handler">
                                                        <div class="btns">
                                                            <button type="button" id="logo" class="btn btn-light-blue mb-2" style="background-color: #e9f3fe;">Change</button>
{{--                                                                                        <button type="button" class="btn bg-lighter-gray">Remove</button>--}}
                                                        </div>
                                                    </div>
                                                    {{-- @endif --}}

                                                </div>


                                                <form class="validate-company-profile">
                                                    <div class="row company-data">
                                                        <div class="col-sm-12 mb-4">
                                                            <label for="company_name">Company Name</label>
                                                            <input type="text" class="settings-input form-control w-100" value="{{ $userData['business'][0]['practice_name'] }}" disabled />
                                                            <span class="help-block hide-me"><small></small></span>
                                                        </div>
                                                        <div class="col-sm-12 mb-4 mt-2">
                                                            <label for="email">Company Email</label>
                                                            <input type="email" class="settings-input form-control w-100" value="{{ $userData['email'] }}">
                                                        </div>
                                                        <div class="col-sm-12 mb-4 mt-2">
                                                            <label for="phone">Company Phone</label>
                                                            <input id="phone" type="text" class="settings-input form-control w-100" placeholder="Your Phone" value="{{ $userData['business'][0]['phone'] }}" data-required="true" />
                                                            <span class="help-block hide-me"><small></small></span>
                                                        </div>
                                                        <div class="col-sm-12 mb-4 mt-2">
                                                            <label for="website">Company Website</label>
                                                            <input type="text" id="website" class="settings-input form-control w-100" value="{{ $userData['business'][0]['website'] }}"  placeholder="Your Website">
                                                            <span class="help-block hide-me"><small></small></span>
                                                        </div>

                                                        <div class="col-sm-12 mt-3">
                                                            <button type="submit" class="btn btn-light-blue mb-2 btn-save" data-send="update-business-profile" style="background-color: #e9f3fe;">
                                                                Update Company
                                                            </button>
                                                            <span class="alert m-t-10" style="display: none;"></span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <!-- side card -->
                            <div class="card  shadow overflow-hidden">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">Company Address</h3>
                                        </div>

                                    </div>
                                </div>
                                <form class="validate-business-profile">
                                    <div class="card-body">
                                    <div class="container">

                                        <div class="row">
                                            <div class="col-sm-12">


                                                <div class="row">
                                                    <div class="col-sm-12 mb-4">
                                                        <label for="address">Address</label>
                                                        <input type="text" id="address" class="settings-input form-control w-100" placeholder="Address" value="{{ $userBusiness['address'] }}" data-required="true" />
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                    <div class="col-sm-8 mb-4 mt-2">
                                                        <label for="company_city">City</label>
                                                        <input type="text" class="settings-input form-control w-100" id="city" value="{{ !empty($userBusiness['city']) ? $userBusiness['city'] : '' }}" data-required="true" />
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                    <div class="col-sm-4 mb-4 mt-2">
                                                        <label for="company_zip">Zip</label>
                                                        <input type="text" class="settings-input form-control w-100" id="zip_code" value="{{ !empty($userBusiness['zip_code']) ? $userBusiness['zip_code'] : '' }}" data-required="true" />
                                                        <span class="help-block"><small></small></span>
                                                    </div>
                                                    <div class="col-sm-12 mb-4 mt-2">
                                                        <label for="state">State / Prov / Region</label>
                                                        <input type="text" class="settings-input form-control w-100" id="state" value="{{ !empty($userBusiness['state']) ? $userBusiness['state'] : '' }}" data-required="true" />
                                                        <span class="help-block"><small></small></span>
                                                    </div>


                                                    <div class="col-sm-12 mb-4 mt-2">
                                                        <label for="country_id">Country</label>

                                                        <select class="form-control" id="country_id" data-required="true">
                                                            <option value="">Choose Country</option>

                                                            @foreach($countries as $country)
                                                                <option value="{{ $country['id'] }}" {{ selectedChosenValue($userBusiness['country_id'], $country['id']) }}>{{ $country['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="help-block"><small></small></span>
                                                    </div>


{{--                                                    <div class="col-sm-12 mb-4 mt-2">--}}
{{--                                                        <label for="company_website">Time Zone</label>--}}
{{--                                                        <select name="timezone" data-size="5"--}}
{{--                                                                class="selectpicker settings-input form-control w-100"--}}
{{--                                                                tabindex="-98">--}}
{{--                                                            <option value="">Choose one..</option>--}}
{{--                                                            <option value="Etc/GMT+12">GMT-12:00 Etc/GMT+12 (-12)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Midway">GMT-11:00 Pacific/Midway--}}
{{--                                                                (SST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Honolulu">GMT-10:00 Pacific/Honolulu--}}
{{--                                                                (HST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Juneau">GMT-08:00 America/Juneau--}}
{{--                                                                (AKDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/Alaska">GMT-08:00 US/Alaska (AKDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Chihuahua">GMT-07:00--}}
{{--                                                                America/Chihuahua (MST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Dawson">GMT-07:00 America/Dawson--}}
{{--                                                                (PDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Los_Angeles">GMT-07:00--}}
{{--                                                                America/Los_Angeles (PDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Phoenix">GMT-07:00 America/Phoenix--}}
{{--                                                                (MST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Tijuana">GMT-07:00 America/Tijuana--}}
{{--                                                                (PDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/Arizona">GMT-07:00 US/Arizona (MST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Bahia_Banderas">GMT-06:00--}}
{{--                                                                America/Bahia_Banderas (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Belize">GMT-06:00 America/Belize--}}
{{--                                                                (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Boise">GMT-06:00 America/Boise--}}
{{--                                                                (MDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Denver">GMT-06:00 America/Denver--}}
{{--                                                                (MDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Edmonton">GMT-06:00 America/Edmonton--}}
{{--                                                                (MDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Guatemala">GMT-06:00--}}
{{--                                                                America/Guatemala (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Managua">GMT-06:00 America/Managua--}}
{{--                                                                (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Mexico_City">GMT-06:00--}}
{{--                                                                America/Mexico_City (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Regina">GMT-06:00 America/Regina--}}
{{--                                                                (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Canada/Saskatchewan">GMT-06:00--}}
{{--                                                                Canada/Saskatchewan (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/Mountain">GMT-06:00 US/Mountain (MDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Bogota">GMT-05:00 America/Bogota--}}
{{--                                                                (-05)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Chicago">GMT-05:00 America/Chicago--}}
{{--                                                                (CDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/Central">GMT-05:00 US/Central (CDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Caracas">GMT-04:00 America/Caracas--}}
{{--                                                                (-04)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Detroit">GMT-04:00 America/Detroit--}}
{{--                                                                (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Indiana/Indianapolis">GMT-04:00--}}
{{--                                                                America/Indiana/Indianapolis (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Louisville">GMT-04:00--}}
{{--                                                                America/Louisville (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Manaus">GMT-04:00 America/Manaus--}}
{{--                                                                (-04)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/New_York">GMT-04:00 America/New_York--}}
{{--                                                                (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Santo_Domingo">GMT-04:00--}}
{{--                                                                America/Santo_Domingo (AST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Toronto">GMT-04:00 America/Toronto--}}
{{--                                                                (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/East-Indiana">GMT-04:00 US/East-Indiana--}}
{{--                                                                (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="US/Eastern">GMT-04:00 US/Eastern (EDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Argentina/Buenos_Aires">GMT-03:00--}}
{{--                                                                America/Argentina/Buenos_Aires (-03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Glace_Bay">GMT-03:00--}}
{{--                                                                America/Glace_Bay (ADT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Godthab">GMT-03:00 America/Godthab--}}
{{--                                                                (-03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Montevideo">GMT-03:00--}}
{{--                                                                America/Montevideo (-03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Santiago">GMT-03:00 America/Santiago--}}
{{--                                                                (-03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Sao_Paulo">GMT-03:00--}}
{{--                                                                America/Sao_Paulo (-03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Canada/Atlantic">GMT-03:00 Canada/Atlantic--}}
{{--                                                                (ADT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/St_Johns">GMT-02:30 America/St_Johns--}}
{{--                                                                (NDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Canada/Newfoundland">GMT-02:30--}}
{{--                                                                Canada/Newfoundland (NDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="America/Noronha">GMT-02:00 America/Noronha--}}
{{--                                                                (-02)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Etc/GMT+2">GMT-02:00 Etc/GMT+2 (-02)</option>--}}
{{--                                                            <option value="Atlantic/Azores">GMT-01:00 Atlantic/Azores--}}
{{--                                                                (-01)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Atlantic/Cape_Verde">GMT-01:00--}}
{{--                                                                Atlantic/Cape_Verde (-01)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Africa/Casablanca">GMT+00:00--}}
{{--                                                                Africa/Casablanca (WET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Atlantic/Canary">GMT+00:00 Atlantic/Canary--}}
{{--                                                                (WET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Etc/Greenwich">GMT+00:00 Etc/Greenwich--}}
{{--                                                                (GMT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/London">GMT+00:00 Europe/London--}}
{{--                                                                (GMT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="GMT">GMT+00:00 GMT (GMT)</option>--}}
{{--                                                            <option value="UTC">GMT+00:00 UTC (UTC)</option>--}}
{{--                                                            <option value="Africa/Algiers">GMT+01:00 Africa/Algiers--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Africa/Lagos">GMT+01:00 Africa/Lagos (WAT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Amsterdam">GMT+01:00 Europe/Amsterdam--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Belgrade">GMT+01:00 Europe/Belgrade--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Brussels">GMT+01:00 Europe/Brussels--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Madrid">GMT+01:00 Europe/Madrid--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Oslo">GMT+01:00 Europe/Oslo (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Sarajevo">GMT+01:00 Europe/Sarajevo--}}
{{--                                                                (CET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Africa/Cairo">GMT+02:00 Africa/Cairo (EET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Africa/Harare">GMT+02:00 Africa/Harare--}}
{{--                                                                (CAT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Amman">GMT+02:00 Asia/Amman (EET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Jerusalem">GMT+02:00 Asia/Jerusalem--}}
{{--                                                                (IST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Athens">GMT+02:00 Europe/Athens--}}
{{--                                                                (EET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Bucharest">GMT+02:00 Europe/Bucharest--}}
{{--                                                                (EET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Helsinki">GMT+02:00 Europe/Helsinki--}}
{{--                                                                (EET)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Africa/Nairobi">GMT+03:00 Africa/Nairobi--}}
{{--                                                                (EAT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Baghdad">GMT+03:00 Asia/Baghdad (+03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Kuwait">GMT+03:00 Asia/Kuwait (+03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Qatar">GMT+03:00 Asia/Qatar (+03)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Europe/Moscow">GMT+03:00 Europe/Moscow--}}
{{--                                                                (MSK)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Baku">GMT+04:00 Asia/Baku (+04)</option>--}}
{{--                                                            <option value="Asia/Dubai">GMT+04:00 Asia/Dubai (+04)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Kabul">GMT+04:30 Asia/Kabul (+0430)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Tehran">GMT+04:30 Asia/Tehran (+0430)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Karachi">GMT+05:00 Asia/Karachi (PKT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Yekaterinburg">GMT+05:00--}}
{{--                                                                Asia/Yekaterinburg (+05)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Colombo">GMT+05:30 Asia/Colombo--}}
{{--                                                                (+0530)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Kolkata">GMT+05:30 Asia/Kolkata (IST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Kathmandu">GMT+05:45 Asia/Kathmandu--}}
{{--                                                                (+0545)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Almaty">GMT+06:00 Asia/Almaty (+06)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Dhaka">GMT+06:00 Asia/Dhaka (+06)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Rangoon">GMT+06:30 Asia/Rangoon--}}
{{--                                                                (+0630)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Bangkok">GMT+07:00 Asia/Bangkok (+07)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Krasnoyarsk">GMT+07:00 Asia/Krasnoyarsk--}}
{{--                                                                (+07)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Irkutsk">GMT+08:00 Asia/Irkutsk (+08)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Kuala_Lumpur">GMT+08:00--}}
{{--                                                                Asia/Kuala_Lumpur (+08)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Shanghai">GMT+08:00 Asia/Shanghai--}}
{{--                                                                (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Taipei">GMT+08:00 Asia/Taipei (CST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Perth">GMT+08:00 Australia/Perth--}}
{{--                                                                (AWST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Seoul">GMT+09:00 Asia/Seoul (KST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Tokyo">GMT+09:00 Asia/Tokyo (JST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Yakutsk">GMT+09:00 Asia/Yakutsk (+09)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Darwin">GMT+09:30 Australia/Darwin--}}
{{--                                                                (ACST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Vladivostok">GMT+10:00 Asia/Vladivostok--}}
{{--                                                                (+10)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Brisbane">GMT+10:00--}}
{{--                                                                Australia/Brisbane (AEST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Guam">GMT+10:00 Pacific/Guam (ChST)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Adelaide">GMT+10:30--}}
{{--                                                                Australia/Adelaide (ACDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Asia/Magadan">GMT+11:00 Asia/Magadan (+11)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Canberra">GMT+11:00--}}
{{--                                                                Australia/Canberra (AEDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Hobart">GMT+11:00 Australia/Hobart--}}
{{--                                                                (AEDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Australia/Sydney">GMT+11:00 Australia/Sydney--}}
{{--                                                                (AEDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Fiji">GMT+12:00 Pacific/Fiji (+12)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Auckland">GMT+13:00 Pacific/Auckland--}}
{{--                                                                (NZDT)--}}
{{--                                                            </option>--}}
{{--                                                            <option value="Pacific/Tongatapu">GMT+13:00--}}
{{--                                                                Pacific/Tongatapu (+13)--}}
{{--                                                            </option>--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}


                                                    <div class="col-sm-12 mt-3">
                                                        <button style="background-color: #e9f3fe;" type="submit" class="btn btn-light-blue mb-2 btn-save" data-send="update-business-profile">
                                                            Update Address
                                                        </button>

                                                        <span class="alert m-t-10" style="display: none;"></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                </form>
                            </div>

                            <!-- side card -->
                            <div class="card  shadow overflow-hidden" style="display: none;">
                                <div class="card-header bg-transparent ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class=" m-0">General</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                    <input type="checkbox" name="" id="checkbox-1">
                                                    <label for="checkbox-1" class="dark-color m-0 position-static label-with-text">Allow Duplicate Contact</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                    <input type="checkbox" name="" id="checkbox-2">
                                                    <label for="checkbox-2" class="dark-color m-0 position-static label-with-text">Merge Facebook Contacts By Name</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="register-checkbox setting-checkbox mb-0 position-relative">
                                                    <input type="checkbox" name="" id="checkbox-3">
                                                    <label for="checkbox-3" class="dark-color m-0 position-static label-with-text">Disable Contact imezone</label>
                                                </div>
                                            </div>


                                        </div>

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

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/image-manager.css?ver='.$appFileVersion) }}" />
    <style>
        .p-l-image {
            /*border: 1px solid #ddd;*/
            text-align: center;
            width: 350px;
            margin: 0;
            padding: 0;
            height: 180px;
        }
        .p-l-image img {
            margin: auto;
        }

        .image-handler
        {
            position: absolute;
            right: 0;
            top: 100px;
        }
    </style>
@endsection

@section('js')

<script>
    checkFormStatus('validate-company-profile');
    checkFormStatus('validate-business-profile');

    // checkFormStatus('validate-pass');

    function checkFormStatus(formTarget)
    {
        console.log("in");
        var i = 0;
        var orig = [];


        var businessForm = $('.'+formTarget +' input:text,' +'.'+formTarget +' select');


        /**
         * Saving form original data into array
         *  when page load
         */
        businessForm.each(function () {
            var name = $(this).attr('name');
            var type = $(this).attr('type');
            var ID = $(this).attr('id');
            var value = $(this).val();
            value = value.replace(/\s+/g, '');

            var tmp = {
                'type': type,
                'name': name,
                'value': value
            };

//                console.log("tmp " + ID);
            orig[ID] = tmp;
        });
        // console.log("original");
        // console.log(orig);

        businessForm.bind('change keyup', function () {
            console.log("change tracked");
            var disable = true;
            businessForm.each(function () {
                var name = $(this).attr('name');
                var type = $(this).attr('type');
                var id = $(this).attr('id');
                var value = $(this).val();
                value = value.replace(/\s+/g, '');

                // if equal this is "true" else "false"
                disable = (orig[id].value == value);

                // if this is false
                if (!disable) {
                    return false; // break out of loop
                }
            });

            // if this is true.
            if (disable) {
                // then no changing at this form.
                // $('#isUpdatedDetail').val(0);
                $('.'+formTarget +' .btn-save').attr('data-form-status', 0);
                console.log("not changed");
            }
            else {
                // $('#isUpdatedDetail').val(1);
                // yes I'm updated.
                $('.'+formTarget +' .btn-save').attr('data-form-status', 1);
                console.log("changed");
            }
        });
    }

    registerElement('validate-company-profile', 'userErrorFound');
    registerElement('validate-business-profile', 'businessErrorFound');

    $(document.body).on('submit', 'form.validate-company-profile, form.validate-business-profile', function(e)
    {
        // console.log("clicked B");

        console.log("error status " + window.userErrorFound);
        console.log("error status " + userErrorFound);
        var alert = $(".alert", $(this));

        var errorLocalStatus = errorFound;

        if($(this).hasClass('validate-company-profile') === true)
        {
            errorLocalStatus = userErrorFound;
        }
        else if($(this).hasClass('validate-business-profile') === true)
        {
            errorLocalStatus = businessErrorFound;
        }

        if(!errorLocalStatus)
        {
            console.log("inside user");
            // var formStatus = $("form.validate-company-profile .btn-save").attr("data-form-status");

            var formStatus = $(".btn-save", $(this)).attr("data-form-status");

            alert.hide();
            alert.removeClass('error');

            console.log("form status " + formStatus);

            if(formStatus == 1)
            {
                var targetButton = $(".btn-save", $(this));
                var currentAction = $(".btn-save", $(this)).attr("data-send");

                var baseUrl = $("#hfBaseUrl").val();

                var data = {};
                data['send'] = currentAction;

                $('input, textarea, select', $(this)).each(function() {
                    var ID = $(this).attr('id'); // get id of current required field.
                    var currentFieldvalue = $(this).val(); // get value of current field.

                    console.log("id is " + ID);
                    if(ID && ID !== '')
                    {
                        data[ID] = currentFieldvalue;
                    }
                });

                console.log("data");
                console.log(data);
                console.log("len " + data.length);

                var $this = showLoaderButton(targetButton, "Saving");

                // return false;

                var firstName = $("#first_name").val();
                var lastName = $("#last_name").val();
                var name = $(".username-title");

                // ready for sae.
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    data:data,
                }).done(function (result) {
                    console.log(result);
                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    resetLoaderButton($this);

                    if( statusCode == 200 ) {
                        $("form.validate-company-profile .btn-save").attr("data-form-status", '');

                        var fullName = firstName + ' ' + lastName;
                        if(fullName.length > 13)
                        {
                            name.html(firstName);
                        }
                        else
                        {
                            name.html(fullName);
                        }

                        $(".u-text").html(fullName);

                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        }, function () {});
                    }
                    else
                    {
                        swal("", statusMessage, "error");
                    }
                });
            }
            else
            {
                alert.show();
                alert.addClass('error');
                alert.html('No change detected in fields. Please update any field to save.');
            }
        }
        else
        {
            alert.hide();
            alert.removeClass('error');
        }
    });

</script>
<script type="text/javascript" src="{{ asset("public/js/image-branding.js?ver=$appFileVersion") }}"></script>
<script>
    $(document).ready(function (param) {
        if ( $( "div.show-image" ).length ) {
            $( "button#logo" ).show();
        }
        if ( $( "div.show-image" ).length === 0 ) {
            $( "button#logo" ).hide();
        }
    });
</script>
@endsection
