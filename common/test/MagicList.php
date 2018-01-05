<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM3:28
 * Yii 配置的例子
 */

namespace common\test;



class MagicList
{
    public $name;

    private $_definitions =[];

    /*
     * 存到这个私有的属性数组里面
     */
    public function __set($name, $value)
    {
        $this->_definitions[$name]=$value;
    }

    /*
     * 看这个私有的属性的这个数组里面是否有设置这个属性的值
     * 三目判断
     */
    public function __get($name)
    {
        return isset($this->_definitions[$name])?$this->_definitions[$name]:null;
    }

}

/*
 * main 的配置环境
 */
$config=[
    'class'=>'MagicList',
    'name'=>'zhangsan',
    'age'=>20
];

$class =$config['class'];
unset($config['class']);

$obj = new $class;

foreach ($obj as $k=>$v)
{
    $obj->$k =$v;
}




