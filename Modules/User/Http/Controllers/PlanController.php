<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\Plan;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\User\Models\Users;

class PlanController extends Controller
{
    public function __construct()
    {

        $this->sessionService = new SessionService();

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function upgrade()
    {
        # code...
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        return view('layouts.upgrade', $this->data);
    }
    public function billing()
    {
        $user_id = session('user_data')['id'];
        $user = Users::find($user_id);
        $customer_id = $user->stripe_id;
        if ($customer_id) {
            # code...
            $this->data['invoices'] = $user->invoices();
        }

        $this->data['showAdditionalBar'] = true;
        return view('layouts.billing', $this->data);
    }
}
