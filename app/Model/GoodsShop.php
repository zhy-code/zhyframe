<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsShop extends Model
{
    
    protected $table = 'goods_shop';

    protected $primaryKey = 'goodsshop_id';

    public $timestamps = false;

    protected $hidden = ['goodsshop_password', 'goodsshop_login_rnd'];
	
	protected $appends = ['goodsshop_status_format', 'goodsshop_check_format', 'goodsshop_operation', 'goodsshop_confirm_time_format','goodsshop_add_time_format'];
	
	public function getGoodsshopStatusFormatAttribute()
    {
        $result = $this->goodsshop_status ? '正常' : '禁用';
		return $result;
    }
	
	public function getGoodsshopCheckFormatAttribute()
    {
        switch($this->goodsshop_check){
			case -1:
				$result = '已拒绝';break;
			case 0:
				$result = '申请中';break;
			case 1:
				$result = '已同意';break;
		}
		return $result;
    }
	
	public function getGoodsshopAddTimeFormatAttribute()
    {
        return date("Y-m-d H:i:s",$this->goodsshop_add_time); 
    }

	public function getGoodsshopConfirmTimeFormatAttribute()
    {
		if($this->goodsshop_confirm_time){
            return date("Y-m-d H:i:s",$this->goodsshop_confirm_time);
        }else{
            return '-';
        }

    }

	public function getGoodsshopOperationAttribute()
    {
        $html  = "<i class='fa fa-file-word-o' onclick=layOpenView('/admin/goodsshop/details/{$this->goodsshop_id}','90%','90%','查看详情')></i>";
		if ($this->goodsshop_status) {
			$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/goodsshop/goodsshopstatus/{$this->goodsshop_id}/0','禁用')></i>";
		} else {
			$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/goodsshop/goodsshopstatus/{$this->goodsshop_id}/1','启用')></i>";
		}
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/goodsshop/destroy','{$this->goodsshop_id}','tr')></i>";
		return $html;
    }
	
	public function user()
	{
		 return $this->belongsTo('App\User', 'user_id', 'user_id');
	}

}
