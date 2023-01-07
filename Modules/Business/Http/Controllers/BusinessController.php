<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\ThirdParty\Entities\DashboardWidgetEntity;

class BusinessController extends Controller
{
    protected $data;

    protected $sessionService;

    protected $businessEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;

    // Later change name to reviewEntity
    protected $dashboardWidgetEntity;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->dashboardWidgetEntity = new DashboardWidgetEntity();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('business::index');
    }

    public function home()
    {
        return "Welcome Dashboard";
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('business::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('business::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('business::edit');
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

    public function thirdPartyConnect(Request $request)
    {
        return $this->businessEntity->thirdPartyConnect($request);
    }

    public function businessListing(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

        $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];

        $businessData = $this->businessEntity->businessDirectoryList($request);

        $sources = thirdPartySources();

        if(!empty($businessData['records']['businessIssues']))
        {
            $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
        }
//print_r($sourceExist);
//        exit;
        foreach($sources as $index => $source)
        {
            $matchedStatus = 0;

            if(!empty($sourceExist))
            {
                $source = ucwords(strtolower($source));

                $matched = array_search($source, $sourceExist);

                if($matched !== false)
                {
                    $appBusiness = $businessData['records']['businessIssues'][$matched];

                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
                    {
                        $matchedStatus = 1;
                        $sources[$index] = [
                            'name' => $source, 'status' => 'connected',
                            'data' => $appBusiness
                        ];
                    }
                }
            }

            if($matchedStatus == 0)
            {
                $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
            }
        }

        $this->data['sources'] = $sources;

        return view('layouts.business-listings', $this->data);
    }

    public function companyReviews(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

        $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];
        $this->data['overAllRating'] = $this->dashboardWidgetEntity->overAllRating($userData);
        $this->data['publicReviews'] = $this->dashboardWidgetEntity->publicReviews($userData);
        $this->data['allReviews'] = $this->dashboardWidgetEntity->allReviews($userData);
        // dd($this->data);
        return view('layouts.reviews.company-reviews-list', $this->data);
    }

    public function webConnect(Request $request)
    {
        $crmObj = new CRMEntity();
        return  $crmObj->addCustomers($request);
//        return $this->websiteEntity->getWebsiteDetails($request);

        return $this->thirdPartyEntity->thirdPartyReviews($request);
    }
}
