<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 27/12/17
 * Time: AM10:36
 */

namespace backend\components;




class ContainerB
{
    public $name;
    private $_age;
    protected $_t;

    /*
     * 构造方法的类注入
     */
    public function __construct($age,ContainerA $a)
    {
        $this->_age =$age;
        $this->_t =$a;
    }

}