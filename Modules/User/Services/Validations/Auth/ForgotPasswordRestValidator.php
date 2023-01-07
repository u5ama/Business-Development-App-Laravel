<?php

namespace Modules\User\Services\Validations\Auth;

use App\Services\Validations\LaravelValidator;

class ForgotPasswordRestValidator extends LaravelValidator
{
    protected $messages = [

    ];

    protected $rules = [
        'password' => 'required',
        'confirm_password' => 'required|same:password',

    ];
}
