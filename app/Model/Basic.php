<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basic extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'tests';

    /**
     * 数据表的主键字段
     *
     * @var string
     */
    protected $primaryKey = 'userid';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 模型的日期字段保存格式。
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 此模型的连接名称。
     *
     * @var string
     */
    protected $connection = 'connection-name';

    /**
     * 应该被转换成原生类型的属性。
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * 在数组中隐藏的属性。
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * 在数组中可见的属性。
     *
     * @var array
     */
    protected $visible = ['first_name', 'last_name'];

    /**
     * 访问器被附加到模型数组的形式。
     *
     * 前提是先设置一个访问器
     *
     * @var array
     */
    protected $appends = ['is_admin'];

    /**
     * 定义访问器--获取用户的名字。
     * 
     * 命名方式：要访问的字段（first_name）需使用 「驼峰式」 来命名 get...Attribute
     * 
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * 定义修改器--设置用户的名字。
     * 
     * 命名方式：要修改的字段（first_name）需使用 「驼峰式」 来命名 set...Attribute
     * 
     * @param  string  $value
     * @return string
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    /**
     * 关联模型。
     *
     * 一对一： hasOne  <=> belongsTo	hasOne('App\ModelName', 'foreign_key', 'local_key')
     *
     * 一对多： hasMany <=> belongsTo	hasMany('App\ModelName', 'foreign_key', 'local_key')
     *
     * 多对多： belongsToMany <=> belongsToMany 
     *         使用 pivot 属性来访问中间数据表的数据
     * 
     */
    public function linkname()
    {
        return $this->hasOne('App\ModelName');
    }

    
}
