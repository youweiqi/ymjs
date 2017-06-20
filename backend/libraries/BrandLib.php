<?php
namespace backend\libraries;


use common\models\Brand;
use yii\helpers\ArrayHelper;

class BrandLib
{
    public static function getBrandName($brand_id)
    {
        $brand = Brand::findOne($brand_id);
        if(isset($brand->name_cn) && !empty($brand->name_cn)){
            $brand_name = $brand->name_cn;
        }else{
            $brand_name = $brand->name_en;
        }
        return $brand_name;
    }

    public static function getBrand()
    {
        $categories = Brand::find()->where(['status'=>1])->asArray()->all();
        return $categories;
    }

    public static function getBrandId($brandName)
    {
        $brand = Brand::find()->where(['or',['like','name_en',$brandName],['like','name_cn',$brandName]])->asArray()->all();
        $brandIdArr = ArrayHelper::getColumn($brand,'id');
        return $brandIdArr;
    }

}