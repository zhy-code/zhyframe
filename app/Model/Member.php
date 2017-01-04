<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    
    protected $table = 'member';

    protected $primaryKey = 'member_id';

    public $timestamps = false;

    protected $hidden = ['member_password', 'member_login_rnd'];
	
	protected $appends = ['member_status_format', 'member_operation', 'member_checkbox'];
	
	public function getUserStatusFormatAttribute()
    {
        $result = $this->member_status ? '正常' : '禁用';
		return $result;
    }
	
	public function getUserCheckboxAttribute()
    {
        $html = '<label><input type="checkbox" name="checkboxList" value="'.$this->member_id.'" class="input-checkbox"><i>✓</i></label>';
		return $html;
    }
	
	public function getUserOperationAttribute()
    {
        $html  = "<i class='fa fa-edit' onclick=layOpenView('/admin/member/memberedit/{$this->member_id}','90%','90%','会员信息编辑')></i>";
		if ($this->member_status) {
			$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/member/memberstatus/{$this->member_id}/0','禁用')></i>";
		} else {
			$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/member/memberstatus/{$this->member_id}/1','启用')></i>";
		}
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/member/destroy','{$this->member_id}','tr')></i>";
		return $html;
    }


}
