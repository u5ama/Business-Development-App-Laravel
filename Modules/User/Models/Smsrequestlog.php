<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Smsrequestlog extends Model
{
    protected $table = 'smsrequestlogs';
    protected $fillable  = ['remaining', 'maximum', 'users_id'];
    /**
     * Get the user that owns the smsrequestlogs.
     */
    public function user()
    {
        return $this->belongsTo('Modules\User\Models\Users');
    }
}
