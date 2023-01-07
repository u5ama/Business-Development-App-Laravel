<?php

namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Models\TripadvisorReview;

class DashboardWidgetEntity extends AbstractEntity {

    protected $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    public function lastReviews($userData, $numberofreviews = 5)
    {
        $connectionIds = $this->connectionIds($userData);
        
        $lastReviews = TripadvisorReview::whereIn('third_party_id',$connectionIds)->orderBy('review_date', 'desc')->take($numberofreviews)->get();
        return $lastReviews;
    }
    public function allReviews($userData)
    {
        $connectionIds = $this->connectionIds($userData);
        
        $allReviews = TripadvisorReview::whereIn('third_party_id',$connectionIds)->orderBy('review_date', 'desc')->paginate(10);
        return $allReviews;
    }
    public function overAllRating($userData)
    {
        # code...
        $connectionIds = $this->connectionIds($userData);

        $overAllRating = TripadvisorReview::whereIn('third_party_id',$connectionIds)->get()->average('rating');
        return $overAllRating;
    }
    public function publicReviews($userData)
    {
        # code...
        $connectionIds = $this->connectionIds($userData);

        $publicReviews = TripadvisorReview::whereIn('third_party_id',$connectionIds)->get()->count();
        return $publicReviews;
    }
    public function sentiments($userData)
    {
        # code...
        $connectionIds = $this->connectionIds($userData);

        $rating3_4_5 = TripadvisorReview::whereIn('third_party_id',$connectionIds)->whereIn('rating',[3,4,5])->get()->count();
        if ($this->publicReviews($userData)) {
            # code...
            $sentiments = $rating3_4_5/$this->publicReviews($userData)*100;
        } else {
            # code...
            $sentiments = 'publicReviewsNotAvailable';
        }
        
        return $sentiments;
    }

    /** 
     * 
     * @param $userData array
     * @return $connectionIds array 
    */
    private function connectionIds($userData)
    {
        # code...
        $businessId = $userData['business'][0]['business_id'];
        $connectionIds = TripadvisorMaster::where('business_id', $businessId)
                ->where('page_url', '!=', '') 
                ->get()->pluck('third_party_id');
        return $connectionIds;
    }
    
}