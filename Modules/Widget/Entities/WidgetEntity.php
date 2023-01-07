<?php


namespace Modules\Widget\Entities;
use DB;
use Log;
use Mail;
use JWTAuth;
use Exception;
use http\Env\Request;
use App\Traits\UserAccess;
use Modules\User\Models\Users;
use App\Entities\AbstractEntity;
use App\Services\SessionService;
use Modules\Widget\Models\Widget;
use Modules\Business\Models\Business;
use Yajra\DataTables\Facades\DataTables;
use Modules\Business\Entities\BusinessEntity;


class WidgetEntity extends AbstractEntity
{
    use UserAccess;

    protected $businessEntity;

    protected $sessionService;

    public function __construct()
    {
    
        $this->sessionService = new SessionService();
    }
    public function widgetsList()
    {
        # code...
        try {
            //code...
            $user_id = session('user_data')['id'];

            $widgets = Widget::where('user_id',$user_id);
            
            $widgetsDatatable = DataTables::of($widgets);
            $widgetsDatatableData = collect($widgetsDatatable->make(true)->getData());
            return $this->helpReturn("Widgets List", $widgetsDatatableData);
        } catch (Exception $exception) {
            //throw $th;
            Log::info(" widgetsList " . $exception->getMessage());
            return $this->helpError('widgetsList', 'Some Problem happened. please try again.');
        }
    }

    
    public function deleteWidget($request)
    {
        # code...
        try {
            $ids = explode(",", $request->widgetID);

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userID = $businessResult['user_id'];

            Log::info('user_id');
            Log::info($userID);

            Log::info('id');
            Log::info($ids);

            $widget = Widget::whereIn('id', $ids)->where('user_id', $userID)->get()->toArray();
            Log::info('widget');
            Log::info($widget);

            if (!empty($widget)) {
                Widget::whereIn('id', $ids)->where('user_id', $userID)->delete();
            } else {
                return $this->helpError(404, 'Record Not Exists');
            }

            return $this->helpReturn("Widget Deleted Successfully.");
        } catch (Exception $exception) {
            Log::info("deleteWidget " . $exception->getMessage() . '> ' . $exception->getLine());
            return $this->helpError('deleteWidget', 'Some Problem happened. please try again.');
        }
    }
}