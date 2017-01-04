<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    //
    //use SoftDeletes;
    protected $table = 'user';
    protected $guarded = [];
    public $primaryKey= 'user_id';

    //public $timestamps = false;



}

