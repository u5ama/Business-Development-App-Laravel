<?php

namespace Modules\User\Entities\Billing;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use App\User;
use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;
use Log;
use Mail;
use Config;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\Business\Models\SocialProfile;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\User\Models\CreditsHistory;
use Modules\User\Models\CreditsPlan;
use Modules\User\Models\Plan as Plans;
use Modules\User\Models\UserCreditsPurchaseHistory;
use Modules\User\Models\UserRolesREF;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\User\Models\Users;
use Redirect;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Plan;
use Stripe\Stripe;

/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class SubscriptionManagerEntity extends AbstractEntity
{
    use UserAccess;
    protected $loginValidator;
    protected $googlePlaces;
    protected $facebook;
    protected $yelp;
    protected $sessionService;
    protected $socialEntity;
    protected $thirdPartyEntity;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->socialEntity = new SocialEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
    }

    public function manageSubscription($request)
    {
//        return $this->helpError(
//            4,
//            'Some Problem Happened.'
//        );
//        $plan = Plan::findOrFail($request->get('plan'));

        try
        {
            $userData = $this->sessionService->getAuthUserSession();

            $user = Users::find($userData['id']);

//            print_r($user);
//            exit;

            $plan = $request->get('SubscriptionID');


            $planResult = Plans::where('slug', $plan)->first();
Log::info('$planResult = >');
            Log::info($planResult);
            $planID = '';
            if(!empty($planResult))
            {
                $planID = $planResult['stripe_plan'];
            }
            // dd($request->all());
            $response = $user->newSubscription($plan, $planID)
                ->create($request->token_id);
        }
        catch (Exception $e)
        {
            Log::info('$e = >');
            Log::info($e);
            Log::info("manage subscription " . $e->getCode() . ' mesage > ' . $e->getMessage());
            $response = $e->getMessage();

            return $this->helpError(
                4,
                'Some Problem Happened.'
            );
        }

        Log::info("response");
        Log::info($response);
//        exit;

        return $this->helpReturn("Successfully subscribed the package.");
    }

    public function purchaseCredits($request)
    {
        try {
            $stripe = new Stripe();

            $secret = config::get('apikeys.STRIPE_SECRET');
            $stripe::setApiKey($secret);

            $planId = $request->get('id');

            $userData = $this->sessionService->getAuthUserSession();

            $user = Users::find($userData['id']);

            $customer = $user['stripe_id'];

            if(empty($customer))
            {
                // create customer
                $customerRes = $this->createCustomer($request);

                if($customerRes['_metadata']['outcomeCode'] != 200)
                {
                    return $customerRes;
                }

                $customer = $customerRes['records']['id'];
            }

            Log::info("customer");
            Log::info($customer);

            $token = $user['id'] .'_' . randomString(12);

            $session = Session::create([
                'customer' => $customer,
                'mode' => 'payment',
                'line_items' => [
                    [
//                    'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
                        'price' => $planId,
                        'quantity' => 1,
                    ]
                ],
//            'payment_intent' => 'pi_1GcUkeKahC1NqiCdKIfTlc39',
//            'payment_method' => 'pm_1F0c9v2eZvKYlo2CJDeTrB4n',
                'payment_method_types' => ['card'],
//            "payment_intent" => "pi_1GcUkeKahC1NqiCdKIfTlc39",
//            'payment_intent_data' => [
//                [
//                    'payment_method' => 'pm_1F0c9v2eZvKYlo2CJDeTrB4n',
//                    'capture_method' => 'automatic'
//                ]
//            ],
                'success_url' => url('/') . '/credits?session_id={CHECKOUT_SESSION_ID}&purchase=success&token='.$token,
                'cancel_url' => url('/') . '/credits?purchase=cancel',
//            'cancel_url' => 'https://example.com/cancel',
            ]);

            if(!empty($session['id']))
            {
                $creditPlanData = CreditsPlan::where('price_id', $planId)->get()->toArray();

                $creditPlanData = $creditPlanData[0];
                $credits = $creditPlanData['credits_of_this'];
                $price = $creditPlanData['price'];

                $data = [
                    'user_id' => $userData['id'],
                    'customer_id' => $customer,
                    'session_id' => $session['id'],
                    'token' => $token,
                    'credits_plan_id' => $planId,
                    'credits' => $credits,
                    'price' => $price,
                    'transaction_system_status' => 'incomplete',
                ];

                $this->addCredits($data);
                return $this->helpReturn("Details", $session);
            }

            return $this->helpError(3, 'Unable to connect with payment gateway. Please try again');
        }catch (Exception $e)
        {
            Log::info("purchaseCredits " . $e->getCode() . ' message > ');
            Log::info($e->getMessage());
//            $response = $e->getMessage();

            return $this->helpError(1, 'Some problem happened. Please try again later.');
        }
    }

    public function addCredits($data)
    {
        UserCreditsPurchaseHistory::create($data);
    }

    public function updateCreditsStatus($request, $update = [])
    {

        if(empty($request->get('token') || empty($request->get('session_id'))))
        {
            return $this->helpError(3, 'No access for this action.');
        }

        $condition = [
            'token' => $request->get('token'), 'session_id' => $request->get('session_id')
        ];

//        print_r($condition);
//        exit;
        if(empty($update))
        {
            $update['transaction_system_status'] = 'paid';
        }

        $res = UserCreditsPurchaseHistory::where($condition)->update($update);
//        $res = UserCreditsPurchaseHistory::where($condition)->get();

//        print_r($res);
//        exit;
        $this->updateCreditsSession();

        return $this->helpReturn("Status updated.");
    }

    public function createCustomer($request)
    {
        try {
            $stripe = new Stripe();

            $userData = $this->sessionService->getAuthUserSession();

            $email = $userData['email'];
//            $email = 'cde@gmail.com';

            $secret = config::get('apikeys.STRIPE_SECRET');
            $stripe::setApiKey($secret);

            $customerObj = Customer::create(
                [
                    'email' => $email
                ]
            );

            if(!empty($customerObj['id']))
            {
                Users::where('id', $userData['id'])->update(
                    [
                        'stripe_id' => $customerObj['id']
                    ]
                );
                return $this->helpReturn("New Customer created.", $customerObj);
            }

            return $this->helpError(3, 'Some problem happened. Please try again later.');
        }
        catch (Exception $e)
        {
            Log::info("createCustomer " . $e->getCode() . ' message > ');
            Log::info($e->getMessage());
//            $response = $e->getMessage();

            return $this->helpError(1, 'Some problem happened. Please try again later.');
        }
    }

    public function getSubscribedPackage($userId)
    {
        $result = Users::with(
            [
                'subscriptions' => function ($q) {
                    $q->orderBy('id', 'desc')->first();
                }
            ]
        )->where('id', $userId)->get();

        if(!empty($result[0]['subscriptions'][0]))
        {
            return $result[0]['subscriptions'][0]->toArray();
        }
        else
        {
            return '';
        }
    }

    public function userCreditsBalance()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $userId = $userData['id'];

        $credits = UserCreditsPurchaseHistory::where(['user_id' => $userId, 'transaction_system_status' => 'paid'])->sum('credits');

        $creditsUsed = CreditsHistory::where('user_id', $userId)->sum('credits');

        return $credits - $creditsUsed;
    }

    /**
     * @param int $credits
     * @param $module
     * @param $moduleId
     * @param string $status
     * @return mixed
     */
    public function manageCreditHistory($credits, $module, $moduleId, $status = 'pending')
    {
        $userData = $this->sessionService->getAuthUserSession();
        $userId = $userData['id'];

        $res = CreditsHistory::create([
            'user_id' => $userId,
            'credits' => $credits,
            'module_used_credits' => $module,
            'module_id' => $moduleId,
            'status' => $status,
        ]);

        if(!empty($res['id']))
        {
            return $this->helpReturn("credit added.", $res);
        }

        return $this->helpError(
            1,
            'Some Problem Happened.'
        );
    }

    public function updateCreditsSession()
    {
        $userData = $this->sessionService->getAuthUserSession();

        $credits = $this->userCreditsBalance();

        $userData['credits'] = $credits;
        $this->sessionService->setAuthUserSession($userData);
    }
}
