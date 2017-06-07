<?php
namespace backend\libraries;


use common\models\Brand;
use common\models\BrandHot;
use Yii;

class BrandHotLib{
    /*
       查询所有热门品牌Brand_id
     */
    public static function getBrandHotIdArr()
    {
        $brand_hot_id_arr = [];
        $brand_hots = BrandHot::find()->asArray()->all();
        foreach ($brand_hots as $brand_hot)
        {
            $brand_hot_id_arr[] = $brand_hot['brand_id'];
        }
        return $brand_hot_id_arr;
    }

    //查询所有的品牌名
    public static function getBrandHotNameData(){

        $brand_name_arr =[];
        $brand_hots=BrandHot::find()->select('brand_id, brand_name')->asArray()->all();
        if(!empty($brand_hots)&&is_array($brand_hots)){
            foreach ($brand_hots as $brand_hot){
                $brand_name_arr[$brand_hot['brand_id']]=$brand_hot['brand_name'];
            }
        }

        return $brand_name_arr;
    }
  //更新新的品牌名
    public static function updateBrand($brand_ids)
    {
        $old_brand_id_arr = self::getBrandHotIdArr();
        $brand_id_arr = self::getUpdateBrandIdArr($brand_ids, $old_brand_id_arr);
        if (!empty($brand_id_arr) && is_array($brand_id_arr)) {
            BrandHot::deleteAll(['in', 'brand_id', $brand_id_arr['del']]);
        }
        if (!empty($brand_id_arr) && is_array($brand_id_arr['add'])) {
            $brands = Brand::find()->where(['in', 'id', $brand_id_arr['add']])->asArray()->all();
            $brand_arr = [];
            foreach ($brands as $key=>$brand) {
                $brand_hot['brand_id'] = $brand['id'];
                $brand_hot['logo_path'] = $brand['logo_path'];
                $brand_hot['order_no'] = $key+1;
                $brand_hot['brand_name'] = $brand['name_cn']?$brand['name_cn']:$brand['name_en'];
                $brand_arr[] = $brand_hot;
            }
            Yii::$app->db->createCommand()->batchInsert(BrandHot::tableName(), ['brand_id', 'logo_path', 'order_no', 'brand_name'], $brand_arr)->execute();

        }else{
            return false;
        }
        return true;
    }






    public static function getUpdateBrandIdArr($new_brand_id_arr,$old_brand_id_arr)
    {
        $temp_new_brand_id_arr = $new_brand_id_arr;
        $temp_old_brand_id_arr = $old_brand_id_arr;
        $brand_id_arr = [];
        if(empty($new_brand_id_arr)){
            $brand_id_arr['add'] = [];
            $brand_id_arr['del'] = $old_brand_id_arr;
        }elseif(empty($old_brand_id_arr)){
            $brand_id_arr['add'] = $new_brand_id_arr;
            $brand_id_arr['del'] = [];
        }else{
            foreach ($temp_new_brand_id_arr as $key => $new_brand_id)
            {
                if(in_array($new_brand_id,$temp_old_brand_id_arr)){
                    unset($new_brand_id_arr[$key]);
                }
            }
            foreach ($temp_old_brand_id_arr as $key => $old_brand_id)
            {
                if(in_array($old_brand_id,$temp_new_brand_id_arr)){
                    unset($old_brand_id_arr[$key]);
                }
            }
            $brand_id_arr['add'] = $new_brand_id_arr;
            $brand_id_arr['del'] = $old_brand_id_arr;
        }
        return $brand_id_arr;
    }


}



