<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 26/7/17
 * Time: PM1:31
 */

/*$h_code = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'];
    $goods_bn =$h_code[intval(date('H'))] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 4) . sprintf('%02d', rand(0, 99));
    echo  $goods_bn."</br>";
    echo  $a =  substr(time(), -5);

$a=1;
$x=&$a;
$b=$a++;
echo $x."\n";
echo $b."\n";
echo 3|4;    =7

function test(&$a)

    {

        $a=$a+100;

    }

    $b=1;

    echo $b;//输出１

    test($b);   //这里$b传递给函数的其实是$b的变量内容所处的内存地址，通过在函数里改变$a的值　就可以改变$b的值了

    echo "<br>";

    echo $b;//输出101

?>


$count=5; //全局变量
function get_count(){
    static $count=2 ;//  静态变量只赋值一次 因为第一次没有没有给count 赋值 所以它是NULL  第二次在调用的时候 count =1  这个1 他是NULL
    return $count++;
}
var_dump($count);//5
++$count;//6
var_dump(get_count()); //因为count++ 是先输出后加 所以它也是NULL
var_dump(get_count()); //在次调用这个函数*/

echo date("Ymd");