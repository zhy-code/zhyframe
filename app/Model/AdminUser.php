<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    
    protected $table = 'admin_user';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $hidden = ['user_password', 'user_login_rnd'];
	
	protected $appends = ['user_status_format', 'user_last_login_time_format', 'user_operation'];
	
    public function setUserPasswordAttribute($user_password)
    {
        $this->attributes['user_password'] = \Hash::make($user_password);
    }
	
	public function getUserStatusFormatAttribute()
    {
        $result = $this->user_status ? '正常' : '禁用';
		return $result;
    }
	
	public function getUserLastLoginTimeFormatAttribute()
    {
        $result = date("Y-m-d H:i:s", $this->user_last_login_time);
		return $result;
    }
	
	public function getUserOperationAttribute()
    {
        $html  = "<i class='fa fa-edit' onclick=layOpenView('/admin/user/useredit/{$this->user_id}','90%','90%','管理员信息编辑')></i>";
		if ($this->user_status) {
			$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/user/userstatus/{$this->user_id}/0','禁用')></i>";
		} else {
			$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/user/userstatus/{$this->user_id}/1','启用')></i>";
		}
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/user/destroy/{$this->user_id}','tr')></i>";
		return $html;
    }


}
