<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    
    protected $table = 'feedback';

    protected $primaryKey = 'id';

    public $timestamps = false;
	
	protected $appends = ['add_time_format', 'operation', 'checkbox'];
	
	public function getCheckboxAttribute()
    {
        $html = '<label><input type="checkbox" name="checkboxList" value="'.$this->id.'" class="input-checkbox"><i>✓</i></label>';
		return $html;
    }
	
	public function getAddTimeFormatAttribute()
    {
        $result = date("Y-m-d H:i:s", $this->add_time);
		return $result;
    }
	
	public function getOperationAttribute()
    {
		$html  = "<i class='fa fa-edit' title='备注' onclick=layRemarks('/admin/feedback/remark','{$this->id}','{$this->remark}')></i>";
		$html .= "<i class='fa fa-trash-o ml-15' onclick=layListDel(this,'/admin/feedback/destroy','{$this->id}','tr')></i>";
		return $html;
    }


}
