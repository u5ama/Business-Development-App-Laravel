<?php
/**
 * Created by Wahab
 * Date: 10/30/2017
 * Time: 2:51 PM
 */

namespace Modules\CRM\Entities;

use App\Entities\AbstractEntity;
use App\Mail\CreateSendReviewRequestEmail;
use App\Services\SessionService;
use http\Env\Request;
use Modules\CRM\Models\UserReviewsFiles;
use Modules\ThirdParty\Models\ThirdPartyMaster;
use Modules\User\Models\Users;
use Modules\Business\Models\Business;
use Modules\CRM\Models\CrmSettings;
use Modules\CRM\Models\Promo;
use Modules\CRM\Models\SendingHistory;
use Modules\ThirdParty\Models\StatTracking;
use Modules\CRM\Services\Validations\Reviews\AddReviewValidator;
use Modules\CRM\Services\Validations\Reviews\FilesReviewValidator;
use Modules\CRM\Services\Validations\Reviews\EditCustomerValidator;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Models\SocialMediaMaster;
use App\Mail\CreateAddRecipientsEmail;
use Modules\CRM\Models\ReviewRequest;
use App\Traits\UserAccess;
use Exception;
use Log;
use JWTAuth;
use DB;
use Config;
use Modules\Business\Entities\BusinessEntity;
use Modules\CRM\Models\Recipient;
use Mail;
use Storage;
use File;
use Bitly;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;
use Twilio\Rest\Client;
use Validator;

class CRMEntity extends AbstractEntity
{
    use UserAccess;

    protected $addReviewValidator;
    protected $editCustomerValidator;
    protected $fileReviewValidator;

    protected $businessEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->addReviewValidator = new AddReviewValidator(resolve('validator'));
        $this->editCustomerValidator = new EditCustomerValidator(resolve('validator'));
        $this->fileReviewValidator = new FilesReviewValidator(resolve('validator'));

        $this->sessionService = new SessionService();
    }

    
    public function addCustomers($request)
    {
        try {
            
            Log::info('$request');
            Log::info($request);

            
            
            Log::info("addCustomers process");
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];
            $businessName = $businessResult['practice_name'];


            $userData = $this->sessionService->getAuthUserSession();
            $user = $userData;
            $user_id = $userData['id'];

            /**
             * this section for web optin wehen user pass token and we can generate token
             */
            if (isset($request->business_email)) {
                $user = Users::where('email', $request->business_email)->first();
                $token = JWTAuth::fromUser($user);
                $request->request->add(['token' => $token]);
            }
            /**
             * section end
             */

            if ($request->customer_id == '') {

                $filterNumber = filterPhoneNumber($request->phone_number);

                if (!empty($filterNumber)) {
                    $request->merge(['phone_number' => $filterNumber]);
                } else {
                    //this case for validate conrrect mobile number
                    $request->merge(['phone_number' => $request->phone_number]);
                }

                if (!$this->addReviewValidator->with($request->all())->passes()) {

                    return $this->helpError(2, 'Fill required field.', $this->addReviewValidator->errors());
                }
            }

            $thirdPartyMaster = TripadvisorMaster::select('third_party_id', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')
                ->where('business_id', $businessId)
                ->whereNotNull('name')
                ->get()->toArray();

            $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                ->where('type', 'Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('name')
                ->get()->toArray();

            $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array

            Log::info("mergeArray");
            Log::info($mergeArray);

            $email = $request->email == null ? '' : $request->email;
            $phone_number = $request->phone_number == null ? '' : $request->phone_number;
            $varificationCode = randomString();
            $data = [];

            $Useremail = $userData['email'];

            /*************New Working for Add Customer with new requirements*******/
            $settings = CrmSettings::where('user_id', $user_id)->first();

            if (isset($request->enable_get_reviews)) {
                Log::info("enable_get_reviews user");

                // worked with settings to send email to customer.
                $settings = new CrmSettings();

                $settings->where('user_id', $user_id)
                    ->update(
                        [
                        'enable_get_reviews' => $request->enable_get_reviews,
                        'sending_option' => $request->sending_option,
                        'smart_routing' => $request->smart_routing,
                        'review_site' => $request->review_site,
                        'reminder' => $request->reminder,
                        'customize_email' => $request->customize_email,
                        'customize_sms' => $request->customize_sms
                        ]);

                $request->merge(
                    [
                        'varification_code' => $request->varification_code,
                        'recipient_id' => $request->customer_id
                    ]);

                $settings = CrmSettings::where('user_id', $user_id)->first();
                $settings['business_id'] = $businessId;
                $settings['business_name'] = $businessName;
                $settings['user_email'] = $Useremail;
//                if($settings['smart_routing'] == 'disable'){
//                    $settings['type'] = $request->review_site;
//                }

                if (!empty($settings['smart_routing']) && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {

                    // && $settings['smart_routing'] == 'Enable'
                    if (!empty($settings)) {
                        Log::info('request before smsEmailSending');
                        Log::info($request);

                        Log::info('settings before smsEmailSending');
                        Log::info($settings);
                        $response = $this->smsEmailSending($request, $settings);

                        Log::info('settings response');
                        Log::info($response);
                    }
                }
            }
            else if (!empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'No') {
                $recipient = Recipient::create(
                    [
                        'email' => $email,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_number' => $phone_number,
                        'user_id' => $user_id,
                        'country_code' => $request->country_code,
                        'country' => $request->country
                    ]
                );
            }
            else if (!empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes') {

                // only create recipient
                $recipient = Recipient::create(
                    [
                        'smart_routing' => $settings->smart_routing,
                        'email' => $email,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_number' => $phone_number,
                        'user_id' => $user_id,
                        'varification_code' => $varificationCode,
                        'country_code' => $request->country_code,
                        'country' => $request->country,
                        'birthdate' => $request->birthdate,
                        'birthmonth' => $request->birthmonth
                    ]
                );

                $data = [
                    'customer_id' => $recipient->id,
                    'varification_code' => $recipient->varification_code
                ];

                $request->merge(['varification_code' => $recipient->varification_code, 'recipient_id' => $recipient->id]);

                if (isset($request->business_email) && !empty($request->business_email)) {
                    $settings['business_id'] = $businessId;
                    $settings['business_name'] = $businessName;
                    $settings['user_email'] = $Useremail;

                    if (!empty($settings['smart_routing']) && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
                        if (!empty($settings)) {
                            $this->smsEmailSending($request, $settings);
                        }
                    }
                }
            }
            /*************New Working for Add Customer with new requirements*******/

            return $this->helpReturn("Customer Added Successfully.", $data);

//
//            $recipient = Recipient::create(['email' => $email, 'first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $phone_number, 'user_id' => $user['id'], 'varification_code' => $varificationCode,'country_code' => $request->country_code ,'country' => $request->country]);
//            $request->merge(['varification_code' => $varificationCode, 'recipient_id' => $recipient->id]);
//            if(!empty($mergeArray)) { //check third party exist or not if not just add customer above
//                //get Settings for furthor actions
//
//
//
//                $settings = CrmSettings::where('user_id', $user['id'])->first();
//                $settings['business_id'] = $businessId;
//                $settings['business_name'] = $businessName;
//                $settings['user_email'] = $Useremail;
//
//                if (!empty($settings['smart_routing']) && $settings['smart_routing'] == 'Enable' && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
//                    Log::info('CRM Settings Done');
//                    if (!empty($settings)) {
//                        Log::info('Customer Add Successfuully now Ready for enter email and sms sending function');
//                        $this->smsEmailSending($request, $settings);
//                    }
//                }
//            }

        } catch (Exception $exception) {
            Log::info(" addCustomers > " . $exception->getMessage() . " line > " . $exception->getLine());
            return $this->helpError(1, 'Some Problem happened. please try again.');

        }
    }

    public function updateCustomer($id, $request)
    {
        try {
            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }

            $user = $checkPoint['records'];
            $Useremail = $user['email'];
            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }
            $businessId = $businessResult['records']['business_id'];
            $businessName = $businessResult['records']['name'];

            $record = Recipient::where(['id' => $id, 'user_id' => $user['id']])->first();

            if (empty($record)) {
                return $this->helpError("404", "Customer Not Found");
            }

            $filterNumber = filterPhoneNumber($request->phone_number);

            if (!empty($filterNumber)) {
                $request->merge(['phone_number' => $filterNumber]);
            } else {
                $request->merge(['phone_number' => $request->phone_number]);
            }

            if (!$this->editCustomerValidator->with($request->all())->passes()) {

                return $this->helpError(2, 'Fill required field.', $this->editCustomerValidator->errors());
            }

            /********Custome Validation Area******/
            if (isset($checkPoint['records']['email'])) {
                $errorArray = [];
                $user_id = $checkPoint['records']['id'];


                $emailAll = Recipient::where('user_id', $user_id)->where('email', '!=', '')->where('id', '!=', $id)->get()->toArray();
                $email = false;
                foreach ($emailAll as $item) {
                    if (strlen($item['email']) > 100) {
                        if (Crypt::decrypt($item['email']) == $request['email']) {
                            $email = true;
                        }
                    } else {
                        if ($item['email'] == $request['email']) {
                            $email = true;
                        }
                    }
                }

                $phoneAll = Recipient::where('user_id', $user_id)->where('phone_number', '!=', '')->where('id', '!=', $id)->get()->toArray();
                $phone_number = false;
                foreach ($phoneAll as $phone) {
                    if (strlen($phone['phone_number']) > 100) {
                        if (Crypt::decrypt($phone['phone_number']) == $filterNumber) {
                            $phone_number = true;
                        }
                    } else {
                        if ($phone['phone_number'] == $request['phone_number']) {
                            $phone_number = true;
                        }
                    }
                }


                if (!empty($email) && $email == true && !empty($phone_number) && $phone_number == true) {

                    $errorArray = [
                        [
                            'map' => 'email',
                            'message' => 'Email address already exists. Enter a different email.',
                        ],
                        [
                            'map' => 'phone_number',
                            'message' => 'Phone number already exists. Enter a different phone number.',
                        ]
                    ];
                    return $this->helpError(2, 'Fill required field.', $errorArray);
                } else if (!empty($email) && $email == true) {
                    $errorArray[] = [
                        'map' => 'email',
                        'message' => 'Email address already exists. Enter a different email.',
                    ];
                    return $this->helpError(2, 'Fill required field.', $errorArray);
                } else if (!empty($phone_number) && $phone_number == true) {
                    $errorArray[] = [
                        'map' => 'phone_number',
                        'message' => 'Phone number already exists. Enter a different phone number.',
                    ];
                    return $this->helpError(2, 'Fill required field.', $errorArray);
                }
            }

            /********Custom Validation Area******/

            $email = $request->email == null ? '' : $request->email;
            $phone_number = $request->phone_number == null ? '' : $request->phone_number;

            $thirdPartyMaster = TripadvisorMaster::select('third_party_id', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();
            $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                ->where('type', 'Facebook')
                ->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();

            $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array


            $settings = CrmSettings::where('user_id', $user['id'])->first();
            $flag = false;

            if (!empty($settings['sending_option']) && $settings['enable_get_reviews'] == 'Yes') {

                if ($settings->sending_option == 1) {

                    if (empty($email) && $phone_number != $record->phone_number) {
                        $flag = true;
                        $request->merge(['email' => '']);

                    } else if ($email != $record->email) {
                        $flag = true;
                        $request->merge(['phone_number' => '']);

                    }

                } else if ($settings->sending_option == 2) {
                    if (empty($phone_number) && $email != $record->email) {
                        $flag = true;
                        $request->merge(['phone_number' => '']);
                    } else if ($phone_number != $record->phone_number) {
                        $flag = true;
                        $request->merge(['email' => '']);
                    }
                } else {
                    if ($phone_number != $record->phone_number && $email != $record->email) {
                        $flag = true;

                    } else if ($email != $record->email) {
                        $flag = true;
                        $request->merge(['phone_number' => '']);
                    } else if ($phone_number != $record->phone_number) {
                        $flag = true;
                        $request->merge(['email' => '']);
                    }
                }

            }
            $record->update(['email' => $email, 'first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $phone_number]);

            $request->merge(['varification_code' => $record->varification_code, 'recipient_id' => $record->id, 'action' => 'update']);

            if (!empty($mergeArray)) {

                if ($flag == true) {

                    $settings['business_id'] = $businessId;
                    $settings['business_name'] = $businessName;
                    $settings['user_email'] = $Useremail;

                    if (!empty($settings['smart_routing']) && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
                        // && $settings['smart_routing'] == 'Enable'
                        if (!empty($settings)) {
                            $this->smsEmailSending($request, $settings);
                        }
                    }
                } else {
                    Log::info('false');
                }
            }

            return $this->helpReturn("Customer Updated Successfully.");

        } catch (Exception $exception) {
            return $this->helpError('addCustomers', 'Some Problem happened. please try again.');
        }
    }

    public function addPatientCustomer($request)
    {
        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();

        $businessResult = $businessResult['records'];
        $businessId = $businessResult['business_id'];
        $userID = $businessResult['user_id'];
        $email = $request->email;

        $result = Recipient::where('user_id', $userID)
                            ->where('email', $email)
                            ->first();
        if(empty($result)) {
            $recipient = Recipient::create(
                [
                    'email' => $email,
                    'user_id' => $userID
                ]
            );

            return $this->helpReturn("Contact Email added Successfully in below list.", $recipient);
        }
        else{
            return $this->helpError(4, 'Contact Email already exists in below list.');
        }
    }

    public function addPatientCustomerN($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];
            $email = $request->email;
            $data = $request->all();
            $data['user_id'] = $userID;


            $result = Recipient::where('user_id', $userID)
                ->where('email', $email)
                ->first();

            Log::info("data");
            Log::info($data);

            if(empty($result)) {
                $recipient = Recipient::create($data);

                return $this->helpReturn("Contact Email added Successfully in below list.", $recipient);
            }
            else{
                return $this->helpError(4, 'Contact Email already exists in below list.');
            }
        }
        catch (Exception $e)
        {
            Log::info("addPatientCustomerN > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }

    public function editPatientCustomer($request)
    {
        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();

        $businessResult = $businessResult['records'];
        $businessId = $businessResult['business_id'];
        $userID = $businessResult['user_id'];
        $data = $request->except('id', 'send');
        $id = $request->id;

        $result = Recipient::where(
            ['id' => $id, 'user_id' => $userID]
        )->first();

        if (empty($result)) {
            return $this->helpError("404", "No customer found.");
        }
        elseif(!empty($result)) {

            Recipient::where(
                ['id' => $id, 'user_id' => $userID])
                    ->update($data);

            return $this->helpReturn("Info Updated");
        }
        return $this->helpError("404", "No Info updated");
    }

    public function sendExistingCustomerReviewRequest($request)
    {

        $businessObj = new BusinessEntity();
        $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

        if ($checkPoint['_metadata']['outcomeCode'] != 200) {
            return $checkPoint;
        }

        $user = $checkPoint['records'];
        $Useremail = $user['email'];
        $businessResult = $businessObj->userSelectedBusiness($user);

        if ($businessResult['_metadata']['outcomeCode'] != 200) {
            return $this->helpError(1, 'Problem in selection of user business.');
        }
        $businessId = $businessResult['records']['business_id'];
        $businessName = $businessResult['records']['name'];
        if (isset($request->enable_get_reviews)) {
            $settings = new CrmSettings();
            $settings->where('user_id', $user['id'])->update(['enable_get_reviews' => $request->enable_get_reviews, 'sending_option' => $request->sending_option,
                'smart_routing' => $request->smart_routing, 'review_site' => $request->review_site,
                'reminder' => $request->reminder, 'customize_email' => $request->customize_email, 'customize_sms' => $request->customize_sms]);


            $settings = CrmSettings::where('user_id', $user['id'])->first();
            $settings['business_id'] = $businessId;
            $settings['business_name'] = $businessName;
            $settings['user_email'] = $Useremail;

            $customers = Recipient::whereIn('id', $request->customers)->get()->toArray();
            foreach ($customers as $customer) {

                $request->merge(['varification_code' => $customer['varification_code'], 'recipient_id' => $customer['id'], 'email' => $customer['email'], 'first_name' => $customer['first_name'], 'last_name' => $customer['last_name'], 'smart_routing' => $customer['smart_routing'], 'phone_number' => $customer['phone_number']]);

                if (!empty($settings['smart_routing']) && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
                    if (!empty($settings)) {
                        $this->smsEmailSending($request, $settings);
                    }
                }
            }
        }

        return $this->helpReturn("Review Request Sent Successfully.");
    }

    public function smsEmailSending($request, $settings)
    {
        Log::info(" smsEmailSending ");
        $user_id = session('user_data')['id'];
        $user = Users::find($user_id);
        $formatToReplace = array(" ", "’", "'", "--", "&", "$", "/", ",", "-", "(", ")", "+", "*", "%", "!", "@", "#", "^", "_", "=", "|", "}", "{", ".", "~", "`", "<", ">");
        $replaceFormat = array("", "-", "", "", "", "", "", "", "", "");

        $FormatedBusiness = str_replace($formatToReplace, $replaceFormat, $settings['business_name']);

        //$request contain all customer related data
        //$settings contain all user related data like user settings data and user email ,business name , bussiness id etc

        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

        $encodedurl = 'https://app.trustyy.io'; //use for local
//        $encodedurl = getDomain(); //use for server
        try {
            $msg = '';

            if (isset($request->phone_number) && !empty($request->phone_number)) {
                //$url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $FormatedBusiness;
                $url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $settings['business_id'];
                if (empty($settings['customize_sms'])) {
                    $msg = "Thanks for choosing " . $settings['business_name'] . ".I'd like to invite you to tell us about your experience. Any feedback is appreciated - " . $url;
                } else {
                    $msg = $settings['customize_sms'] . '.' . $url;
                }
            }

            if (strtolower($settings['smart_routing']) == 'enable') {
                $finalRedirectUrlArray = $this->smartRouting($settings['business_id'], $settings['smart_routing'] = 'enable', $request->recipient_id, $allSites = [], $flag = false);

                Log::info("finalRedirectUrlArray");
                Log::info($finalRedirectUrlArray);
            }
            else if (strtolower($settings['smart_routing']) == 'disable') {
                $thirdPartyMaster = TripadvisorMaster::select('third_party_id', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')->where('type', $settings['review_site'])->where('business_id', $settings['business_id'])->whereNotNull('name')->get()->toArray();
                $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                    ->where('type', $settings['review_site'])->where('business_id', $settings['business_id'])->whereNotNull('name')->get()->toArray();

                $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array
                $finalRedirectUrlArray = $mergeArray;

            }

            Log::info($finalRedirectUrlArray);
            Log::info($finalRedirectUrlArray);
            if (isset($finalRedirectUrlArray['_metadata']['outcomeCode']) && $finalRedirectUrlArray['_metadata']['outcomeCode'] == 200 || isset($finalRedirectUrlArray[0])) {

                try {
                    if (isset($finalRedirectUrlArray[0])) {
                        $siteType = getThirdPartyTypeLongToShortForm($finalRedirectUrlArray[0]['type']);
                    } else {
                        $siteType = getThirdPartyTypeLongToShortForm($finalRedirectUrlArray['records']['type']);
                    }
                    Log::info('$request');
                    Log::info($request);
                    Log::info('$settings');
                    Log::info($settings);
                    if (isset($settings['sending_option']) && $settings['sending_option'] == '5' && !empty($request->phone_number) && !empty($request->email)) {
                        //both sms & email

                        $emailReview = ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);
                        $smsReview = ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'status' => 'READY_TO_SEND']);
                        $url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $settings['business_id'] . '/' . $smsReview->id;
                        $url = Bitly::getUrl($url); 
                        if (empty($settings['customize_sms'])) {
                            $msg = "Thanks for choosing " . $settings['business_name'] . ".I'd like to invite you to tell us about your experience. Any feedback is appreciated - " . $url;
                        } else {
                            $msg = $settings['customize_sms'] . '.' . $url;
                        }

                        // Your Account SID and Auth Token from twilio.com/console
                        $sid = config('apikeys.TWILIO_SID');
                        $token = config('apikeys.TWILIO_TOKEN');
                        $client = new Client( $sid, $token );
                       
                        $phone_number = '+'.$request->country_code.$request->phone_number;

                        $client->messages->create(
                            $phone_number,
                            [
                                'from' => config('apikeys.TWILIO_FROM'),
                                'body' => $msg,
                            ]
                        );
                        
                        $user->smsrequestlog->decrement('remaining');
                       
                        $smsReview->update(['message_body' => $msg]);

                        if (isset($request->action)) {
                            SendingHistory::where('customer_id', $request->recipient_id)->update(['sms_count' => DB::raw('sms_count + 1'), 'email_count' => DB::raw('email_count + 1'), 'sms_last_sent' => $formatedDate, 'email_last_sent' => $formatedDate]);
                        } else {
                            SendingHistory::create(
                                ['customer_id' => $request->recipient_id, 'sms_count' => 1, 'email_count' => 1, 'sms_last_sent' => $formatedDate, 'email_last_sent' => $formatedDate
                                ]);
                        }
                        Log::info('$request->queue');
                        Log::info($request->queue);
                        if (isset($request->queue) && $request->queue == 'enable') {
                            // array (
                            //     'customer_id',
                            //     'varification_code',
                            //     'first_name',
                            //     'last_name',
                            //     'email',
                            //     'phone_number',
                            //     'country',
                            //     'country_code',
                            //     'enable_get_reviews',
                            //     'smart_routing',
                            //     'sending_option',
                            //     'review_site',
                            //     'reminder',
                            //     'customize_sms',
                            //     'recipient_id',
                            //   )
                            // {
                            //     "email_negative_answer_setup_message",
                            //     "email_negative_answer_setup_heading",
                            //     "personal_avatar_src",
                            //     "full_name",
                            //     "company_role",
                            //     "email_message",
                            //     "email_negative_anwser",
                            //     "email_positive_anwser",
                            //     "email_heading",
                            //     "email_subject",
                            //     "star_rating_color",
                            //     "review_number_color",
                            //     "top_background_color",
                            //     "background_image_src",
                            //     "logo_image_src",
                            //     // "customize_email",
                            //     // "customize_sms",
                            //     // "review_site",
                            //     // "reminder",
                            //     // "created_at",
                            //     // "updated_at",
                            //     // "business_id",
                            //     // "business_name",
                            //     // "user_email"
                            // }

                            //  Mail::to($request->email)->later(2,new CreateAddRecipientsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                            // Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id, $settings[''], $settings[''], ));
                            Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail(
                                $request->first_name,
                                $request->varification_code,
                                $request->email,
                                $FormatedBusiness,
                                $emailReview->id,
                                $settings['business_name'],
                                $settings['user_email'],
                                $settings['customize_email'],
                                $settings['business_id'],
                                $settings['logo_image_src'],
                                $settings['background_image_src'],
                                $settings['top_background_color'],
                                $settings['review_number_color'],
                                $settings['star_rating_color'],
                                $settings['email_subject'],
                                $settings['email_heading'],
                                $settings['email_message'],
                                $settings['email_positive_anwser'],
                                $settings['email_negative_anwser'],
                                $settings['personal_avatar_src'],
                                $settings['full_name'],
                                $settings['company_role'],
                                $settings['email_negative_answer_setup_heading'],
                                $settings['email_negative_answer_setup_message']
                            ));
                        } else {
                            Log::info('!$request->queue');
                            // Mail::to($request->email)->send(new CreateAddReciepentsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                            // Mail::to($request->email)->send(new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                            Mail::to($request->email)->send( new CreateSendReviewRequestEmail(
                                $request->first_name,
                                $request->varification_code,
                                $request->email,
                                $FormatedBusiness,
                                $emailReview->id,
                                $settings['business_name'],
                                $settings['user_email'],
                                $settings['customize_email'],
                                $settings['business_id'],
                                $settings['logo_image_src'],
                                $settings['background_image_src'],
                                $settings['top_background_color'],
                                $settings['review_number_color'],
                                $settings['star_rating_color'],
                                $settings['email_subject'],
                                $settings['email_heading'],
                                $settings['email_message'],
                                $settings['email_positive_anwser'],
                                $settings['email_negative_anwser'],
                                $settings['personal_avatar_src'],
                                $settings['full_name'],
                                $settings['company_role'],
                                $settings['email_negative_answer_setup_heading'],
                                $settings['email_negative_answer_setup_message']
                            ));
                        }

                        if (Mail::failures()) {

                        } else {
                            $user->emailrequestlog->decrement('remaining');
                            Log::info('success email');
                        }


                    }
                    else if (isset($settings['sending_option']) && $settings['sending_option'] == '4' && !empty($request->phone_number)) {
                        //sms
                        //ReviewRequest::create(['date_sent' => '', 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'message_body' => $msg, 'status' => 'READY_TO_SEND']);
                        $smsReview = ReviewRequest::create(['date_sent' => '', 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'status' => 'READY_TO_SEND']);
                        $url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $settings['business_id'] . '/' . $smsReview->id;
                        if (empty($settings['customize_sms'])) {
                            $msg = "Thanks for choosing " . $settings['business_name'] . ".I'd like to invite you to tell us about your experience. Any feedback is appreciated - " . $url;
                        } else {
                            $msg = $settings['customize_sms'] . '.' . $url;
                        }
                        $smsReview->update(['message_body' => $msg]);

                        if (isset($request->action)) {
                            SendingHistory::where('customer_id', $request->recipient_id)->update(['sms_count' => DB::raw('sms_count + 1'), 'sms_last_sent' => $formatedDate]);
                        } else {
                            SendingHistory::create(
                                [
                                    'customer_id' => $request->recipient_id,
                                    'sms_count' => 1,
                                    'email_count' => null,
                                    'sms_last_sent' => $formatedDate,
                                    'email_last_sent' => ''
                                ]);
                        }


                    }
                    else if (isset($settings['sending_option']) && $settings['sending_option'] == '3' && !empty($request->email)) {
                        //email
                        $emailReview = ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);

                        if (isset($request->queue) && $request->queue == 'enable') {

                            // Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                            Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail(
                                $request->first_name,
                                $request->varification_code,
                                $request->email,
                                $FormatedBusiness,
                                $emailReview->id,
                                $settings['business_name'],
                                $settings['user_email'],
                                $settings['customize_email'],
                                $settings['business_id'],
                                $settings['logo_image_src'],
                                $settings['background_image_src'],
                                $settings['top_background_color'],
                                $settings['review_number_color'],
                                $settings['star_rating_color'],
                                $settings['email_subject'],
                                $settings['email_heading'],
                                $settings['email_message'],
                                $settings['email_positive_anwser'],
                                $settings['email_negative_anwser'],
                                $settings['personal_avatar_src'],
                                $settings['full_name'],
                                $settings['company_role'],
                                $settings['email_negative_answer_setup_heading'],
                                $settings['email_negative_answer_setup_message']
                            ));
                            
                            //                           Mail::to($request->email)->later(2,new CreateAddRecipientsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                        } else {
                            Mail::to($request->email)->send(new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                            //  Mail::to($request->email)->send(new CreateAddReciepentsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                        }

                        if (Mail::failures()) {

                        } else {
                            Log::info('success email');
                        }

                        //ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);

                        if (isset($request->action)) {
                            SendingHistory::where('customer_id', $request->recipient_id)->update(['email_count' => DB::raw('email_count + 1'), 'email_last_sent' => $formatedDate]);
                        } else {
                            SendingHistory::create(
                                [
                                    'customer_id' => $request->recipient_id,
                                    'sms_count' => null,
                                    'email_count' => 1,
                                    'sms_last_sent' => null,
                                    'email_last_sent' => $formatedDate]);
                        }


                    }
                    else if (isset($settings['sending_option']) && $settings['sending_option'] == '2') {
                        //primary sms
                        if (!empty($request->phone_number)) {

                            //ReviewRequest::create(['date_sent' => '', 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'message_body' => $msg, 'status' => 'READY_TO_SEND']);
                            $smsReview = ReviewRequest::create(
                                [
                                    'date_sent' => null,
                                    'recipient_id' => $request->recipient_id,
                                    'site' => $siteType,
                                    'type' => 'sms',
                                    'status' => 'READY_TO_SEND'
                                ]
                            );
                            $url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $settings['business_id'] . '/' . $smsReview->id;
                            $url = Bitly::getUrl($url); 

                            if (empty($settings['customize_sms'])) {
                                $msg = "Thanks for choosing " . $settings['business_name'] . ".I'd like to invite you to tell us about your experience. Any feedback is appreciated - " . $url;
                            } else {
                                $msg = $settings['customize_sms'] . '.' . $url;
                            }

                            // Your Account SID and Auth Token from twilio.com/console
                        $sid = config('apikeys.TWILIO_SID');
                        $token = config('apikeys.TWILIO_TOKEN');
                        $client = new Client( $sid, $token );
                       
                        $phone_number = '+'.$request->country_code.$request->phone_number;

                        $client->messages->create(
                            $phone_number,
                            [
                                'from' => config('apikeys.TWILIO_FROM'),
                                'body' => $msg,
                            ]
                        );
                        $user->smsrequestlog->decrement('remaining');
                            $smsReview->update(
                                ['message_body' => $msg]
                            );


                            if (isset($request->action)) {
                                SendingHistory::where('customer_id', $request->recipient_id)->update(['sms_count' => DB::raw('sms_count + 1'), 'sms_last_sent' => $formatedDate]);
                            } else {
                                SendingHistory::create(
                                    [
                                        'customer_id' => $request->recipient_id,
                                        'sms_count' => 1,
                                        'email_count' => null,
                                        'sms_last_sent' => $formatedDate,
                                        'email_last_sent' => null
                                    ]
                                );
                            }
                        }
                        else if (!empty($request->email) && empty($request->phone_number)) {
                            $emailReview = ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);

                            if (isset($request->queue) && $request->queue == 'enable') {
                                //    Mail::to($request->email)->later(2,new CreateAddRecipientsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                                // Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                                Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail(
                                    $request->first_name,
                                    $request->varification_code,
                                    $request->email,
                                    $FormatedBusiness,
                                    $emailReview->id,
                                    $settings['business_name'],
                                    $settings['user_email'],
                                    $settings['customize_email'],
                                    $settings['business_id'],
                                    $settings['logo_image_src'],
                                    $settings['background_image_src'],
                                    $settings['top_background_color'],
                                    $settings['review_number_color'],
                                    $settings['star_rating_color'],
                                    $settings['email_subject'],
                                    $settings['email_heading'],
                                    $settings['email_message'],
                                    $settings['email_positive_anwser'],
                                    $settings['email_negative_anwser'],
                                    $settings['personal_avatar_src'],
                                    $settings['full_name'],
                                    $settings['company_role'],
                                    $settings['email_negative_answer_setup_heading'],
                                    $settings['email_negative_answer_setup_message']
                                ));
                            
                            } else {

//                                Mail::to($request->email)->send(new CreateAddReciepentsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                                // Mail::to($request->email)->send(new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                                Mail::to($request->email)->send( new CreateSendReviewRequestEmail(
                                    $request->first_name,
                                    $request->varification_code,
                                    $request->email,
                                    $FormatedBusiness,
                                    $emailReview->id,
                                    $settings['business_name'],
                                    $settings['user_email'],
                                    $settings['customize_email'],
                                    $settings['business_id'],
                                    $settings['logo_image_src'],
                                    $settings['background_image_src'],
                                    $settings['top_background_color'],
                                    $settings['review_number_color'],
                                    $settings['star_rating_color'],
                                    $settings['email_subject'],
                                    $settings['email_heading'],
                                    $settings['email_message'],
                                    $settings['email_positive_anwser'],
                                    $settings['email_negative_anwser'],
                                    $settings['personal_avatar_src'],
                                    $settings['full_name'],
                                    $settings['company_role'],
                                    $settings['email_negative_answer_setup_heading'],
                                    $settings['email_negative_answer_setup_message']
                                ));
                            }

                            if (Mail::failures()) {

                            } else {
                                Log::info('success email');
                            }

                            //  ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);


                            if (isset($request->action)) {
                                SendingHistory::where('customer_id', $request->recipient_id)->update(['email_count' => DB::raw('email_count + 1'), 'email_last_sent' => $formatedDate]);
                            } else {
                                SendingHistory::create(['customer_id' => $request->recipient_id, 'sms_count' => '', 'email_count' => 1, 'sms_last_sent' => null, 'email_last_sent' => $formatedDate]);
                            }

                        }
                    }
                    else if (isset($settings['sending_option']) && $settings['sending_option'] == '1') {
                        //primary email

                        if (!empty($request->email)) {
                            $emailReview = ReviewRequest::create
                            (
                                [
                                    'date_sent' => $formatedDate,
                                    'recipient_id' => $request->recipient_id,
                                    'site' => $siteType,
                                    'type' => 'email'
                                ]
                            );

                            if (isset($request->queue) && $request->queue == 'enable') {
                                
                                // Mail::to($request->email)->later(2,new CreateAddRecipientsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                                // Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                            
                                Mail::to($request->email)->later(2, new CreateSendReviewRequestEmail(
                                    $request->first_name,
                                    $request->varification_code,
                                    $request->email,
                                    $FormatedBusiness,
                                    $emailReview->id,
                                    $settings['business_name'],
                                    $settings['user_email'],
                                    $settings['customize_email'],
                                    $settings['business_id'],
                                    $settings['logo_image_src'],
                                    $settings['background_image_src'],
                                    $settings['top_background_color'],
                                    $settings['review_number_color'],
                                    $settings['star_rating_color'],
                                    $settings['email_subject'],
                                    $settings['email_heading'],
                                    $settings['email_message'],
                                    $settings['email_positive_anwser'],
                                    $settings['email_negative_anwser'],
                                    $settings['personal_avatar_src'],
                                    $settings['full_name'],
                                    $settings['company_role'],
                                    $settings['email_negative_answer_setup_heading'],
                                    $settings['email_negative_answer_setup_message']
                                ));
                            } else {

                                // Mail::to($request->email)->send(new CreateSendReviewRequestEmail($request->first_name, $FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'], $settings['customize_email'], $settings['business_id'], $emailReview->id));
                                Mail::to($request->email)->send( new CreateSendReviewRequestEmail(
                                    $request->first_name,
                                    $request->varification_code,
                                    $request->email,
                                    $FormatedBusiness,
                                    $emailReview->id,
                                    $settings['business_name'],
                                    $settings['user_email'],
                                    $settings['customize_email'],
                                    $settings['business_id'],
                                    $settings['logo_image_src'],
                                    $settings['background_image_src'],
                                    $settings['top_background_color'],
                                    $settings['review_number_color'],
                                    $settings['star_rating_color'],
                                    $settings['email_subject'],
                                    $settings['email_heading'],
                                    $settings['email_message'],
                                    $settings['email_positive_anwser'],
                                    $settings['email_negative_anwser'],
                                    $settings['personal_avatar_src'],
                                    $settings['full_name'],
                                    $settings['company_role'],
                                    $settings['email_negative_answer_setup_heading'],
                                    $settings['email_negative_answer_setup_message']
                                ));
                                //Mail::to($request->email)->send(new CreateAddRecipientsEmail($request->first_name,$FormatedBusiness, $settings['business_name'], $request->varification_code, $request->email, $settings['user_email'],$settings['customize_email'],$settings['business_id'],$emailReview->id));
                            }

                            if (Mail::failures()) {

                            } else {
                                $user->emailrequestlog->decrement('remaining');
                                Log::info('success email');
                            }
                            // ReviewRequest::create(['date_sent' => $formatedDate, 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'email']);
                            if (isset($request->action)) {

                                Log::info("inside action ");
                                Log::info($request->action);

                                SendingHistory::where('customer_id', $request->recipient_id)
                                    ->update(
                                        [
                                            'email_count' => DB::raw('email_count + 1'),
                                            'email_last_sent' => $formatedDate
                                        ]
                                    );
                            } else {
                                // testing
                                SendingHistory::create(
                                    [
                                        'customer_id' => $request->recipient_id,
                                        'sms_count' => null,
                                        'email_count' => 1,
                                        'sms_last_sent' => null,
                                        'email_last_sent' => $formatedDate
                                    ]);
                            }
                        }
                        else if (!empty($request->phone_number) && empty($request->email)) {

                            //ReviewRequest::create(['date_sent' => '', 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'message_body' => $msg, 'status' => 'READY_TO_SEND']);
                            $smsReview = ReviewRequest::create(['date_sent' => '', 'recipient_id' => $request->recipient_id, 'site' => $siteType, 'type' => 'sms', 'status' => 'READY_TO_SEND']);
                            $url = $encodedurl . '/business-review/' . $request->phone_number . '/' . $request->varification_code . '/' . $settings['business_id'] . '/' . $smsReview->id;
                            if (empty($settings['customize_sms'])) {
                                $msg = "Thanks for choosing " . $settings['business_name'] . ".I'd like to invite you to tell us about your experience. Any feedback is appreciated - " . $url;
                            } else {
                                $msg = $settings['customize_sms'] . '.' . $url;
                            }
                            $smsReview->update(['message_body' => $msg]);
                            if (isset($request->action)) {

                                SendingHistory::where('customer_id', $request->recipient_id)->update(['sms_count' => 1, 'sms_last_sent' => $formatedDate]);
                            } else {
                                SendingHistory::create(['customer_id' => $request->recipient_id, 'sms_count' => 1, 'email_count' => '', 'sms_last_sent' => $formatedDate, 'email_last_sent' => '']);
                            }
                        }

                    }

                } catch (\Exception $e) {
                    Log::info('Email Releven Exception');
                    Log::info($e->getMessage() . ' > ' . $e->getLine());
                }
            }
            else {
                Recipient::where('id', $request->recipient_id)->delete();
                return $finalRedirectUrlArray;
            }

        } catch (Exception $exception) {
            Log::info("smsEmailSending " . $exception->getMessage() . ' > ' . $exception->getLine());
        }
    }

    public function smartRouting($businessId, $smartRouting, $reciepentId, $allSites = [], $flag)
    {
        try {

            Log::info("smartRouting > businessId > $businessId (smartRouting $smartRouting ) > ( flag > $flag )" );
            Log::info($allSites);

            $businessName = Business::select('practice_name')->where('business_id', $businessId)->first();

            //feedback case
            if ($smartRouting == 'enable' && !empty($allSites)) { //case when user add recipient
                Log::info("smartRouting > main IF ");
                $typeArray = [];
                foreach ($allSites as $value) {
                    $typeArray[] = ['type' => getThirdPartyTypeShortToLongForm($value['site'])];
                }

                $thirdPartyMaster = ThirdPartyMaster::select('third_party_id', 'page_url',  'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')
                    ->whereNotIn('type', $typeArray)
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')
                    ->get()->toArray();

                Log::info("smartRouting thirdPartyMaster");
                Log::info($thirdPartyMaster);

                $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'page_url', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                    ->whereNotIn('type', $typeArray)
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')
                    ->get()->toArray();

                Log::info("smartRouting $socialMediaMaster");
                Log::info($socialMediaMaster);

                $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array

            }

            else if ($flag == true) {
                //case for when user pass feedback

                Log::info("smartRouting > main ELSE If Flag $flag ");

                $site = ReviewRequest::select('site', 'flag')
                    ->where('recipient_id', $reciepentId)
                    ->first()->toArray();

                $type = getThirdPartyTypeShortToLongForm($site['site']);

                $typeArray = thirdPartySources();

                $thirdPartyMaster = ThirdPartyMaster::select('third_party_id', 'page_url', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')
                    ->whereIn('type', $typeArray)
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')
                    ->get()->toArray();

                $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'page_url', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                    ->whereIn('type', $typeArray)
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')->get()->toArray();

                $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array

            }
            else { //default case mostly use in add and update customer when review require
                Log::info("smartRouting > main ELSE Flag $flag ");


                $thirdPartyMaster = ThirdPartyMaster::select('third_party_id', 'page_url', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')
                    ->get()->toArray();

                $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'page_url', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                    ->where('type', 'Facebook')
                    ->where('business_id', $businessId)
                    ->whereNotNull('name')->get()->toArray();

                $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array

            }

            if (!empty($mergeArray)) {

                if ($smartRouting == 'enable') {
                    //check smart routing

                    //find minimum value of average array
                    $minimumRatingValue = min(array_column($mergeArray, 'average_rating'));

                    Log::info("minimumRatingValue ");
                    Log::info($minimumRatingValue );

                    $minimumRatingValueFound = Arr::where($mergeArray, function ($value, $key) use ($minimumRatingValue) {
                        return $value['average_rating'] == $minimumRatingValue;
                    });


                    Log::info("minimumRatingValueFound ");
                    Log::info($minimumRatingValueFound );

                    $minimumRatingValueFound = array_values($minimumRatingValueFound);

                    Log::info("minimumRatingValueFound COL");
                    Log::info($minimumRatingValueFound );

                    if (count($minimumRatingValueFound) == 1) {
                        // if all values are equal then we use review count in else part
                        $finalRedirectUrlArray = $minimumRatingValueFound[0];

                    } else {

                        $minimumReviewValue = min(array_column($mergeArray, 'review_count')); //again as above we find minimum value of Review Count instead of Rating

                        $minimumReviewValueFound = Arr::where($mergeArray, function ($value, $key) use ($minimumReviewValue) {
                            return $value['review_count'] == $minimumReviewValue;
                        });

                        $minimumReviewValueFound = array_values($minimumReviewValueFound);

                        if (count($minimumReviewValueFound) == 1) {  //if single record find
                            $finalRedirectUrlArray = $minimumReviewValueFound[0];


                        } else {
                            if (isset($minimumReviewValueFound[0])) {
                                $finalRedirectUrlArray = $minimumReviewValueFound[0];
                            }
                        }
                    }

                    if(empty($finalRedirectUrlArray['add_review_url']))
                    {
                        $finalRedirectUrlArray['add_review_url'] = (!empty($finalRedirectUrlArray['page_url'])) ? $finalRedirectUrlArray['page_url'] : '';
                    }
                }
                else {
                    //if smart routing disable

                    $finalRedirectUrlArray = $mergeArray;
                }

                Log::info("update flag $flag" );

                if ($flag == true) {
                    Log::info("inside flag $flag" );
                    $shortType = '';
                    $shortType = getThirdPartyTypeLongToShortForm($finalRedirectUrlArray['type']);
                    ReviewRequest::where('recipient_id', $reciepentId)->update(['site' => $shortType]);
                }

                return $this->helpReturn("site listing.", $finalRedirectUrlArray);
            }
            else {
                ReviewRequest::where('recipient_id', $reciepentId)->update(['flag' => 'deleted']);
                $messsage = "Unable to find review site. $businessName->name has already removed this site. Please contact $businessName->name.";
                return $this->helpError(404, $messsage);
            }

        } catch (Exception $exception) {
            Log::info("smartRouting " . $exception->getMessage() . " line > " . $exception->getLine() );
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }


    public function addCustomerSettings($request)
    {
        //try {
        $businessObj = new BusinessEntity();
        $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

        if ($checkPoint['_metadata']['outcomeCode'] != 200) {
            return $checkPoint;
        }

        $user = $checkPoint['records'];
        $Useremail = $user['email'];
        $businessResult = $businessObj->userSelectedBusiness($user);

        if ($businessResult['_metadata']['outcomeCode'] != 200) {
            return $this->helpError(1, 'Problem in selection of user business.');
        }
        $businessId = $businessResult['records']['business_id'];
        $businessName = $businessResult['records']['name'];
        $settings = CrmSettings::where('user_id', $user['id'])->first();

        if (!empty($settings)) {

            CrmSettings::where('id', '=', $settings->id)->update(['enable_get_reviews' => $request->enable_get_reviews, 'smart_routing' => $request->smart_routing, 'sending_option' => $request->sending_option, 'customize_email' => $request->email_message, 'customize_sms' => $request->sms_message, 'review_site' => $request->review_site, 'reminder' => $request->reminder, 'user_id' => $user['id']]);
        } else {
            CrmSettings::create(['enable_get_reviews' => $request->enable_get_reviews, 'smart_routing' => $request->smart_routing, 'sending_option' => $request->sending_option, 'user_id' => $user['id']]);
        }

        return $this->helpReturn("Settings Updated Successfully.");
//
//        } catch (Exception $exception) {
//            return $this->helpError('addCustomerSettings', 'Some Problem happened. please try again.');
//        }
    }

    public function customerSettingsList($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];

            $settings = CrmSettings::select('id', 'enable_get_reviews', 'smart_routing', 'review_site', 'reminder', 'sending_option', 'customize_email', 'customize_sms')
                ->where('user_id', $userID)
                ->first();

            return $this->helpReturn("Setting List", $settings);

        } catch (Exception $exception) {
            return $this->helpError('customerSettingsList', 'Some Problem happened. please try again.');
        }
    }

    public function customersList($data)
    {
        try
        {
        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();

        if ($businessResult['_metadata']['outcomeCode'] != 200) {
            return $this->helpError(1, 'Problem in selection of your business.');
        }

        $businessResult = $businessResult['records'];
        $businessId = $businessResult['business_id'];
        $userID = $businessResult['user_id'];

//        print_r(Recipient::select('id', 'email', 'phone_number', 'created_at', 'first_name', 'last_name')->get());
//        exit;

        $customers = Recipient::select('id', 'email', 'phone_number', 'created_at', 'first_name', 'last_name')
            ->where('user_id', $userID)
            ->wherenull('deleted_at')
            ->with(['reviewRequest' => function ($q) {
                $q->select('recipient_id', 'status', 'review_status', 'message', 'type');
            }]);


//        print_r($customers);
//        exit;
        // return $this->helpReturn("Customers List", $customers);
        $data = [];

        $datatable = DataTables::of($customers)
            ->editColumn('first_name', function ($data) {
                return strlen($data->first_name) > 100 ? Crypt::decrypt($data->first_name) : $data->first_name;
            })
            ->editColumn('last_name', function ($data) {
                // return $data->last_name;
                return strlen($data->last_name) > 100 ? Crypt::decrypt($data->last_name) : $data->last_name;
            })->addColumn('name', function ($data) {
                $name = '';
                !empty($data->first_name && $data->last_name) ? $name = $data->first_name . ' ' . $data->last_name : (!empty($data->first_name) ? $name = $data->first_name : (!empty($data->last_name) ? $name = $data->last_name : ''));
                return $name;
            })->addColumn('extra', function ($data) {
                return '';
            });


        $crmSettings = CrmSettings::where('user_id', $userID)->first();
        //add new key for identify front end screen , direct customer or customer with review screen
        $value = !empty($crmSettings['enable_get_reviews']) && $crmSettings['enable_get_reviews'] == 'Yes' ? 'enabled' : 'disabled';


        $data['customers'] = collect($datatable->make(true)->getData());
        $data['enable_get_reviews'] = $value;

        $customersData = $datatable->make(true)->getData();

        $carbon = new Carbon();
        foreach($customersData->data as $index => $customer)
        {
            $createdAt = $carbon->createFromTimestamp(strtotime($customer->created_at),'EST');

            $time =  $createdAt->format('Y-m-d H:i:s');

            $customersData->data[$index]->created_at = $time;
        }

        $data['customers'] = collect($customersData);

        return $this->helpReturn("Customers List", $data);
        } catch (Exception $exception) {
            Log::info(" customersList " . $exception->getMessage());
//            print_r($exception->getMessage());
            return $this->helpError('customersList', 'Some Problem happened. please try again.');
        }
    }

    public function getCustomersById($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }

            $user = $checkPoint['records'];
            $Useremail = $user['email'];
            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $customer = Recipient::with(['reviewRequest' => function ($q) {
                $q->select('recipient_id', 'site', 'type', 'date_sent');
            }])
                ->where('id', '=', $request->customer_id)
                ->where('user_id', '=', $user['id'])
                ->select('id', 'email', 'phone_number', 'created_at', 'first_name', 'last_name')
                ->first();
            $settings = CrmSettings::where('user_id', $user['id'])->first();


            // select('id', 'email', 'phone_number', 'created_at', 'first_name', 'last_name')
//                where('id', '=', $request->customer_id)
//                ->where('user_id', '=', $user['id'])
//                ->with('reviewRequest')
//                ->first();

            $appendArray = null;
            if ($customer != null) {
                $customer = $customer->toArray();
                $name = '';
                $firstName = strlen($customer['first_name']) > 100 ? Crypt::decrypt($customer['first_name']) : $customer['first_name'];
                $lastName = strlen($customer['last_name']) > 100 ? Crypt::decrypt($customer['last_name']) : $customer['last_name'];
                $phone = strlen($customer['phone_number']) > 100 ? Crypt::decrypt($customer['phone_number']) : $customer['phone_number'];
                $email = strlen($customer['email']) > 100 ? Crypt::decrypt($customer['email']) : $customer['email'];
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $customer['created_at'])->format('Y-m-d');
                !empty($firstName && $lastName) ? $name = $firstName . ' ' . $lastName : (!empty($firstName) ? $name = $firstName : (!empty($lastName) ? $name = $lastName : ''));

                $appendArray['id'] = $customer['id'];
                $appendArray['created_at'] = $date;
                $appendArray['name'] = $name;
                $appendArray['review_request'] = $customer['review_request'];
                $appendArray['smart_routing'] = $settings->smart_routing;
                $appendArray['phone_number'] = !empty($phone) ? $phone : '';;
                $appendArray['email'] = !empty($email) ? $email : '';;
                $appendArray['first_name'] = !empty($firstName) ? $firstName : '';
                $appendArray['last_name'] = !empty($lastName) ? $lastName : '';
            } else {
                return $this->helpError('404', 'Customer Not Exist.');
            }

            return $this->helpReturn("Customers List", $appendArray);

        } catch (Exception $exception) {
            return $this->helpError('getCustomersById', 'Some Problem happened. please try again.');
        }
    }

    public function deleteCustomer($request)
    {
        try {
            $ids = explode(",", $request->customerID);

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];

            Log::info('user_id');
            Log::info($userID);

            Log::info('id');
            Log::info($ids);

            $customer = Recipient::whereIn('id', $ids)->where('user_id', $userID)->get()->toArray();
            Log::info('customer');
            Log::info($customer);

            if (!empty($customer)) {
                Recipient::whereIn('id', $ids)->where('user_id', $userID)->delete();
            } else {
                return $this->helpError(404, 'Record Not Exists');
            }

            return $this->helpReturn("Customer Deleted Successfully.");
        } catch (Exception $exception) {
            Log::info("deleteCustomer " . $exception->getMessage() . '> ' . $exception->getLine());
            return $this->helpError('deleteCustomer', 'Some Problem happened. please try again.');
        }
    }

    public function smsEmailSendCronJob($request)
    {
        try {
            /****New Working******/
            //->where('id',1381)
            Users::select('id', 'email')->with('singleBusiness', 'recipients.sendingHistory', 'recipients.reviewRequestForNegativeFeedback', 'recipients.reviewRequestForPostitiveFeedback')
                ->chunk(200, function ($users) use ($request) {
                    foreach ($users->toArray() as $user) {
                        Log::info('check recipeints');
                        Log::info($user);

                        if (!empty($user['recipients'])) {
                            foreach ($user['recipients'] as $recipient) {

                                if (!isset($recipient['review_request_for_negative_feedback']) && empty($recipient['review_request_for_negative_feedback']) && !empty($recipient['review_request_for_postitive_feedback'])) {

                                    if (isset($recipient['sending_history'])) {
                                        $checkEmailLastSendDate = Carbon::createFromFormat('Y-m-d H:i:s', $recipient['sending_history']['email_last_sent'])->format('D');
                                    }
                                    if (!empty($recipient['sending_history'])) {

                                        /************Get Email and SMS Sent dates differnce for sending SMS or EMAIL using Cron Job************/
                                        $diff_in_days_for_email = '';
                                        $diff_in_days_for_sms = '';

                                        if (strtotime($recipient['sending_history']['email_last_sent']) != strtotime('0000-00-00 00:00:00')) {

                                            $to_for_email = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $recipient['sending_history']['email_last_sent']);
                                            $from_for_email = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                                            $diff_in_days_for_email = $to_for_email->diffInDays($from_for_email);

                                        }

                                        if (strtotime($recipient['sending_history']['sms_last_sent']) != strtotime('0000-00-00 00:00:00')) {
                                            $to_for_sms = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $recipient['sending_history']['sms_last_sent']);
                                            $from_for_sms = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                                            $diff_in_days_for_sms = $to_for_sms->diffInDays($from_for_sms);

                                        }

                                        /************Get Settings for furthor actions************/
                                        $settings = CrmSettings::where('user_id', $user['id'])->first();
                                        $settings['business_id'] = $user['single_business']['business_id'];
                                        $settings['business_name'] = $user['single_business']['name'];
                                        $settings['user_email'] = $user['email'];

                                        /*********Work Done Due TO encryption*************/
                                        strlen($recipient['first_name']) > 100 ? $firstName = Crypt::decrypt($recipient['first_name']) : $firstName = $recipient['first_name'];
                                        strlen($recipient['email']) > 100 ? $email = Crypt::decrypt($recipient['email']) : $email = $recipient['email'];
                                        strlen($recipient['phone_number']) > 100 ? $phoneNumber = Crypt::decrypt($recipient['phone_number']) : $phoneNumber = $recipient['phone_number'];
                                        /*********Work Done Due TO encryption*************/


                                        if (!empty($settings['smart_routing']) && ($settings['smart_routing'] == 'enable' || $settings['smart_routing'] == 'Enable') && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {

                                            /**
                                             * this is for first time when cron job run and just pick record where dates have max 6 day differnce and count equal 1
                                             */
                                            if ($diff_in_days_for_email >= 6 && $recipient['sending_history']['email_count'] == 1 && $diff_in_days_for_sms >= 6 && $recipient['sending_history']['sms_count'] == 1) {
                                                $request->request->add(['queue' => 'enable']);
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => $phoneNumber, 'email' => $email, 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            } else if ($diff_in_days_for_email >= 6 && $recipient['sending_history']['email_count'] == 1) {
                                                $request->request->add(['queue' => 'enable']);
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => '', 'email' => $email, 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            } else if ($diff_in_days_for_sms >= 6 && $recipient['sending_history']['sms_count'] == 1) {
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => $phoneNumber, 'email' => '', 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            }


                                            /**
                                             * this is for second and third time when cron job run and just pick record where dates have max 6 or more days differnce and count equal 1
                                             */
                                            if ($recipient['sending_history']['email_count'] > 1 && $recipient['sending_history']['email_count'] < 4 && $diff_in_days_for_email >= 6 && $recipient['sending_history']['sms_count'] > 1 && $recipient['sending_history']['sms_count'] < 4 && $diff_in_days_for_sms >= 6) {
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => $phoneNumber, 'email' => $email, 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            } else if ($recipient['sending_history']['email_count'] > 1 && $recipient['sending_history']['email_count'] < 4 && $diff_in_days_for_email >= 6) {
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => '', 'email' => $email, 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            } else if ($recipient['sending_history']['sms_count'] > 1 && $recipient['sending_history']['sms_count'] < 4 && $diff_in_days_for_sms >= 6) {
                                                $request->merge(['varification_code' => $recipient['varification_code'], 'recipient_id' => $recipient['id'], 'phone_number' => $phoneNumber, 'email' => '', 'first_name' => $firstName, 'action' => 'update']);
                                                $this->smsEmailSending($request, $settings);
                                            }

                                        }
                                        /************RUN Three Cases depend on date difference and sms and email count************/
                                    }
                                }
                            }
                        }
                    }
                });

            return $this->helpReturn("Reminder Emails Send to All Review Requests");
        } catch (Exception $exception) {
            Log::info("smsEmailSendCronJob " . $exception->getMessage());
            return $this->helpError('smsEmailSendCronJob', 'Some Problem happened. please try again.');
        }
    }


    public function updateCRMStats($request)
    {

        try {
            $currentDate = Carbon::now();
            $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');
            $allUser = Users::select('id')->get()->toArray();

            $allCustomer = Recipient::withTrashed()->select('id')->get()->toArray();
            $allReviewRequest = ReviewRequest::select('id')->get()->toArray();
            $allPromo = Promo::select('id')->get()->toArray();

            $CustomerHistoricalStats = DB::table('user_master as um')
                ->join('recipients as cm', 'um.id', '=', 'cm.user_id')
                // ->where('um.id', 184)
                ->whereIn('um.id', $allUser)
                ->where('cm.deleted_at', '=', null)
                ->select('um.id', 'cm.created_at', DB::raw('Count(um.id) as total'))
                ->groupBy('um.id')
//                ->groupBy('cm.created_at')
                ->get()->toArray();


            if (empty($CustomerHistoricalStats)) {
                return $this->helpReturn("No Customer Found");
            }
            $dateFormat = dateFormatUsing();

            foreach ($CustomerHistoricalStats as $customerdata) {

                $CustomerCreatedDate = getFormattedDate($customerdata->created_at);

                $appendCustomerStatsArray[] = [
                    'user_id' => $customerdata->id,
                    'activity_date' => $CustomerCreatedDate,
                    'site_type' => 'CRM',
                    'count' => $customerdata->total,
                    'type' => 'CU',
                ];
            }
            $ReviewRequestStats = DB::table('recipients as cm')
                ->join('review_requests as rr', 'cm.id', '=', 'rr.recipient_id')
                ->whereIn('cm.id', $allCustomer)
                //->where('cm.created_at', '<=', $FormatedCurrentDate)
                // ->where(DB::raw("STR_TO_DATE('cm.created_at', '%Y-%m-%d')"), '=', $FormatedCurrentDate)
                ->select('cm.user_id', 'cm.id', 'rr.created_at', DB::raw('count(cm.id) as total'))
                ->groupBy('cm.id')
                ->get()->toArray();

            if (empty($ReviewRequestStats)) {
                return $this->helpReturn("No Review Request Found");
            }

            $dateFormat = dateFormatUsing();

            foreach ($ReviewRequestStats as $reviewrequestdata) {

                $ReviewRequestCreatedDate = getFormattedDate($reviewrequestdata->created_at);

                $appendReviewRequestStatsArray[] = [
                    'user_id' => $reviewrequestdata->user_id,
                    'activity_date' => $ReviewRequestCreatedDate,
                    'site_type' => 'CRM',
                    'count' => $reviewrequestdata->total,
                    'type' => 'RR',
                ];
            }

            $SmsPromo = DB::table('user_master as um')
                ->join('promo as pm', 'um.id', '=', 'pm.user_id')
                ->whereIn('um.id', $allUser)
                ->where('type', 1)
                ->select('um.id', 'pm.created_at', DB::raw('Count(um.id) as total'))
//                ->groupBy('pm.created_at')
                ->groupBy('um.id')
                ->get()->toArray();

            if (empty($SmsPromo)) {
                return $this->helpReturn("No SMS Promo Found");
            }

            $dateFormat = dateFormatUsing();

            foreach ($SmsPromo as $smspromodata) {

                $SMSPromoCreatedDate = getFormattedDate($smspromodata->created_at);

                $appendSmsPromoStatsArray[] = [
                    'user_id' => $smspromodata->id,
                    'activity_date' => $SMSPromoCreatedDate,
                    'site_type' => 'CRM',
                    'count' => $smspromodata->total,
                    'type' => 'SP',
                ];
            }


            $EmailPromo = DB::table('user_master as um')
                ->join('promo as pm', 'um.id', '=', 'pm.user_id')
                ->whereIn('um.id', $allUser)
                //              ->where('um.created_at', '<=', $FormatedCurrentDate)
                ->where('type', 2)
                ->select('um.id', 'pm.created_at', DB::raw('Count(um.id) as total'))
                ->groupBy('um.id')
                ->get()->toArray();
            if (empty($EmailPromo)) {
                return $this->helpReturn("No Email Promo Found");
            }

            $dateFormat = dateFormatUsing();

            foreach ($EmailPromo as $emailpromodata) {

                $EmailPromoCreatedDate = getFormattedDate($emailpromodata->created_at);

                $appendEmailPromoStatsArray[] = [
                    'user_id' => $emailpromodata->id,
                    'activity_date' => $EmailPromoCreatedDate,
                    'site_type' => 'CRM',
                    'count' => $emailpromodata->total,
                    'type' => 'EP',
                ];
            }

            StatTracking::whereIn('recipient_id', $allCustomer)->delete();
            StatTracking::whereIn('user_id', $allUser)->delete();
            StatTracking::insert($appendCustomerStatsArray);
            StatTracking::insert($appendReviewRequestStatsArray);
            StatTracking::insert($appendSmsPromoStatsArray);
            StatTracking::insert($appendEmailPromoStatsArray);


            $finalArray[] = [
                'Customers Stats' => $appendCustomerStatsArray,
                'Review Request' => $appendReviewRequestStatsArray,
                'SMS Promo Stats' => $appendSmsPromoStatsArray,
                'Email Promo Stats' => $appendEmailPromoStatsArray,

            ];

            return $this->helpReturn("Update CRM Module Stats", $finalArray);

        } catch (Exception $exception) {
            Log::info("updateCustomersStats " . $exception->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }


    public function addCustomersUsingFile($request)
    {

        try {

            $file = $request->file('file');

            Log::info("file ");
            Log::info($file);

            $extension = $file->getClientOriginalExtension();
            $fileName = $file->getFilename() . '.' . $extension;
            $path = request()->file('file')->getRealPath();

            Log::info("extension ");
            Log::info($extension);

            Log::info("fileName ");
            Log::info($fileName);

            Log::info("path =");
            Log::info($path);

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];
            $businessName = $businessResult['practice_name'];

            /**************************SAVE CSV FILE**********************/
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
                $fileName = $file->getFilename() . '.' . $extension;
                $path = request()->file('file')->getRealPath();
                Storage::disk('local')->put($fileName, File::get($file));
            }

            /****Get Saved File***/

            $file = fopen(storage_path('app/' . $fileName), "r");


            $flag = true;
            $appendArray = [];

            $thirdPartyMaster = TripadvisorMaster::select('third_party_id', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();
            $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                ->where('type', 'Facebook')
                ->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();

            $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array
            $settings = CrmSettings::where('user_id', $userID)->first();

            $checkRecord = Recipient::select('email', 'phone_number')->where('user_id', $userID)->get()->toArray();
            $columnEmail = array_column($checkRecord, 'email');
            $columnPhone = array_column($checkRecord, 'phone_number');

            $emailDuplicate = array();
            $phoneNumberDuplicate = array();


            $i = 1;
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {  //read the csv file

                if ($flag != true) { //not include titles in excell sheets
                    if (!empty($data['0']) && trim($data[0]) || !empty($data['1']) && trim($data[1]) || !empty($data['2']) && trim($data[2]) || !empty($data['3']) && trim($data[3])) {

                        /****New Working ******/
                        $mobile = !empty($data[3]) ? $data[3] : '';
                        $filterPhoneNumber = filterPhoneNumber($mobile);

                        $varificationCode = randomString();
                        $email = !empty($data[0]) ? $data[0] : '';
                        $first_name = !empty($data[1]) ? $data[1] : '';
                        $last_name = !empty($data[2]) ? $data[2] : '';

                        $check_email = 0;
                        $check_phone_number = 0;
                        $emailExist = 0;
                        $phoneExist = 0;

                        /******check record not duplicate********/
                        if ($i == 1) {

                            if (!empty($filterPhoneNumber)) {
                                $phoneNumberDuplicate [] = $filterPhoneNumber;
                            }

                            if (!empty($email)) {
                                $emailDuplicate [] = $email;
                            }

                        } else {
                            $checkEmailExist = in_array($email, $emailDuplicate);

                            if ($checkEmailExist == true) {

                                $emailExist = 1;
                            } else {


                                if (!empty($email)) {
                                    $emailDuplicate [] = $email;
                                }

                            }

                            $checkPhoneExist = in_array($filterPhoneNumber, $phoneNumberDuplicate);

                            if ($checkPhoneExist == true) {
                                $phoneExist = 1;

                            } else {
                                if (!empty($filterPhoneNumber)) {
                                    $phoneNumberDuplicate [] = $filterPhoneNumber;
                                }
                            }
                        }

                        $i++;
                        /***********************************Custom Validation due to encrypt data***************************************/
                        if ($phoneExist != 1 && $emailExist != 1) {
                            Log::info('cross condtion');
                            if (!empty($checkRecord)) {
                                if (!empty($email)) {
                                    $checkindex = in_array($email, $columnEmail);

                                    if ($checkindex == true) {
                                        $check_email = 1;
                                    }
                                }
                                if (!empty($filterPhoneNumber)) {
                                    $checkPhoneindex = in_array($filterPhoneNumber, $columnPhone);
                                    if ($checkPhoneindex == true) {
                                        $check_phone_number = 1;
                                    }
                                }

                            }


                            if ($check_email != 1 && $check_phone_number != 1) {

                                $appendArray[] = [
                                    'email' => $email,
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'phone_number' => $filterPhoneNumber,
                                    'varification_code' => $varificationCode,
                                    'user_id' => $userID,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];

                                $appendArray2[] = [
                                    'email' => $email,
                                    'phone_number' => $filterPhoneNumber,

                                ];
                            }
                        }
                        /****New Working ******/
                    }
                } else {
                    //validation of csv file titles
                    if (!empty($data['0']) && $data['0'] == 'email_address' && !empty($data['1']) && $data['1'] == 'first_name' && !empty($data['2']) && $data['2'] == 'last_name' && !empty($data['3']) && $data['3'] == 'phone_number') {

                    } else {
                        return $this->helpError(3, 'Incorrect column title. Review the column titles and make sure they match the required format.');
                    }
                }
                $flag = false;
            }
            fclose($file);


            /**************************GET FILE DATA IN ARRAY AND PASS TO LOOP FOR ONE BY ONE PROCESSING**********************/
//        if (empty($appendArray)) {
//            return $this->helpError(3, 'Record Not Found Please Check Your File.');
//        }
            /*******new working*****/


            $firstId = Recipient::where('user_id', $userID)->orderBy('id', 'desc')->first();

            Recipient::insert($appendArray);
            if ($firstId != null) {
                $firstidArray = ['first_id' => $firstId->id, 'flag' => 'yes'];
            } else {
                $firstId = Recipient::where('user_id', $userID)->first();
                $firstidArray = ['first_id' => $firstId->id, 'flag' => 'no'];
            }

            if (!empty($fileName)) {
                Storage::disk('local')->delete($fileName);
            }

            return $this->helpReturn("Contacts Added Successfully.", $firstidArray);
        } catch (Exception $exception) {
            Log::info("file customer section " . $exception->getMessage() . ' > ' . $exception->getLine());
            return $this->helpError('addCustomersUsingFile', 'Some Problem happened. please try again.');
        }
    }

    public function uploadCustomersFile($request)
    {
        try {
            $file = $request->file('file');

            Log::info("file ");
            Log::info($file);

            $extension = $file->getClientOriginalExtension();
            $fileName = $file->getFilename() . '.' . $extension;
            $path = request()->file('file')->getRealPath();

            Log::info("extension ");
            Log::info($extension);

            Log::info("fileName ");
            Log::info($fileName);

            Log::info("path =");
            Log::info($path);

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];
            $businessName = $businessResult['practice_name'];

            /**************************SAVE CSV FILE**********************/
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
                $fileName = $file->getFilename() . '.' . $extension;
                $path = request()->file('file')->getRealPath();
                Storage::disk('local')->put($fileName, File::get($file));
            }


            if(!empty($fileName))
            {
                UserReviewsFiles::create([
                    'user_id' => $userID,
                    'business_id' => $businessId,
                    'file_name' => $fileName,
                ]);

                return $this->helpReturn("File uploaded Successfully.");
            }

            return $this->helpError(404, 'File not upload. Please try again');
        } catch (Exception $exception) {
            Log::info("file customer section " . $exception->getMessage() . ' > ' . $exception->getLine());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }

    public function smsEmailSendBackgroundJob($request)
    {
        try {

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];
            $businessName = $businessResult['practice_name'];
            $user = $this->sessionService->getAuthUserSession();

            /**************************SAVE CSV FILE**********************/

            $flag = true;

            $thirdPartyMaster = TripadvisorMaster::select('third_party_id', 'business_id', 'type', 'average_rating', 'add_review_url', 'review_count')->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();
            $socialMediaMaster = SocialMediaMaster::select('id as third_party_id', 'type', 'add_review_url', 'id', 'average_rating', 'page_reviews_count as review_count')
                ->where('type', 'Facebook')
                ->where('business_id', $businessId)->whereNotNull('name')->get()->toArray();
            $mergeArray = array_merge($thirdPartyMaster, $socialMediaMaster); //merge both array

            $settings = new CrmSettings();
            $settings->where('user_id', $user['id'])->update(['enable_get_reviews' => $request->enable_get_reviews, 'sending_option' => $request->sending_option,
                'smart_routing' => $request->smart_routing, 'review_site' => $request->review_site,
                'reminder' => $request->reminder, 'customize_email' => $request->customize_email, 'customize_sms' => $request->customize_sms]);
            $settings = CrmSettings::where('user_id', $user['id'])->first();

            /**************************GET FILE DATA IN ARRAY AND PASS TO LOOP FOR ONE BY ONE PROCESSING**********************/
//            $check = Recipient::where('user_id', $user['id'])->where('id','>',$request->first_id)->get()->toArray();

            if ($request->flag == 'yes') {
                $condition = '>';

            } else if ($request->flag == 'no') {
                $condition = '>=';
            }

            Recipient::where('user_id', $user['id'])->where('id', $condition, $request->first_id)->chunk(200, function ($recipients) use ($request, $businessId, $businessName, $user, $mergeArray, $settings) {

                foreach ($recipients as $recipient) {
                    $request->merge(['varification_code' => $recipient->varification_code, 'recipient_id' => $recipient->id, 'first_name' => $recipient->first_name, 'phone_number' => $recipient->phone_number, 'email' => $recipient->email]);
                    if (!empty($mergeArray)) {
                        //get Settings for furthor actions
                        $settings['business_id'] = $businessId;
                        $settings['business_name'] = $businessName;
                        $settings['user_email'] = $user['email'];

                        if (!empty($settings['smart_routing']) && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
                            //   if (!empty($settings['smart_routing']) && ($settings['smart_routing'] == 'enable' || $settings['smart_routing'] == 'Enable') && !empty($settings['enable_get_reviews']) && $settings['enable_get_reviews'] == 'Yes' && !empty($settings['sending_option'])) {
                            if (!empty($settings)) {

                                $request->request->add(['queue' => 'enable']);
                                $this->smsEmailSending($request, $settings);
                            }
                        }
                    } else {
                        Log::info('not submit');
                    }

                }
            });

            return $this->helpReturn("Email Send To Customer Successfully.");
        } catch (Exception $exception) {
            Log::info("file customer section " . $exception->getMessage());
            return $this->helpError('smsEmailSendBackgroundJob', 'Some Problem happened. please try again.');
        }
    }


    public function searchCustomers($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];
            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }
            $businessId = $businessResult['records']['business_id'];
            $businessName = $businessResult['records']['name'];
            $settings = [];
            $items = [];
            $appendArray = [];
            $appendCustomerArray = [];
            if (!empty($request->keyword)) {
                $keyword = $request->keyword;
                $items = Recipient::where('user_id', $user['id'])->get()->filter(function ($record) use ($keyword) {
                    if ($record->first_name == $keyword || $record->last_name == $keyword) {
                        return $record;
                    }
                })->toArray();

                $settings = Recipient::where('user_id', $user['id'])
                    ->Where('phone_number', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->get()->toArray();
                $appendArray = array_unique(array_merge($items, $settings), SORT_REGULAR);
                foreach ($appendArray as $customer) {
                    $name = '';
                    $date = '';
                    $firstName = '';
                    $lastName = '';
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $customer['created_at'])->format('Y-m-d');
                    $firstName = strlen($customer['first_name']) > 100 ? ucfirst(Crypt::decrypt($customer['first_name'])) : $customer['first_name'];
                    $lastName = strlen($customer['last_name']) > 100 ? Crypt::decrypt($customer['last_name']) : $customer['last_name'];
                    !empty($firstName && $lastName) ? $name = $firstName . ' ' . $lastName : (!empty($firstName) ? $name = $firstName : (!empty($lastName) ? $name = $lastName : ''));

                    $appendCustomerArray[] = [
                        'id' => $customer['id'],
                        //'email' => !empty($customer['email']) ? $customer['email'] : '',
                        'phone_number' => strlen($customer['phone_number']) > 100 ? Crypt::decrypt($customer['phone_number']) : $customer['phone_number'],
                        'email' => strlen($customer['email']) > 100 ? Crypt::decrypt($customer['email']) : $customer['email'],
                        //'phone_number' => !empty($customer['phone_number']) ? $customer['phone_number'] : '',
                        'created_at' => !empty($date) ? $date : '',
                        'name' => $name,
                        'first_name' => strlen($customer['first_name']) > 100 ? ucfirst(Crypt::decrypt($customer['first_name'])) : $customer['first_name'],
                        'last_name' => strlen($customer['last_name']) > 100 ? Crypt::decrypt($customer['last_name']) : $customer['last_name']

                    ];
                }

            } else {
                return $this->helpError(1, 'Please enter Keyword.');
            }

            return $this->helpReturn("Get Customer Successfully.", $appendCustomerArray);
        } catch (Exception $exception) {
            Log::info("file customer section " . $exception->getMessage());
            return $this->helpError('addCustomersUsingFile', 'Some Problem happened. please try again.');
        }
    }


    public function getThirdParties($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();
            
            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];

            $result = [];
            $facebook = [];
            $thirdParties = [];

            $thirdParties = TripadvisorMaster::select('type')
                ->where('business_id', $businessId)->where('name', '!=', '')
                ->get()->toArray();



            $facebook = SocialMediaMaster::select('type')->where('type', 'Facebook')->where('business_id', $businessId)->where('name', '!=', '')
                ->get()->toArray();

            $result = array_merge($thirdParties, $facebook);

            return $this->helpReturn("Third Parties.", $result);
        } catch (Exception $exception) {
            Log::info("getThirdParties crm " . $exception->getMessage());
            return $this->helpError('getThirdParties', 'Some Problem happened. please try again.');
        }
    }


}
