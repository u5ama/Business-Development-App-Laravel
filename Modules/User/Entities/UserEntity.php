<?php

namespace Modules\User\Entities;

use DB;
use Log;
use Mail;
use Config;
use App\User;
use Redirect;
use Exception;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use Modules\User\Models\Users;
use App\Entities\AbstractEntity;
use App\Services\SessionService;
use Modules\CRM\Models\Recipient;
use Modules\Business\Models\Niches;
use Modules\CRM\Entities\CRMEntity;
use Modules\CRM\Models\CrmSettings;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\User\Models\UserRolesREF;
use Modules\User\Models\Smsrequestlog;
use App\Mail\CreateWelcomeRegisterEmail;
use Modules\User\Models\Emailrequestlog;
use Modules\Business\Entities\BusinessEntity;
use Modules\User\Services\Validations\Auth\AuthLoginValidator;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class UserEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $sessionService;

    /**
     * AuthEntity constructor.
     */
    public function __construct()
    {
//        $this->authUerInfo = new UserAuthValidator();
        $this->loginValidator = new AuthLoginValidator(resolve('validator'));
        $this->sessionService = new SessionService();
    }


    public function register($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(!empty($user))
            {
                return $this->helpError(4, 'This email is already exist. Change your email or logged in from this email.');
            }

            return DB::transaction(function () use ($user, $request)
            {
                $data = $request->all();
                $data['password'] = Hash::make($request->password);

                $userResult = Users::create($data);

                
//                $userResult = User::create(
//                    [
//                        'first_name', $request->first_name,
//                        'last_name', $request->last_name,
//                        'email', $request->email,
//                        'password', Hash::make($request->password)
//                    ]
//                );

                Log::info("user Result " . json_encode($userResult));

                $userID = $userResult['id'];
                // adding default setting of Emailrequestlog while registeration
                $Emailrequestlog = Emailrequestlog::create([
                    'remaining'=> '100',
                    'maximum' => '100',
                    'users_id' => $userID
                ]);
                Log::info($Emailrequestlog);
                // adding default setting of Smsrequestlog while registeration
                $Smsrequestlog = Smsrequestlog::create([
                    'remaining'=> '10',
                    'maximum' => '10',
                    'users_id' => $userID
                ]);
                Log::info("userID $userID");

                    $UserRolesREF = UserRolesREF::create(
                        [
                            'user_id' => $userID,
                            'role_id' => 2
                        ]
                    );

                    Log::info("REF Result " . json_encode($UserRolesREF));

                    $businessAccess = new BusinessEntity();

                    $requestAppend = [
                        'user_id' => $userID,
                    ];
                    $request->merge($requestAppend);

                    $bResult = $businessAccess->registerBusiness($request);

                    Log::info("B Result " . json_encode($bResult));
                // Log::info("Email " . $request->email);

                try
                {
                    Mail::to($request->email)->send(new CreateWelcomeRegisterEmail($request->first_name, $request->email));
                }
                catch(Exception $e)
                {
                    Log::info("mail failure -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
                }

                    return $this->helpReturn('Registration completed.');
            });
        }
        catch(Exception $e)
        {
            Log::info("register -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }

    public function login($request)
    {
        $data = $request->all();

        if (!$this->loginValidator->with($data)->passes()) {
            return $this->helpError(2, "Fields are required to login.", $this->loginValidator->errors());
        }

        $email = $request->email;
        $password = $request->password;

        $user = Users::with('userRole')->where('email', $email)
                ->first();

        Log::info("user");
        Log::info($user);

        if(empty($user))
        {
            return $this->helpError(3, "Record not found.");
        }

        $isMatced = Hash::check($password, $user->password);

        $userModified = $user->toArray();

//        Log::info("isMatced $isMatced");
//        Log::info("user_role ");
//        Log::info($userModified['user_role']);

        if($isMatced == 1 && $userModified['user_role'][0]['slug'] == 'user')
//        if($isMatced == 1)
        {

            if($user['account_status'] == 'deleted')
            {
                return $this->helpError(403, "Your account has been deleted. Please contact support");
            }

            $userBusiness = $user->business;

            $phone = '';
            if(!empty($userBusiness))
            {
                $user['business'] = $userBusiness;
                $user['discovery_status'] = $userBusiness[0]['discovery_status'];
                $phone = $userBusiness[0]['phone'];
            }

            $this->sessionService->setAuthUserSession($user->toArray());
            $userID = $user['id'];

            $crmsetting = CrmSettings::where('user_id', $userID)->first();

            if( empty($crmsetting) ) {
                $crmSettingResult = CrmSettings::create( [
                    'user_id' => $userID,
                    'enable_get_reviews' => 'Yes',
                    'smart_routing' => 'Enable',
                    'sending_option' => '1'
                ]);

                if(!empty($crmSettingResult['id']))
                {

                }
            }

            return $this->helpReturn('You are successfully logged-in');
        }

        return $this->helpError(36, "Incorrect email or password.");
    }

    public function userProfileUpdate($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

            return DB::transaction(function () use ($user, $request)
            {
                $data = $request->all();

                $user->update($data);

                $userID = $user['id'];
                Business::where('user_id', $userID)
                    ->update(
                        ['phone' => $data['phone']]
                    );

                return $this->helpReturn('Your profile updated.');
            });
        }
        catch(Exception $e)
        {
            Log::info("register -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }

    public function deactivateUserAccount($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

            $data['account_status'] = 'deleted';
            $data['leaving_subject'] = $request->leavingTitle;
            $data['leaving_note'] = $request->leavingNote;

            Log::info("data");
            Log::info($data);

            Users::where('email', $request->get('email'))->update(
                [
                    'account_status' => 'deleted',
                    'leaving_subject' => $request->get('leavingTitle'),
                    'leaving_note' => $request->get('leavingNote')
                ]
            );

            return $this->helpReturn('Your profile updated.', $user);
        }
        catch(Exception $e)
        {
            Log::info("deactivateUserAccount -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }

    public function updateSession($request)
    {
        if(!empty($request->status))
        {
            $userData = $this->sessionService->getAuthUserSession();

            Log::info("us " . $userData['business'][0]['discovery_status']);

            $userData['discovery_status'] = $request->status;

//            Log::info("After Update " . $userData['business'][0]['discovery_status']);

            $this->sessionService->setAuthUserSession($userData);

            if(!empty($userData) && $request->status == 6) {
                $businessData = Business::where('user_id', $userData['id'])->first();

                if(!empty($businessData))
                {
                    $businessData->update(
                        [
                            'discovery_status' => 1
                        ]
                    );
                }
            }
        }

        return $this->helpReturn('Process done.');
    }

    public function getIndustry()
    {
        try
        {
            $data = Industry::with('niches')->get();

            return $this->helpReturn('Industry Niches', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'Some Problem happened.');
        }
    }

    public function getIndustryNiches($request)
    {
        try
        {
            $industry = $request->industry;

            $data = Niches::where('industry_id', $industry)
                ->get();

            return $this->helpReturn('Industry Niches', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'Some Problem happened.');
        }
    }
    
}
