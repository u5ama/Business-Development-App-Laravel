<?php

namespace Modules\Business\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\Users;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Illuminate\Support\Facades\Auth;
use Modules\Business\Models\Domains;
use Modules\Business\Models\Website;
use Modules\Business\Models\Countries;
use Modules\User\Models\Smsrequestlog;
use Modules\User\Models\Emailrequestlog;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\DashboardWidgetEntity;

class HomeController extends Controller
{
    protected $data;
    protected $crmEntity;

    protected $sessionService;

    protected $thirdPartyEntity;

    protected $dashboardWidgetEntity;

    public function __construct()
    {
        $this->crmEntity = new CRMEntity();
        $this->sessionService = new SessionService();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->dashboardWidgetEntity = new DashboardWidgetEntity();
    }


    public function home(Request $request)
    {
        $ob = new BusinessEntity();

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['businessData'] = '';
        $this->data['scanResult'] = '';
        if ($userData['discovery_status'] == 1 || $userData['discovery_status'] == 6) {
            $businessData = $ob->businessDirectoryList($request);
            // dd($businessData);
            $businessResult = $businessData['records']['userBusiness'];
            $this->data['scanResult'] = $businessData['records']['businessIssues'];
            $this->data['businessResult'] = $businessResult;

            if (!empty($businessResult['website'])) {
                $webObj = new WebsiteEntity();

                $webResult = $webObj->trackWebsiteStatus($request, true);

                if ($webResult['_metadata']['outcomeCode'] == 200) {
                    $this->data['webResult'] = $webResult['records'];
                }
            }

            $socialResult = SocialMediaMaster::where('business_id', $businessResult['business_id'])->orderBy('type')->get()->toArray();


            if (!empty($socialResult)) {
                $this->data['socialResult'] = $socialResult[0];
            }

            $this->data['twitterResult'] = (!empty($socialResult[1]) && strtolower($socialResult[1]['type']) == 'twitter') ? $socialResult[1] : '';
        }
        $this->data['lastReviews'] = $this->dashboardWidgetEntity->lastReviews($userData);
        $this->data['overAllRating'] = $this->dashboardWidgetEntity->overAllRating($userData);
        $this->data['publicReviews'] = $this->dashboardWidgetEntity->publicReviews($userData);

        $this->data['sentiments'] = $this->dashboardWidgetEntity->sentiments($userData);
        $user_id = $userData['id'];

        $this->data['emailrequestlogs'] = Emailrequestlog::where('users_id', $user_id)->first();
        $this->data['smsrequestlogs'] = Smsrequestlog::where('users_id', $user_id)->first();

        // dd($this->data['emailrequestlogs']);
        return view('layouts.home', $this->data);
    }

    public function getCrmModuleData($request = '')
    {
        // moduleView
        $this->data['moduleView'] = 'get_more_reviews';

        // userData
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        // enable_get_reviews
        $data = [
            'screen' => 'web',
            'start' => 0,
            'length' => 1
        ];
        $responseData = $this->crmEntity->customersList($data);
        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        // countryCodes
        $this->data['countryCodes'] = Countries::all()->toArray();

        // third_parties_list
        $thirdPartiesList = $this->crmEntity->getThirdParties($request);
        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        // reviewRequestSettings
        $customerSettingsList = $this->crmEntity->customerSettingsList($request);
        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];


        return $this->data;
    }
}
