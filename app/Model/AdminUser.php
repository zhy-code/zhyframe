<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    
    protected $table = 'admin_user';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

}
