<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\ThirdParty\Models\StatTracking;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;

class ReviewsController extends Controller
{
    protected $data;

    protected $businessEntity;

    protected $websiteEntity;

    protected $tripPartyEntity;

    protected $thirdPartyEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->tripPartyEntity = new TripAdvisorEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
    }

    public function reviewsList(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['reviewsResult'] = $this->thirdPartyEntity->thirdPartyReviews($request);

        //        $this->data['reviewsResult'] = [];
        //        print_r($this->data['reviewsResult']);
        //        exit;
        // dd($this->data);
        $sources = thirdPartySources();
        $this->data['sources'] = $sources;
        return view('layouts.reviews.reviews', $this->data);
    }

    public function customizeInvitationLayout(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.customize-invitation', $this->data);
    }

    public function thirdPartyAppsList(Request $request)
    {

        //        print_r($request->all());
        //        exit;
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
        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['socialToken'] = '';
        if (!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook') {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $businessData = $this->businessEntity->businessDirectoryList($request);

        $sources = thirdPartySources();
        
        if (!empty($businessData['records']['businessIssues'])) {
            $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
        }
        //print_r($sourceExist);
        //        exit;
        foreach ($sources as $index => $source) {
            $matchedStatus = 0;

            if (!empty($sourceExist)) {
                //                $source = strtolower($source);

                $source = ucwords(strtolower($source));

                //                if(strtolower($source) == 'healthgrades')
                //                {
                //                    $source = 'Healthgrades';
                //                }
                //                elseif(strtolower($source) == 'ratemd')
                //                {
                //                    $source = 'Ratemd';
                //                }

                $matched = array_search($source, $sourceExist);

                //                $sources[$index] =
                if ($matched !== false) {
                    $appBusiness = $businessData['records']['businessIssues'][$matched];

                    //                    print_r($appBusiness['name']);
                    //                    exit;

                    if ($appBusiness['type'] == $source && !empty($appBusiness['name'])) {
                        $matchedStatus = 1;
                        $sources[$index] = ['appName' => $appBusiness['name'], 'name' => $source, 'status' => 'connected'];
                    }
                }
            }


            if ($matchedStatus == 0) {
                $sources[$index] = ['appName' => '', 'name' => $source, 'status' => 'not_connected'];
            }

            //            if($source)
        }
        //echo "sources";
        //        print_r($sources);
        //        exit;
        $this->data['sources'] = $sources;
        
        //        return view('layouts.connect-apps', $this->data);
        return view('layouts.third-party-apps', $this->data);
    }

    public function statTrackingReviewData()
    {
        # code...
        $userData = $this->sessionService->getAuthUserSession();
        $graphStatsQuery = StatTracking::where('user_id', $userData['id'])->where('type', 'RV');
        /*New query for all Data*/
                    // if ($reviewsType == 'all'){
                        $last_twelve_month_ary = $salesTotalAry = [];
                        $varCounter = 0;
                        for ($g = 11; $g > -1; $g--){
                            $varCounter++;
                            $bar_year = date("Y", strtotime("-$g months"));
                            $bar_month = date("m", strtotime("-$g months"));
                            //$last_twelve_month_ary[] = '"'.date("M Y", strtotime("-$g months")).'"';

                            ${'standard_query_'.$varCounter} = clone $graphStatsQuery;
                            //prepare condition
                            $data = ${'standard_query_'.$varCounter}->whereMonth('activity_date', '=', $bar_month)->whereYear('activity_date', '=', $bar_year)->sum('count');
                            $last_twelve_month_ary[date("M Y", strtotime("-$g months"))] = $data;
                            // if ($category_type == 'RG'){
                                $data = ${'standard_query_'.$varCounter}->whereMonth('activity_date', '=', $bar_month)->whereYear('activity_date', '=', $bar_year)->avg('count');
                                $last_twelve_month_ary[date("M Y", strtotime("-$g months"))] = $data;
                            // }
                        }

                        $encodedData = [];
                        $k= 0;
                        foreach($last_twelve_month_ary as $index => $val)
                        {
                            $encodedData[$k]['activity_date'] = $index;
                            $encodedData[$k]['count'] = $val;

                            $k++;
                        }
                        $graphStats = $encodedData;
                        // dd($graphStats);
                        return $graphStats;
                    // }
                    /*New query for all Data*/
    }
    public function statTrackingRatingData()
    {
        # code...
        $userData = $this->sessionService->getAuthUserSession();
        $graphStatsQuery = StatTracking::where('user_id', $userData['id'])->where('type', 'RG');
        /*New query for all Data*/
                    // if ($reviewsType == 'all'){
                        $last_twelve_month_ary = $salesTotalAry = [];
                        $varCounter = 0;
                        for ($g = 11; $g > -1; $g--){
                            $varCounter++;
                            $bar_year = date("Y", strtotime("-$g months"));
                            $bar_month = date("m", strtotime("-$g months"));
                            //$last_twelve_month_ary[] = '"'.date("M Y", strtotime("-$g months")).'"';

                            ${'standard_query_'.$varCounter} = clone $graphStatsQuery;
                            //prepare condition
                            $data = ${'standard_query_'.$varCounter}->whereMonth('activity_date', '=', $bar_month)->whereYear('activity_date', '=', $bar_year)->sum('count');
                            $last_twelve_month_ary[date("M Y", strtotime("-$g months"))] = $data;
                            // if ($category_type == 'RG'){
                                $data = ${'standard_query_'.$varCounter}->whereMonth('activity_date', '=', $bar_month)->whereYear('activity_date', '=', $bar_year)->avg('count');
                                $last_twelve_month_ary[date("M Y", strtotime("-$g months"))] = $data;
                            // }
                        }

                        $encodedData = [];
                        $k= 0;
                        foreach($last_twelve_month_ary as $index => $val)
                        {
                            $encodedData[$k]['activity_date'] = $index;
                            $encodedData[$k]['count'] = $val;

                            $k++;
                        }
                        $graphStats = $encodedData;
                        // dd($graphStats);
                        return $graphStats;
                    // }
                    /*New query for all Data*/
    }
}
