<?php

namespace api\modules\v1\controllers;

use api\models\Images;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
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
        $image = Images::findOne($image_id);
        if(!empty($image)){
            if(strpos($_SERVER['HTTP_ACCEPT'],'image/webp')===false)
            {
                $img = $image->url;
            }else{
                $img = $image->m_url;//假设这个值是webp格式的图片
            }
            $array = [
                'url'=>$img
            ];
            return $array;
        }



    }


}
