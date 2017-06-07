<?php
namespace backend\libraries;

use common\models\Brand;
use common\models\Category;
use common\models\SerialBrand;

class SerialLib{

    public static function getBrandData($serial_id)
    {
        $serial_brand = SerialBrand::findOne(['serial_id'=>$serial_id]);
        if(isset($serial_brand->brand_id) && !empty($serial_brand->brand_id)){
            $brand = Brand::findOne($serial_brand->brand_id);
            return [
                'brand_id'=>$brand->id,
                'data' =>[$brand->id=>$brand->name_cn.'('.$brand->name_en.')'
                ]
            ];
        }else{
            return null;
        }
    }
}