<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    
    protected $table = 'admin_user';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $hidden = ['user_password', 'user_login_rnd'];

    public function setUserPasswordAttribute($user_password)
    {
        $this->attributes['user_password'] = \Hash::make($user_password);
    }


}
