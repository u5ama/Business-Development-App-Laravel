<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CRM\Models\CrmSettings;

class PageController extends Controller
{
    protected $data;

    public function home()
    {
        return view('layouts.home');
    }

    public function customers()
    {
        return view('layouts.customers');
    }

    public function invitesSent()
    {
        return view('layouts.invites');
    }

    public function emailTemplate()
    {
        return view('layouts.email');
    }

    public function register()
    {
        return view('layouts.register');
    }

    public function forgotPassword()
    {
        return view('layouts.forgot-password');
    }

    public function login()
    {
        return view('layouts.login');
    }

    public function thirdPartyAppsView()
    {
        return view('layouts.third-party-apps');
    }






    public function reviewWidget()
    {
        $this->data['showAdditionalBar'] = true;
        return view('layouts.review-widget', $this->data);
    }


    public function payment()
    {
        $this->data['showAdditionalBar'] = true;
        return view('layouts.payment', $this->data);
    }
}
