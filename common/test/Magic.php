<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM3:08
 * 魔术方法
 */

namespace common\test;

class Magic
{
    public $name;
    protected $height;
    private $school;
    /*
     * 除了public 类型的属性不会调用get魔术方法
     */
    public function __get($name)
    {
        var_dump($name);
    }
    /*
     *如果调用的是类里面不存在的属性 不管是什么类型都会调用set魔术方法
     */
    public function __set($name, $value)
    {
        var_dump($name,$value);
    }

}

$a =new Magic();
// $a->age =30;
// echo $a->name;
// $a->height=185;
// echo $a->school;

