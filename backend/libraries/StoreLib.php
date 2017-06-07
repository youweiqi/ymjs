<?php
namespace backend\libraries;


use common\models\Store;

class StoreLib
{
    public static function getStoreName($store_id)
    {
        $brand = Store::findOne($store_id);
        if(!empty($brand)){
          return  $store_name = $brand->store_name;
        }

    }

}