<?php
namespace common\libraries;


use Yii;

class ImageLib
{
    /*
       查询所有热门品牌Brand_id
     */
    public static function getDefaultImg($image_path)
    {
        $default_img_path = Yii::getAlias('@web/statics/images/default/600_400.png');
        if(!empty($image_path)){
            $default_img_path = $image_path;
        }
        return $default_img_path;
    }

}



