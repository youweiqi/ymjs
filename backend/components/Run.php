<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 27/12/17
 * Time: AM11:03


namespace backend\components;

use Yii;

$testObj = Yii::createObject([
    'class' =>'backend\components\ContainerB',
    'name' =>'This is Container B li de name',
],[20]);

print_r($testObj);


$info = array('coffee', 'brown', 'caffeine');
list($drink, $color, $power) = $info;
//echo "$drink is $color and $power makes it special.\n";


list($drink, , $power) = $info;
//echo "$drink has $power.\n";


list( , , $power) = $info;
//echo "I need $power!\n";

list($bar) = "abcde";
//var_dump($bar); // NULL


list($a, list($b, $c)) = array(1, array(2, 3));

//var_dump($a, $b, $c);*/


$info = array('coffee', 'brown', 'caffeine');

list($a[0], $a[1], $a[2]) = $info;

var_dump($a);