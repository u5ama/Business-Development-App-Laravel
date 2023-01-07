<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Business\Models\Business;
use Modules\CRM\Models\Recipient;
use Modules\Admin\Models\Task;
use Laravel\Cashier\Billable;
class Users extends Model
{
    use Billable;
    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

//    protected $guarded = [];

    public function userRole()
    {
        return $this->belongsToMany(UserRoles::class, 'user_role_xref', 'user_id', 'role_id');
    }

    public function business()
    {
        return $this->hasMany(Business::class, 'user_id', 'id');
    }

    public function singleBusiness()
    {
        return $this->hasOne(Business::class)->select(['name', 'business_id', 'website', 'user_id']);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function taskStatus()
    {
        return $this->belongsToMany(Task::class, 'business_task', 'user_id', 'task_id');
    }

    /**
     * Get the emailrequestlog record associated with the user.
     */
    public function emailrequestlog()
    {
        return $this->hasOne('Modules\User\Models\Emailrequestlog');
    }
    /**
     * Get the smsrequestlog record associated with the user.
     */
    public function smsrequestlog()
    {
        return $this->hasOne('Modules\User\Models\Smsrequestlog');
    }
}
