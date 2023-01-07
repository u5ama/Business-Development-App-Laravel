<?php

namespace Modules\Business\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Entities\PromotionEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Models\Countries;
use Modules\Business\Models\PromotionTemplate;
use Modules\Business\Models\SocialProfile;
use Modules\CRM\Entities\CRMEntity;
use Modules\CRM\Entities\GetReviewsEntity;
use Modules\CRM\Models\Recipient;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Exception;
use Log;

class PageController extends Controller
{

    protected $businessEntity;

    protected $crmEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;

    protected $sessionService;

    protected $reviewEntity;

    protected $campaignEntity;

    protected $promotionEntity;

    protected $data;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
        $this->reviewEntity = new GetReviewsEntity();
//        $this->campaignEntity = new CampaignEntity();
        $this->crmEntity = new CRMEntity();
//        $this->promotionEntity = new PromotionEntity();
    }

    public function company()
    {
        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

        //        print_r($userData);
        //        exit;
        //  changing because its dependent on session
        // $this->data['userBusiness'] = $userData['business'][0];
        $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];

        $this->data['countries'] = Countries::all()->toArray();

//        print_r($this->data['countries']);
//        exit;

        $this->data['showAdditionalBar'] = true;

        return view('layouts.company', $this->data);
    }

    public function billingScreen()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.billing', $this->data);
    }

    public function businessProfile()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];

//        print_r($this->data['userBusiness']);
//        exit;
        $this->data['countries'] = Countries::all()->toArray();

        $social = SocialProfile::where('business_id', $this->data['userBusiness']['business_id'])->get()->toArray();

        $this->data['social'] = getIndexedvalue($social, 0);


        return view('layouts.business-profile', $this->data);
    }

    public function seoVIew()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.seo', $this->data);
    }

    public function customSocialPosts()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.custom-social-post', $this->data);
    }

    public function payPerClick()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.pay-per-click', $this->data);
    }

    public function landingPage()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.landing-page', $this->data);
    }

    public function analyticsView()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.analytics', $this->data);
    }

    public function websiteContent()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.website-content', $this->data);
    }

    public function socialMediaProfile()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.social-media-profiles', $this->data);
    }

    public function blogArticle()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.blog-article', $this->data);
    }

    public function pressRelease()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.press-release', $this->data);
    }

    public function autoCampaignList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.automated-email-list', $this->data);
    }

    public function campaignList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.campaign-list', $this->data);
    }

    public function emailTemplates()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $result = $this->campaignEntity->getTemplate();

        $this->data['templates'] = $result['records'];

        return view('layouts.campaign.email-templates', $this->data);
    }

    public function emailCampaign(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userId = $userData['id'];
        $this->data['templateId'] = $templateId;

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        if ($templateId != '') {
            $customers = Recipient::leftJoin('campaign_users_track As cut', function ($join) use ($userId, $templateId) {
                $join->on('recipients.id', '=', 'cut.recipient_id');
//                $join->on('cut.recipient_id', '=', 37);
                $join->on('cut.user_id', '=', \DB::raw("$userId"));
                $join->on('cut.template_id', '=', \DB::raw("$templateId"));
            })
                ->select('recipients.id', 'email', 'phone_number', 'first_name', 'last_name', 'cut.recipient_id', 'cut.user_id', 'cut.template_id')
                ->where('recipients.user_id', $userId)
                ->wherenull('deleted_at')
                ->get();
        } else {
            $customers = Recipient::select('id', 'email', 'phone_number', 'first_name', 'last_name')
                ->where('recipients.user_id', $userId)
                ->wherenull('deleted_at')
                ->get();
        }


        $this->data['records'] = $customers->toArray();

        $this->data['third_parties_list'] = [];

        $this->data['enable_get_reviews'] = 'disabled';
        // only_save, sent request
        $this->data['actionStatus'] = 'only_save';

        return view('layouts.campaign.email-campaign', $this->data);
    }

    public function emailCampaignPreview(Request $request, $templateId)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userId = $userData['id'];
        $this->data['templateId'] = $templateId;

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        if ($templateId != '') {
            $customers = Recipient::leftJoin('campaign_users_track As cut', function ($join) use ($userId, $templateId) {
                $join->on('recipients.id', '=', 'cut.recipient_id');
//                $join->on('cut.recipient_id', '=', 37);
                $join->on('cut.user_id', '=', \DB::raw("$userId"));
                $join->on('cut.template_id', '=', \DB::raw("$templateId"));
            })
                ->select('recipients.id', 'email', 'phone_number', 'first_name', 'last_name', 'cut.recipient_id', 'cut.user_id', 'cut.template_id')
                ->where('recipients.user_id', $userId)
                ->wherenull('deleted_at')
                ->get();
        } else {
            $customers = Recipient::select('id', 'email', 'phone_number', 'first_name', 'last_name')
                ->where('recipients.user_id', $userId)
                ->wherenull('deleted_at')
                ->get();
        }

        $this->data['records'] = $customers->toArray();

        return view('layouts.campaign.email-campaign-preview', $this->data);
    }

    public function imageBuilder(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['promotionData'] = [];
        $this->data['templateId'] = $templateId;

        if(!empty($templateId))
        {
            $this->data['promotionData'] = PromotionTemplate::where('id', $templateId)->first()->toArray();
        }

//        print_r($this->data['promotionData']);
//        exit;
        return view('layouts.image-builder', $this->data);
    }

    public function promotionTemplates()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $result = $this->promotionEntity->getTemplate();

        $this->data['templates'] = $result['records'];

        return view('layouts.promotion.promotion-templates', $this->data);
    }

    public function showBusinessReview(Request $request, $email, $secret, $business, $reviewID)
    {
        $this->data['message'] = '';
        $businessName='';

        try
        {
            $data = [
                'email' => $email,
                'secret' => $secret,
                'id' => $business,
                'review_id' => $reviewID
            ];

            $request->merge($data);
            $businessResponseData = $this->reviewEntity->saveFeedback($request);

            if($businessResponseData['_metadata']['outcomeCode'] == 3)
            {
//              $this->data['message'] = 'We detected that you are not authorized to view this page. please again click the link from your email to view the content of this page.';

                $businessName = $businessResponseData['errors']['business_name'];
                $this->data['message'] = "The business you are trying to review has removed their review sites from ".getDynamicAppName().". Due to this removal, ".getDynamicAppName()." is unable to redirect you to the review site of ".$businessName.". Please contact ".getDynamicAppSupportEmail()." for further assistance.";
            }
            else{
                $businessName = $businessResponseData['records']['business_name'];
            }

        } catch (Exception $e)
        {
            $this->data['message'] = 'Currently unable to show this page. please try again later.';
        }

        if(empty($businessName) && !is_numeric($business)){
            $businessName = $business;
        }
        //$this->data['name'] = $business;
        $this->data['name'] = $businessName;
        $this->data['email'] = $email;
        $this->data['secret'] = $secret;
        $this->data['reviewID'] = $reviewID;
        
        return view('layouts.recipient-feedback', $this->data);
    }

    public function promotionList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->promotionEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.promotion.promotion-list', $this->data);
    }

    public function businessReviewComplete(Request $request, $email, $secret, $business)
    {
        $this->data['message'] = 'Thank you '.$email.' for your feedback.';
        $this->data['pageType'] = 'thank-you';

        try
        {
            $data = [
                'email' => $email,
                'secret' => $secret,
            ];

            $request->merge($data);
            $businessResponseData = $this->reviewEntity->saveFeedback($request);

            if($businessResponseData['_metadata']['outcomeCode'] == 3)
            {
//              $this->data['message'] = 'We detected that you are not authorized to view this page. please again click the link from your email to view the content of this page.';

                $businessName = $businessResponseData['errors']['business_name'];
                $this->data['message'] = "The business you are trying to review has removed their review sites from ".getDynamicAppName().". Due to this removal, ".getDynamicAppName()." is unable to redirect you to the review site of ".$businessName.". Please contact ".getDynamicAppSupportEmail()." for further assistance.";
            }

        } catch (Exception $e)
        {
            $this->data['message'] = 'Currently unable to show this page. please try again later.';
        }

        $this->data['name'] = $business;
        $this->data['email'] = $email;
        $this->data['secret'] = $secret;
        $this->data['reviewID'] = '';
        return view('layouts.recipient-feedback', $this->data);
    }

    public function websiteAudit(Request $request)
    {
        # code...
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        // $this->data['moduleView'] = 'web_audit';

        // $businessResult = $this->businessEntity->userSelectedBusiness();


        // $businessResult = $businessResult['records'];

        // $this->data['businessResult'] = $businessResult;

        // if(!empty($businessResult['website']))
        // {
        //     $webObj = new WebsiteEntity();

        //     $webResult = $webObj->trackWebsiteStatus($request, true);

        //     if($webResult['_metadata']['outcomeCode'] == 200)
        //     {
        //         $webResult = $webResult['records'];
        //         $this->data['webResult'] = $webResult;
        //         $this->data['metaData'] = decSerBase($webResult['meta_data']);
        //         $this->data['keywordsCloud'] = decSerBase($webResult['keywords_cloud']);
        //         $this->data['pageSize'] = base64_decode($webResult['404_page']);
        //         $this->data['loadTime'] = decSerBase($webResult['load_time']);
        //     }
        // }
        return view('layouts.websiteAudit', $this->data);
    }
}
