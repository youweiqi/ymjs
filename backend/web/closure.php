<?php
/**
 * 闭包
 * Created by PhpStorm.
 * User: apple
 * Date: 2/2/18
 * Time: PM1:55
*/
function printStr() {
    $func = function( $str ) {
        echo $str;
    };
    $func( 'some string```' );
}

printStr();
function getPrintStrFunc() {
    $func = function( $str ) {
        echo $str;
    };
    return $func;
}

$printStrFunc = getPrintStrFunc();
$printStrFunc( 'some' );

function getMoney() {
    $rmb = 1;
    $dollar = 6;
    $func = function() use ( $rmb,$dollar ) {
        echo $rmb."\n";
        echo $dollar;
    };
    $func();
}

getMoney();


//闭包或者匿名函数 只是把引入进来 变量的值是无法修改的  打印出来的就是1  1
function getMoney1() {
    $rmb = 1;
    $func = function() use ( $rmb ) {
        echo $rmb."\n";
        //把$rmb的值加1
        $rmb++;
    };
    $func();
    echo $rmb;
}

getMoney1();

//互为引用之后就可以
function getMoney2() {
    $rmb = 1;
    $func = function() use ( &$rmb ) {
        echo $rmb;
        //把$rmb的值加1
        $rmb++;
    };
    $func();
    echo $rmb;
}

getMoney2();

function closureFunc4(){
    $num = 1;
    $func = function($str) use($num){
        echo $num;
        echo "\n";
        echo $str;
    };
    return $func;
}
$func = closureFunc4();
$func("hello, closure4");