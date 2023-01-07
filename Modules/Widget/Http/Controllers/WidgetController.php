<?php

namespace Modules\Widget\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\SessionService;
use Modules\Widget\Models\Widget;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Modules\Widget\Entities\WidgetEntity;
use Modules\ThirdParty\Models\ThirdPartyMaster;
use Modules\ThirdParty\Models\TripadvisorReview;

class WidgetController extends Controller
{
    protected $widgetEntity;
    protected $sessionService;
    protected $data;

    public function __construct()
    {
        $this->widgetEntity = new WidgetEntity();
        $this->sessionService = new SessionService();
    }

    /**
     * @return view
     */
    public function widgets()
    {

        return view('layouts.widgets');

    }
    /**
     * @return view
     */
    public function createWidget()
    {
        return view('layouts.createWidget');
    }
    /**
     * @param Request $request
     * @return json
     */
    public function createNewWidget(Request $request)
    {
        
        $user_id = session('user_data')['id'];
        
        $request->validate([
            'widget_name' => 'required|unique:widgets,name,user_id',
            'widget_type' => 'required'
        ]);
        // 
        $widget = Widget::create(
            [
                'name' => $request->widget_name,
                'type' => $request->widget_type,
                'number_of_reviews' => $request->number_of_reviews,
                'testimonial_min_stars' => $request->minimum_rating,
                'sort_review_by' => $request->sort_review_by,
                'schema_markup' => $request->schema_markup,
                'font_style' => $request->font_style,
                'background_color' => $request->background_color,
                'stars_color' => $request->star_color,
                'author_color' => $request->author_font_color,
                'quote_color' => $request->quote_font_color,
                'date_color' => $request->date_color,
                'user_id' => $user_id
            ]
        );
        
        return response()->json($widget);
    }
    /**
     * @param Request $request
     * @return json
     */
    public function widgetSetting(Request $request)
    {
        $user_id = session('user_data')['id'];

        $request->validate([
            'widget_name' => 'required',

        ]);

        $widget = Widget::where('name',$request->widget_name)->where('user_id',$user_id)->update(
            [
                'number_of_reviews' => $request->number_of_reviews,
                'testimonial_min_stars' => $request->minimum_rating,
                'sort_review_by' => $request->sort_review_by,
                'schema_markup' => $request->schema_markup
            ]
        );
        $widget = Widget::where('name',$request->widget_name)->where('user_id',$user_id)->get();
        
        return response()->json($widget);
    }
    /**
     * @param Request $request
     * @return json
     */
    public function widgetTheme(Request $request)
    {
        $user_id = session('user_data')['id'];

        $request->validate([
            'widget_name' => 'required',
        ]);

        $widget = Widget::where('name',$request->widget_name)->where('user_id',$user_id)->update(
            [
                'font_style' => $request->font_style,
                'background_color' => $request->background_color,
                'stars_color' => $request->star_color,
                'author_color' => $request->author_font_color,
                'quote_color' => $request->quote_font_color,
                'date_color' => $request->date_color
            ]
        );

        $widget = Widget::where('name',$request->widget_name)->where('user_id',$user_id)->get();

        return response()->json($widget);
    }
    /**
     * @param Request $request
     * @return json
     */
    public function numberOfReviews(Request $request)
    {
        # code...
        $business_id = session('user_data')['business'][0]['business_id'];
        $third_party_ids = ThirdPartyMaster::where('business_id', $business_id)->pluck('third_party_id');
        if ($request->selected_widget_name == 'SingleQuote') {
            # code...
            $reviews = TripadvisorReview::whereIn('third_party_id', $third_party_ids)->orderBy('rating', 'desc')->orderBy('review_date', 'desc')->take(1)->get();
        } elseif ($request->selected_widget_name == 'Badge') {
            # code...
            $reviews = TripadvisorReview::whereIn('third_party_id', $third_party_ids)->orderBy('rating', 'desc')->get();
        } else {
            # code...
            if ($request->sort_review_by == 'Date') {
                $reviews = TripadvisorReview::whereIn('third_party_id', $third_party_ids)->where('rating', '>=', $request->minimum_rating)->orderBy('review_date', 'desc')->take($request->number_of_reviews)->get();
            } else {
                $reviews = TripadvisorReview::whereIn('third_party_id', $third_party_ids)->where('rating', '>=', $request->minimum_rating)->orderBy('rating', 'desc')->take($request->number_of_reviews)->get();
            }
        }
        
        return response()->json($reviews);
        
    }
    /**
     * @param Request $request
     * @return json
     */

    public function showWidget(Request $request)
    {
        // Log::info("api working");
        // $data['widget'] =1;
        //     $data['reviews'] = 2;
        //     return response()->json($data);
        # code...
        // dd($request->all());
        try {
            //code...
            $widget = Widget::find($request->id);
        
            if ($widget->sort_review_by == 'Date') {
                $reviews = TripadvisorReview::where('rating', '>=', $widget->testimonial_min_stars)->orderBy('review_date', 'desc')->take($widget->number_of_reviews)->get();
            } else {
                $reviews = TripadvisorReview::where('rating', '>=', $widget->testimonial_min_stars)->orderBy('rating', 'desc')->take($widget->number_of_reviews)->get();
            }
            $data['widget'] = $widget;
            $data['reviews'] = $reviews;
            return response()->json($data);

        } catch (Exception $exception) {
            //Exception $exception;
            Log::info(" showWidget > " . $exception->getMessage());
            return $exception->getMessage();
        }

    }

    public function showWidgetView()
    {
        # code...
        return view('layouts.widgetsshow');
    }

    /**
     * @return json
     */
    public function widgetsList()
    {
        # code...
        $widgetsDatatableData = $this->widgetEntity->widgetsList();
        $widgetsDatatableData = $widgetsDatatableData['records'];
        return response()->json($widgetsDatatableData);
    }

    

    public function deleteWidget(Request $request)
    {
        # code...
        return $this->widgetEntity->deleteWidget($request);
    }


    public function test(Request $request)
    {
        # code...
        dd($request->all());
    }

}
