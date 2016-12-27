<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Welfare extends Model
{
    
    protected $table = 'column_welfare';

    protected $primaryKey = 'id';

    public $timestamps = false;
	
	protected $appends = ['status_format', 'edit_time_format', 'operation', 'checkbox', 'classify_format'];
	
	public function getStatusFormatAttribute()
    {
        $result = $this->status ? '展示' : '隐藏';
		return $result;
    }
	
	public function getClassifyFormatAttribute()
    {
		switch($this->classify){
			case 1:
				$result = '企业公益';break;
			case 2:
				$result = '员工公益';break;
			default:
				$result = '其他类别';break;
		}
		return $result;
    }

	public function getCheckboxAttribute()
    {
        $html = '<label><input type="checkbox" name="checkboxList" value="'.$this->id.'" class="input-checkbox"><i>✓</i></label>';
		return $html;
    }
	
	public function getEditTimeFormatAttribute()
    {
        $result = date("Y-m-d H:i:s", $this->edit_time);
		return $result;
    }
	
	public function getOperationAttribute()
    {
        $html  = "<i class='fa fa-edit' onclick=layOpenView('/admin/welfare/welfareedit/{$this->id}','100%','100%','信息编辑')></i>";
		if ($this->status) {
			$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/welfare/welfarestatus/{$this->id}/0','隐藏')></i>";
		} else {
			$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/welfare/welfarestatus/{$this->id}/1','展示')></i>";
		}
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/welfare/destroy','{$this->id}','tr')></i>";
		return $html;
    }


}
