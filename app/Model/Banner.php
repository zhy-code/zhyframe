<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    
    protected $table = 'banner';

    protected $primaryKey = 'banner_id';

    public $timestamps = false;
	
	protected $appends = ['banner_url_format','link_url_format'];
	
	public function getBannerUrlFormatAttribute()
    {
        $result = explode('::::::',$this->banner_url);
		return $result;
    }
	
	public function getLinkUrlFormatAttribute()
    {
        $result = explode('::::::',$this->link_url);
		return $result;
    }
	
}
