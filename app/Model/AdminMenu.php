<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    
    protected $table = 'admin_menu';

    protected $primaryKey = 'menu_id';

    public $timestamps = false;

}
