<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 19/1/18
 * Time: AM9:40
 * b 标签是php 逻辑处理的结果返回
 */
$id =$_GET['id'];
if(empty($id)){
    $id = '';
}
ob_start();
$file =md5(__FILE__).'-'.$id.'.html';
$cache_time =3600;
//  如果文件修改时间小于缓存的修改时间 意思就是没有修改  读缓存  缓存时间没有失效  并且缓存文件存在
if(file_exists($file)&&filectime(__FILE__)<=filectime($file)&&((time()-filectime($file))<3600)){
    include $file;
    exit();
}
?>


<b>This is my PHP id = <?php echo $id?></b>

<?php

//获取上面b标签的内容
$content =ob_get_contents();

ob_end_flush();

//写入静态的文件
$hand = fopen($file,'w');
fwrite($hand,$content);