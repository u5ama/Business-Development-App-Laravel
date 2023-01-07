<?php

namespace Modules\Business\Http\Controllers;

use Log;
use Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\Users;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\Business\Models\Business;
use Modules\User\Entities\UserEntity;
use Modules\Business\Entities\TaskEntity;
use Modules\CRM\Entities\GetReviewsEntity;
use Modules\Admin\Entities\AdminTaskEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\Business\Entities\PromotionEntity;
use Modules\Admin\Entities\AdminBusinessEntity;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\AdminPromotionEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\ThirdParty\Entities\ContentDiscoveryEntity;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;

class CommonController extends Controller
{
    protected $data;

    protected $sessionService;

    protected $thirdPartyObj;

    protected $socialEntity;

    protected $contentEntity;

    protected $userEntity;

    protected $businessEntity;

    protected $reviewEntity;

    protected $campaignEntity;

    protected $adminCampaignEntity;

    protected $adminTaskEntity;

    protected $adminPromotionEntity;

    protected $adminBusinessEntity;

    protected $promotionEntity;

    protected $crmEntity;

    protected $taskEntity;

    protected $billingEntity;
    
    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->thirdPartyObj = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();
        $this->contentEntity = new ContentDiscoveryEntity();
        $this->userEntity = new UserEntity();
        $this->businessEntity = new BusinessEntity();
        $this->reviewEntity = new GetReviewsEntity();
        //        $this->campaignEntity = new CampaignEntity();
        //        $this->adminCampaignEntity = new AdminCampaignEntity();
        //        $this->adminTaskEntity = new AdminTaskEntity();
        //        $this->taskEntity = new TaskEntity();
        //        $this->adminPromotionEntity = new AdminPromotionEntity();
        //        $this->adminBusinessEntity = new AdminBusinessEntity();
        //        $this->promotionEntity = new PromotionEntity();
        $this->crmEntity = new CRMEntity();
        $this->billingEntity = new SubscriptionManagerEntity();
    }


    public function requestManager(Request $request)
    {
    }

    public function ajaxRequestManager(Request $request)
    {
        //        Log::info("ajacx ");
        //        Log::info($request->all());
        $businessObj = new BusinessEntity();
        $userObj = new UserEntity();
        $webObj = new WebsiteEntity();
        $tripObj = new TripAdvisorEntity();

        $userData = $this->sessionService->getAuthUserSession();

        if ($request->get('send') == 'status-generate') {
            $result = $userObj->updateSession($request);
        } else if ($request->get('send') == 'add-patient-customer') {
            $result = $this->crmEntity->addPatientCustomer($request);
        } else if ($request->get('send') == 'edit-patient-customer') {
            $result = $this->crmEntity->editPatientCustomer($request);
        } elseif ($request->get('send') == 'business-process') {
            // added default setting for email and sms logs
            $result = $businessObj->collectBusinessData($request);

        } elseif ($request->get('send') == 'web-process') {
            $result = $webObj->trackWebsiteStatus($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                if (!empty($userData)) {
                    $businessData = Business::where('user_id', $userData['id'])->first();

                    if (!empty($businessData)) {
                        $businessData->update(
                            [
                                'discovery_status' => 6
                            ]
                        );
                    }
                }
            }
        } elseif ($request->get('send') == 'reviews-process') {
            $result = $tripObj->SaveHistoricalReviews($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                if (!empty($userData)) {
                    $businessData = Business::where('user_id', $userData['id'])->first();

                    if (!empty($businessData)) {
                        $businessData->update(
                            [
                                'discovery_status' => 1
                            ]
                        );
                    }
                }
            }
        } elseif ($request->get('send') == 'manual-connect-business') {
            if (!empty($request->type)) {
                if ($request->type == 'facebook') {
                    $socialToken = $this->sessionService->getOAuthToken();
                    $data = [];
                    $data['access_token'] = $socialToken['businessAccessToken'];

                    $request->merge($data);
                    $result = $this->socialEntity->manageSocialBusinessPages($request, 'facebook');
                } elseif ($request->type == 'vitals') {
                    $result = [];
                } else {
                    $result = $businessObj->thirdPartyConnect($request);
                    Log::info("res" . json_encode($result));
                }
            } else {
                $result = [];
            }
        } elseif ($request->get('send') == 'unlink-app') {
            if (!empty($request->type)) {
                if ($request->type == 'Twitter') {
                    $result = $this->socialEntity->removeThirdParties($request);
                } else {
                    $result = $this->thirdPartyObj->removeThirdPartyBusiness($request);
                }

                //                Log::info("res" . json_encode($result));
            } else {
                $result = [];
            }
        } elseif ($request->get('send') == 'deactivate-account') {
            $request->merge(['email' => $userData['email']]);
            $result = $this->userEntity->deactivateUserAccount($request);
        } elseif ($request->get('send') == 'save-industry') {
            $result = $this->adminBusinessEntity->saveIndustry($request);
        } elseif ($request->get('send') == 'save-category') {
            $result = $this->adminTaskEntity->saveCategory($request);
        } elseif ($request->get('send') == 'admin-save-template') {
            $result = $this->adminCampaignEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'save-template') {
            $result = $this->campaignEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'save-promotion-template') {
            $result = $this->promotionEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'admin-save-promotion-template') {
            $result = $this->adminPromotionEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'delete-promotion') {
            $result = $this->promotionEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-get-promotion-template') {
            $result = $this->adminPromotionEntity->getThisTemplate($request);
        } elseif ($request->get('send') == 'admin-get-template') {
            $result = $this->adminCampaignEntity->getThisTemplate($request);
        } elseif ($request->get('send') == 'delete-template') {
            $result = $this->campaignEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-delete-template') {
            $result = $this->adminCampaignEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-delete-promotion') {
            $result = $this->adminPromotionEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-promotion-status') {
            $result = $this->adminPromotionEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-template-status') {
            $result = $this->campaignEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-task-status') {
            $result = $this->adminTaskEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-task-delete') {
            $result = $this->adminTaskEntity->deleteTask($request);
        } elseif ($request->get('send') == 'admin-category-delete') {
            $result = $this->adminTaskEntity->deleteCategory($request);
        } elseif($request->get('send') == 'billing-make-payment')
        {
            // billing
            $result = $this->billingEntity->manageSubscription($request);
            return $result;
        } elseif ($request->get('send') == 'get-template') {
            $result = $this->campaignEntity->getThisTemplate($request);
        } elseif ($request->get('send') == 'template-users-link') {
            //            Log::info("next process");
            $result = $this->campaignEntity->linkTemplateUsers($request);
        } elseif ($request->get('send') == 'get-template-users-link') {
            $result = $this->campaignEntity->getLinkTemplateUsers($request);
        } elseif ($request->get('send') == 'send-template-preview') {
            Log::info("next send-template-preview");
            $request->merge(['user_id' => $userData['id']]);
            $result = $this->campaignEntity->sendTemplatePreviewToUsers($request);

            //            Log::info("res" . json_encode($result));
        } elseif ($request->get('send') == 'content-research') {
            $result = $this->contentEntity->getSocialViralContent($request);
        } elseif ($request->get('send') == 'save-feedback') {
            $result = $this->reviewEntity->saveFeedback($request);
        } elseif ($request->get('send') == 'user-profile') {
            $request->merge(['email' => $userData['email']]);
            $result = $this->userEntity->userProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['first_name'] = $request->first_name;
                $userData['last_name'] = $request->last_name;
                $userData['business'][0]['phone'] = $request->phone;
                $this->sessionService->setAuthUserSession($userData);
            }
        } elseif ($request->get('send') == 'update-business-profile') {
            $result = $this->businessEntity->businessProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['business'] = $result['records'];

                $this->sessionService->setAuthUserSession($userData);
            }
        } elseif ($request->get('send') == 'social-profile') {
            $result = $this->businessEntity->socialProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['business'][0]['phone'] = $request->phone;
                $this->sessionService->setAuthUserSession($userData);
            }
        } elseif ($request->get('send') == 'web-report') {
            $data = '';
            try {
                $apiENV = config::get('apikeys.APP_ENV');

                Log::info("apiENV $apiENV");

                if ($apiENV != 'local') {
                    $baseUriHost = 'https';
                } else {
                    $baseUriHost = 'http';
                }

                $baseUriHost = 'http';

                Log::info("url host " . $baseUriHost);

                $client = new Client();
                $websiteUrl = $request->website;

                $response = $client->get($baseUriHost . '://reviewer.nichepractice.com/domains&getImage&site=' . $websiteUrl, [])->getBody()->getContents();

                if (!empty($response)) {
                    $code = 200;
                    $data = $response;
                } else {
                    $code = 404;
                }
            } catch (Exception $e) {
                $code = $e->getCode();
                Log::info("exception web report " . $e->getMessage());
            }

            $statusData = [
                'status_code' => $code,
                'status_message' => "",
                'data' => $data,
                'errors' => ''
            ];

            return json_encode($statusData);
        } elseif ($request->get('send') == 'retrieve-tabs-task') {
            $result = $this->taskEntity->list($request, $userData['id']);
        } elseif ($request->get('send') == 'task-detail') {
            $result = $this->taskEntity->taskDetail($request);
        } elseif ($request->get('send') == 'update-task-status') {
            $result = $this->taskEntity->updateTaskStatus($request);
        }

        if (!empty($result)) {
            $statusData = [
                'status_code' => $result['_metadata']['outcomeCode'],
                'status_message' => $result['_metadata']['message'],
                'data' => $result['records'],
                'errors' => $result['errors']
            ];
        } else {
            $statusData = [
                'status_code' => 1,
                'status_message' => 'Problem in connecting your app',
                'data' => [],
                'errors' => []
            ];
        }

        return json_encode($statusData);
    }
}
