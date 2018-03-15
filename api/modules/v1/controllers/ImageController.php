<?php

namespace api\modules\v1\controllers;

use api\models\Images;
use yii\helpers\Html;
use Yii;
use yii\rest\ActiveController;

class ImageController extends ActiveController
{
    public $modelClass = 'api\models\Images';

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionTest($image_id)
    {
        //把得到的参数切分
        $image = explode('.',$image_id);
        $type = array_pop($image);
        $string = array_shift($image);
        $array_data= explode('-',$string);
        $id = array_shift($array_data);

        $array = [];
        foreach ($array_data as $v) {
            $array[substr($v,0,1)] = substr($v,1);
        }
        $cache =Yii::$app->cache;
        if($cache->redis->get($id)){
            return Html::img($cache->get($id));
        }else{
            //是否存满十级
             if($cache->redis->llen($id)<10){
                 $images = Images::findOne($id);
                 //做图片的转化
                 $imagine = new Imagine\Imagick\Imagine();
                 $options = array(
                     'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
                     'resolution-x' => isset($array['w'])?$array['w']:null,
                     'resolution-y' => isset($array['h'])?$array['h']:null,
                     'resampling-filter' => ImageInterface::FILTER_LANCZOS,
                 );
                 $value=$imagine->open($images->url)->save($id.'.'.$type, $options);
                 Yii::$app->cache->set($id,$value);
                 return Html::img($value);
             }else{
                 $left_array = [];
                 $right_array = [];
                 for ($i=0;$i<9;$i++){
                     if($i<$array['0']){
                         $left_array[] =$i;
                     }else{
                         $right_array[]=$i;
                     }
                 }
                  $max = max($left_array);
                  $min = min($right_array);

                 if($array['0']-$max>$min-$array['0']){
                     return Html::img($min);
                 }else{
                     return Html::img($max);
                 }
             }
        }
    }
}
