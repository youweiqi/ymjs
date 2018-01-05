<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/12/17
 * Time: PM5:26
 * IOC 容器
 */

class Container {

    private $_definitions;
    /*
     * set方法用于存储类，get用于实例化类。
     */
    public function set($class,$definition)
    {
        $this->_definitions[$class] =$definition;
    }
    /*call_user_func第一个参数 callback 是被调用的回调函数，其余参数是回调函数的参数。
     * 意思class 是被调用的回调函数,params 是回调函数的参数
     */
    public function get($class,$params=[])
    {
        $definition =$this->_definitions[$class];
        return call_user_func($definition,$params);
    }

}