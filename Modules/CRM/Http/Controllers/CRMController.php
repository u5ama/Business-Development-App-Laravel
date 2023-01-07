<?php

namespace Modules\CRM\Http\Controllers;

use Log;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\CRM\Models\CrmSettings;
use Modules\Business\Models\Countries;
use Modules\CRM\Entities\GetReviewsEntity;

class CRMController extends Controller
{

    protected $crmEntity;

    protected $sessionService;

    protected $data;

    public function __construct()
    {
        $this->crmEntity = new CRMEntity();

        $this->sessionService = new SessionService();
    }

    public function updateCustomer($id, Request $request)
    {
        return $this->crmEntity->updateCustomer($id, $request);
    }

    public function addCustomerSettings(Request $request)
    {
        return $this->crmEntity->addCustomerSettings($request);
    }

    public function customerSettingsList(Request $request)
    {
        return $this->crmEntity->customerSettingsList($request);
    }

    public function customersList(Request $request)
    {
        $this->data['moduleView'] = 'get_more_reviews';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $data = [
            'screen' => 'web',
            'start' => 0,
            'length' => 1
        ];
        $responseData = $this->crmEntity->customersList($data);

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        
        return view('layouts.customers', $this->data);
    }

    public function addPatient(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['moduleView'] = 'get_more_reviews';

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        $this->data['records'] = $responseData['records']['customers']['data'];

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        return view('layouts.crm-customers.add-customers', $this->data);
    }

    public function customersListTest(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        $this->data['records'] = $responseData['records']['customers']['data'];

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        return view('layouts.crm-customers.customers-list-selection', $this->data);
    }

    public function showRecipientList(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'review_request';

        //        $userData = $this->sessionService->getAuthUserSession();
        //        $this->data['businessList'] = $this->businessControl->businessList();
        $this->data['enable_get_reviews'] = '';
        $this->data['third_parties_list'] = [];
        $this->data['reviewRequestSettings'] = [];
        $this->data['countryCodes'] = [];

        try {
            $reviewsEntity = new GetReviewsEntity();

            $recipientList = $reviewsEntity->getRecipientsList($request);


            if ($recipientList['_metadata']['outcomeCode'] == 200) {
                try {
                    $thirdPartyResponse = $reviewsEntity->checkThirdParties($request);

                    if ($thirdPartyResponse['records']['flag'] == 0) {
                        $this->data['flag'] = 0;
                        $this->data['message'] = 'We detected that you have not added your business on Yelp, Tripadvisor, Facebook, or Google My Business. In order to use Get Reviews, you need to register your business in at least one of these sites.';
                    }
                } catch (Exception $e) {
                }

                /*  CRM API */
                /* ---------------------------------------------------*/

                $data = ['screen' => 'web'];
                $responseCRMData = $this->crmEntity->customersList($data);

                if ($responseCRMData['_metadata']['outcomeCode'] == 200) {
                    $this->data['enable_get_reviews'] = $responseCRMData['records']['enable_get_reviews'];
                }
                /* ---------------------------------------------------*/

                $this->data['countryCodes'] = Countries::all()->toArray();

                /* ---------------------------------------------------*/
                $thirdPartiesList = $this->crmEntity->getThirdParties($request);

                $this->data['third_parties_list'] = $thirdPartiesList['records'];

                /* ---------------------------------------------------*/

                $customerSettingsList = $this->crmEntity->customerSettingsList($request);

                $this->data['reviewRequestSettings'] = $customerSettingsList['records'];
                /* ---------------------------------------------------*/
                /*  CRM API */

                $this->data['records'] = $recipientList['records'];
                return view('layouts.crm-customers.recipient', $this->data);
            } else {
                $this->data['flag'] = 0;
                $this->data['message'] = 'Recipients not found';
                return view('layouts.crm-customers.recipient', $this->data);
            }
        } catch (Exception $e) {
            $this->data['flag'] = 0;
            $this->data['message'] = 'Problem in retrieving reviews list. Please try again later';
            return view('layouts.crm-customers.recipient', $this->data);
        }
    }

    public function getCustomersById(Request $request)
    {
        return $this->crmEntity->getCustomersById($request);
    }

    public function smsEmailSendCronJob(Request $request)
    {
        return $this->crmEntity->smsEmailSendCronJob($request);
    }

    public function updateCRMStats(Request $request)
    {
        return $this->crmEntity->updateCRMStats($request);
    }

    public function searchCustomers(Request $request)
    {
        return $this->crmEntity->searchCustomers($request);
    }

    public function getThirdParties(Request $request)
    {
        return $this->crmEntity->getThirdParties($request);
    }

    public function sendExistingCustomerReviewRequest(Request $request)
    {
        return $this->crmEntity->sendExistingCustomerReviewRequest($request);
    }

    public function getCRMCustomersList(Request $request)
    {
        try {
            $data = ['screen' => 'web'];
            $responseData = $this->crmEntity->customersList($data);

            $data = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            ];

            if (!empty($responseData['records']['customers'])) {
                $data = $responseData['records']['customers'];
            }

            return $data;
        } catch (Exception $e) {
            Log::info("getCRMCustomersList > " . $e->getMessage());

            $data = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            ];

            return $data;
        }
    }

    public function addCustomer(Request $request)
    {
        $data['first_name'] = $request->get('first_name');
        $data['last_name'] = $request->get('last_name');
        $data['email'] = $request->get('email');
        $data['phone_number'] = $request->get('phone_number');
        $data['country'] = $request->get('country');
        $data['country_code'] = $request->get('country_code');

        if ($request->get('enable_get_reviews')) {
            $data['enable_get_reviews'] = $request->get('enable_get_reviews');
        }

        if ($request->get('smart_routing')) {
            $data['smart_routing'] = $request->get('smart_routing');
        }

        if ($request->get('sending_option')) {
            
            $data['sending_option'] = $request->get('sending_option');
        }

        if ($request->get('review_site')) {
            $data['review_site'] = $request->get('review_site');
        }

        if ($request->get('reminder')) {
            $data['reminder'] = $request->get('reminder');
        }
        if ($request->get('customize_email')) {

            $data['customize_email'] = $request->get('customize_email');
        }
        if ($request->get('customize_sms')) {
            $data['customize_sms'] = $request->get('customize_sms');
        }
        if ($request->get('customer_id')) {
            $data['customer_id'] = $request->get('customer_id');
        }
        if ($request->get('varification_code')) {
            $data['varification_code'] = $request->get('varification_code');
        }

        $responseData = $this->crmEntity->addCustomers($request);

        return $responseData;
    }

    public function deleteCustomer(Request $request)
    {
        return $this->crmEntity->deleteCustomer($request);
    }

    public function uploadCustomersCSV(Request $request)
    {
        Log::info("file ");
        Log::info($request->file);
        return $this->crmEntity->addCustomersUsingFile($request);
    }

    public function uploadCustomersFile(Request $request)
    {
        Log::info("file ");
        Log::info($request->file);
        return $this->crmEntity->uploadCustomersFile($request);
    }

    public function CRMBackgroundService(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return $this->crmEntity->smsEmailSendBackgroundJob($request);
    }

    public function sendEmailCampaign(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return $this->crmEntity->sendMarketingEmails($request);
    }

    /**
    * url email
    */
    public function settings()
    {
        $user_id = session('user_data')['id'];
        $this->data['CrmSettings'] = CrmSettings::where('user_id', $user_id)->first();
        $this->data['user_data'] = session('user_data');
        // dd($this->data['user_data']);
        $this->data['showAdditionalBar'] = true;
        return view('layouts.settings', $this->data);

    }
    /**
     *
     */
    public function emailPersonalizeDesign(Request $request)
    {
        # code...
        $data = [            
            'review_number_color' => $request->review_number_color,
            'star_rating_color' => $request->star_rating_color,
            'top_background_color' => $request->top_background_color
        ];
        if ($request->file('background_image_src')) {
            # code...
            $background_image_src = $request->file('background_image_src')->store('background_image_src','public');
            $data['background_image_src'] = $background_image_src;
        }
        if ($request->file('logo_image_src')) {
            # code...
            $logo_image_src = $request->file('logo_image_src')->store('logo_image_src','public');
            $data['logo_image_src'] = $logo_image_src;
        }
        
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update($data);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }

    /**
     * 
     * 
     */
    public function emailSentUser(Request $request)
    {
        # code...
        
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update([
              'email_heading' => $request->email_heading,
              'email_message' => $request->email_message,
              'email_subject' => $request->email_subject,
              'email_positive_anwser' => $request->email_positive_anwser,
              'email_negative_anwser' => $request->email_negative_anwser,
              ]);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }
    /**
     * 
     * 
     */
    public function personalizeTouch(Request $request)
    {
        # code...
        $data = [            
            'company_role' => $request->company_role,
              'full_name' => $request->full_name
        ];
        if ($request->file('personal_avatar_src')) {
            # code...
            $personal_avatar_src = $request->file('personal_avatar_src')->store('personal_avatar_src','public');
            $data['personal_avatar_src'] = $personal_avatar_src;
        }
        
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update($data);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }

    public function emailNegativeAnswerSetup(Request $request)
    {

        $data = [            
            'email_negative_answer_setup_heading' => $request->email_negative_answer_setup_heading,
            'email_negative_answer_setup_message' => $request->email_negative_answer_setup_message
        ];
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update($data);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }
    /**
     * 
     */
    public function smsView()
    {
        $this->data['showAdditionalBar'] = true;
        $user_id = session('user_data')['id'];
        $this->data['CrmSettings'] = CrmSettings::where('user_id', $user_id)->first();
        return view('layouts.sms', $this->data);
    }
    /**
     * 
     */
    public function smsImage(Request $request)
    {
        # code...
        $data = [];
        if ($request->file('sms_image')) {
            # code...
            $sms_image = $request->file('sms_image')->store('sms_image','public');
            $data['sms_image'] = $sms_image;
        }
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update($data);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }
    /**
     * 
     */
    public function smsMessage(Request $request)
    {
        # code...
        $user_id = session('user_data')['id'];
        $CrmSettings = CrmSettings::where('user_id', $user_id)
          ->update([
              'sms_message' => $request->sms_message
              ]);
        $CrmSettings = CrmSettings::where('user_id', $user_id)->get();
        return response()->json($CrmSettings, 200);
    }
    
}
