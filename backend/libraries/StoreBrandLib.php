<?php
namespace backend\libraries;

use Yii;
use common\models\Brand;
use common\models\StoreBrand;

class StoreBrandLib{
    public static function getStoreBrands($store_id){
        $brands_str = '';
        $brand_name_arr = [];
        $brands_arr = StoreBrand::find()->select('store_brand.brand_id,brand.name_cn,brand.name_en')->joinWith(['brand'])->where('store_brand.store_id=:sid',[':sid'=>$store_id])->asArray()->all();
        if (!empty($brands_arr) && is_array($brands_arr)){
            foreach ($brands_arr as $brand){
                $brand_name_arr[] = empty($brand['name_cn'])?$brand['name_en']:$brand['name_cn'];
            }
            $brands_str = implode(',',$brand_name_arr);
        }
        return $brands_str;
    }
    /**
     * 保存店铺关联品牌
     * @param  integer $brand_ids  品牌ID数组
     * @param  integer $store_id   店铺ID
     * @return mixed
     */
    public static function saveStoreBrand($brand_ids,$store_id)
    {
        $store_brand_arr =[];
        if(!empty($brand_ids) && is_array($brand_ids)){
            foreach ($brand_ids as $brand_id)
            {
                $store_brand['brand_id'] = $brand_id;
                $store_brand['store_id'] = $store_id;
                $store_brand_arr[] = $store_brand;
                $store_brand = [];
            }
            Yii::$app->db->createCommand()->batchInsert(StoreBrand::tableName(), ['brand_id','store_id'], $store_brand_arr)->execute();
        }
        return true;
    }
    /**
     * 更新店铺关联品牌
     * @param  array $brand_ids  品牌ID数组
     * @param  integer $store_id   店铺ID
     * @return mixed
     */
    public static function updateStoreBrand($brand_ids,$store_id)
    {
        $old_brand_id_arr = self::getStoreBrandIdArr($store_id);
        $brand_id_arr = self::getUpdateBrandIdArr($brand_ids,$old_brand_id_arr);
        if(!empty($brand_id_arr) && is_array($brand_id_arr)){
            StoreBrand::deleteAll([ 'and', 'store_id = :sid',
                ['in', 'brand_id', $brand_id_arr['del']]
            ],
                [ ':sid' => $store_id]
            );
        }
        if(!empty($brand_id_arr) && is_array($brand_id_arr['add'])){
            $store_brand_arr = [];
            foreach ($brand_id_arr['add'] as $brand_id)
            {
                $store_brand['brand_id'] = $brand_id;
                $store_brand['store_id'] = $store_id;
                $store_brand_arr[] = $store_brand;
                $store_brand = [];
            }
            Yii::$app->db->createCommand()->batchInsert(StoreBrand::tableName(), ['brand_id','store_id'], $store_brand_arr)->execute();
        }else{
            return false;
        }
        return true;
    }
    /**
     * 通过新旧ID数组获取需要删除和增加的ID数组
     * @param  array $new_brand_id_arr 新brand_id数组
     * @param  array $old_brand_id_arr 原来brand_id数组
     * @return mixed
     */
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
    /**
     * 通过店铺ID获取store_brand_data
     * @param  integer $store_id
     * @return mixed
     */
    public static function getStoreBrandData($store_id)
    {
        $store_brand_data = [];
        $store_brands = StoreBrand::find()->where('store_id=:sid',[':sid'=>$store_id])->asArray()->all();
        if(!empty($store_brands) && is_array($store_brands)){
            $brand_id_arr = [];
            foreach ($store_brands as $store_brand){
                $brand_id_arr[] = $store_brand['brand_id'];

            }
            $brands = Brand::find()->select('id,name_cn,name_en')->where(['in','id',$brand_id_arr])->asArray()->all();
            if (!empty($brands) && is_array($brands)){
                foreach ($brands as $brand)
                {
                    $store_brand_data[$brand['id']] = $brand['name_cn'].'('.$brand['name_en'].')';

                }
            }
        }
        return $store_brand_data;
    }
    /**
     * 通过$store_id获取其ID数组
     * @param  integer $store_id
     * @return mixed
     * 根据门店ID去查询所有该门店下的品牌信息
     *
     */
    public static function getStoreBrandIdArr( $store_id)
    {
        $store_brand_id_arr = [];
        $store_brands = StoreBrand::find()->where('store_id=:sid',[':sid'=>$store_id])->asArray()->all();
        foreach ($store_brands as $store_brand)
        {
            $store_brand_id_arr[] = $store_brand['brand_id'];
        }
        return $store_brand_id_arr;
    }

}