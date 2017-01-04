<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceShop extends Model
{
    
    protected $table = 'service_shop';

    protected $primaryKey = 'serviceshop_id';

    public $timestamps = false;

    protected $hidden = ['serviceshop_password', 'serviceshop_login_rnd'];
	
	protected $appends = ['serviceshop_status_format', 'serviceshop_check_format', 'serviceshop_operation', 'serviceshop_confirm_time_format','serviceshop_add_time_format'];
	
	public function getServiceshopStatusFormatAttribute()
    {
        $result = $this->serviceshop_status ? '正常' : '禁用';
		return $result;
    }
	
	public function getServiceshopCheckFormatAttribute()
    {
        switch($this->serviceshop_check){
			case -1:
				$result = '已拒绝';break;
			case 0:
				$result = '申请中';break;
			case 1:
				$result = '已同意';break;
		}
		return $result;
    }
	
	public function getServiceshopAddTimeFormatAttribute()
    {
        return date("Y-m-d H:i:s",$this->serviceshop_add_time); 
    }

	public function getServiceshopConfirmTimeFormatAttribute()
    {
		if($this->serviceshop_confirm_time){
            return date("Y-m-d H:i:s",$this->serviceshop_confirm_time);
        }else{
            return '-';
        }

    }

	public function getServiceshopOperationAttribute()
    {
        $html  = "<i class='fa fa-file-word-o' onclick=layOpenView('/admin/serviceshop/details/{$this->serviceshop_id}','90%','90%','查看详情')></i>";
		if ($this->serviceshop_status) {
			$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/serviceshop/serviceshopstatus/{$this->serviceshop_id}/0','禁用')></i>";
		} else {
			$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/serviceshop/serviceshopstatus/{$this->serviceshop_id}/1','启用')></i>";
		}
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/serviceshop/destroy','{$this->serviceshop_id}','tr')></i>";
		return $html;
    }
	
	public function user()
	{
		 return $this->belongsTo('App\User', 'user_id', 'user_id');
	}

}
