<?php

namespace Modules\User\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\User\Entities\UserEntity;
use Log;
use Redirect;

class UserController extends Controller
{
    protected $userEntity;

    protected $data = [];

    protected $sessionService;

    protected $businessEntity;

    /**
     * AuthEntity constructor.
     */
    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->userEntity = new UserEntity();
        $this->sessionService = new SessionService();
    }

    public function userProfileLayout()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.user-profile', $this->data);
    }

    public function userPracticeProfile(Request $request)
    {
        $authResponse = '';
        if ($request->has('accessToken') && $request->get('type') == 'facebook') {
            // set analytics token in session to make request.
            $this->sessionService->setOAuthToken(
                [
                    'businessAccessToken' => $request->get('accessToken'),
                    'accessTokenType' => $request->get('type'),
                ]
            );
            // redirecting to url because we don't want to show query string parameter in url
            return redirect()->to($request->url());
        }
        else if ($request->has('accessToken') && $request->get('type') != '') {
            $authResponse = $request->get('accessToken');
            $this->data['authType'] = $request->get('type');
            $this->data['authCode'] = ( !empty($request->get('code')) ) ? $request->get('code') : '';
            $this->data['authMessage'] = ( !empty($request->get('message')) ) ? $request->get('message') : '';
        }

        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['authResponse'] = $authResponse;
        $this->data['socialToken'] = '';
        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
        {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['userBusiness'] = $userData['business'][0];
        $businessId = $userData['business'][0]['business_id'];

        $businessData = $this->businessEntity->businessDirectoryList($request);

        $thirdPartyData = $businessData['records']['businessIssues'];


        $appRecord = [];

        $sources = moduleSocialList();

        $socialMedia = SocialMediaMaster::where('business_id', $businessId)
            ->where('access_token', '!=', '')
            ->get()->toArray();

        if (!empty($socialMedia)) {
            $sourceExist = array_column($socialMedia, 'type');
        }

        foreach($sources as $index => $source)
        {
            $matchedStatus = 0;

            if(!empty($sourceExist))
            {
                $source = ucwords(strtolower($source));

                $matched = array_search($source, $sourceExist);
//                print_r($sourceExist);
//                exit;

//                $sources[$index] =
                if($matched !== false)
                {
                    $appBusiness = $socialMedia[$matched];

                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
                    {
                        $matchedStatus = 1;
                        $appRecord[$source] = ['type' => $source, 'status' => 'connected'];
                    }
                }
            }

            if($matchedStatus == 0)
            {
                $appRecord[$source] = ['type' => $source, 'status' => 'not_connected'];
            }
        }

        $appRecord['Google'] = [
            'status' => 'not_connected',
            'type' => 'Google Places',
        ];

        foreach ($thirdPartyData as $thirdPartyApp)
        {
            if(strtolower(str_replace(" ", "", $thirdPartyApp['type'])) == 'googleplaces')
            {
                if(!empty($thirdPartyApp['name']))
                {
                    $appRecord['Google'] = [
                        'status' => 'connected',
                        'type' => $thirdPartyApp['type'],
                    ];
                }
                break;
            }
        }

        $this->data['appRecord'] = $appRecord;
//        print_r($appRecord);
//        exit;
        return view('layouts.practice-profile', $this->data);
    }

//    public function userPracticeProfile(Request $request)
//    {
//
//        if ($request->has('accessToken') && $request->get('type') == 'facebook') {
//            // set analytics token in session to make request.
//            $this->sessionService->setOAuthToken(
//                [
//                    'businessAccessToken' => $request->get('accessToken'),
//                    'accessTokenType' => $request->get('type'),
//                ]
//            );
//            // redirecting to url because we don't want to show query string parameter in url
//            return redirect()->to($request->url());
//        }
//        $socialToken = $this->sessionService->getOAuthToken();
//
//        $this->data['socialToken'] = '';
//        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
//        {
//            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
//        }
//
//        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';
//
//        $userData = $this->sessionService->getAuthUserSession();
//        $this->data['userData'] = $userData;
//
//        $businessData = $this->businessEntity->businessDirectoryList($request);
//
////        print_r($businessData);
////        exit;
//
//        $sources = thirdPartySources();
//
//        $sources = [
//            'Yelp',
//            'Google Places',
//            'Facebook'
//        ];
//
//        if(!empty($businessData['records']['businessIssues']))
//        {
//            $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
//        }
////print_r($sourceExist);
////        exit;
//        foreach($sources as $index => $source)
//        {
//            $matchedStatus = 0;
//
//            if(!empty($sourceExist))
//            {
////                $source = strtolower($source);
//
//                $source = ucwords(strtolower($source));
//
////                if(strtolower($source) == 'healthgrades')
////                {
////                    $source = 'Healthgrades';
////                }
////                elseif(strtolower($source) == 'ratemd')
////                {
////                    $source = 'Ratemd';
////                }
//
//
//                $matched = array_search($source, $sourceExist);
//
////                $sources[$index] =
//                if($matched !== false)
//                {
//                    $appBusiness = $businessData['records']['businessIssues'][$matched];
//
//                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
//                    {
//                        $matchedStatus = 1;
//                        $sources[$index] = ['name' => $source, 'status' => 'connected'];
//                    }
//                }
//            }
//
//
//            if($matchedStatus == 0)
//            {
//                $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
//            }
//
////            if($source)
//        }
////echo "sources";
////        print_r($sources);
////        exit;
//        $this->data['sources'] = $sources;
//
//        return view('layouts.practice-profile', $this->data);
//    }



    public function upgrade()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.upgrade', $this->data);
    }

    public function accountDelete(Request $request)
    {
        $request->session()->flush();

        return view('auth.account-delete');
    }

    /**
     * Show the form for creating a new resource
     * @return Response
     */
    public function create()
    {
//        $result = $this->userEntity->getIndustry();
//
//        $this->data = '';
//        if($result['_metadata']['outcomeCode'] == 200)
//        {
//            $this->data['industry'] = $result['records'];
//        }

        return view('auth.register', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response 200, 404, 1
     */
    public function store(Request $request)
    {
        Log::info("passing");

        $result = $this->userEntity->register($request);
        
        Log::info(json_encode($request->all()));

        $statusData = [
            'status_code' => $result['_metadata']['outcomeCode'],
            'status_message' => $result['_metadata']['message'],
            'data' => $result['records'],
            'errors' => '',
        ];

        return json_encode($statusData);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function showLogin()
    {
        $this->data['hidePartials'] = true;

//        if(!empty($this->data['hidePartials']))
//        {
//            echo "if";
//        }
//
//        exit;
        return view('auth.login', $this->data);
    }


    public function showForgotPasswordPage()
    {
        $this->data['hidePartials'] = true;

//        if(!empty($this->data['hidePartials']))
//        {
//            echo "if";
//        }
//
//        exit;
        return view('auth.forgot-password', $this->data);
    }

    public function login(Request $request)
    {
        $result = $this->userEntity->login($request);

        $statusData = [
            'status_code' => $result['_metadata']['outcomeCode'],
            'status_message' => $result['_metadata']['message'],
            'data' => $result['records'],
            'errors' => $result['errors']
        ];

        return json_encode($statusData);
    }

    public function getNiches(Request $request)
    {
        $result = $this->userEntity->getIndustryNiches($request);

        $responseCode = $result['_metadata']['outcomeCode'];


        $statusData = [
            'status_code' => $responseCode,
            'status_message' => '',
            'data' => $result['records'],
            'errors' => '',
        ];

        return json_encode($statusData);
    }

    public function logOut(Request $request)
    {
        $request->session()->forget(['user_data', 'auth_token', 'social_token'])    ;
//        $request->session()->flush();

        return Redirect('login')
            ->with('messageCode', 200)
            ->with('message', 'Successfully logged out.');
    }

    public function oauthManager(Request $request)
    {
        Log::info("yes oat");
        if(empty($request->get('type')))
        {
            return Redirect::route('social-posts');
        }

//        $userData = $this->sessionService->getAuthUserSession();
//        $token = $userData['token'];
        $type = $request->get('type');
        $businessId = $request->get('business_id');

        $referType = ( !empty($request->get('referType')) ) ? $request->get('referType') : '';

        if(!empty($referType))
        {
            $url = getDomain().'/api/'.$type.'/login?referType='.$referType.'&business_id='.$businessId;
        }
        else
        {
            $url = getDomain().'/api/'.$type.'/login?business_id='.$businessId;
        }

        return Redirect::to($url);
    }
}
