<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 14/3/18
 * Time: PM5:25
 */
$a=1;
$b=&$a;
unset($b);
echo $b;