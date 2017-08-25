<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/7/17
 * Time: PM1:31
 */




    $h_code = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'];
    $goods_bn =$h_code[intval(date('H'))] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 4) . sprintf('%02d', rand(0, 99));
    echo  $goods_bn."</br>";
    echo  $a =  substr(time(), -5);

