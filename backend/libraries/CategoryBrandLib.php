<?php
namespace backend\libraries;

use common\models\CategoryBrand;
use Yii;
use common\models\Category;
use common\models\StoreBrand;

class CategoryBrandLib{

    /**
     * 保存品牌关联分类
     * @param  integer $parent_ids  品牌ID数组
     * @param  integer $brand_id   店铺ID
     * @return mixed
     */
    public static function saveCategoryBrand($parent_ids,$brand_id)
    {
        $category_brand_arr =[];
        if(!empty($parent_ids) && is_array($parent_ids)){
            foreach ($parent_ids as $category_parent_id)
            {
                $category_brand['brand_id'] = $brand_id;
                $category_brand['category_parent_id'] = $category_parent_id;
                $category_brand['category_id']=0;
                $category_brand_arr[] = $category_brand;
                $category_brand = [];
            }
            Yii::$app->db->createCommand()->batchInsert(CategoryBrand::tableName(), ['brand_id','category_parent_id','category_id'], $category_brand_arr)->execute();
        }
        return true;
    }
    /**
     * 更新品牌关联分类
     * @param  array $parent_ids  品牌ID数组
     * @param  integer $brand_id   店铺ID
     * @return mixed
     **/
    public static function updateBrandCategory($parent_ids,$brand_id)
    {
        $old_category_id_arr = self::getCategoryBrandIdArr($brand_id);
        $category_id_arr = self::getUpdateBrandIdArr($parent_ids,$old_category_id_arr);

        if(!empty($category_id_arr) && is_array($category_id_arr)){
            CategoryBrand::deleteAll(
                ['in', 'category_parent_id', $category_id_arr['del']]);
        }
        if(!empty($category_id_arr) && is_array($category_id_arr['add'])){
            $category_brand_arr = [];
            foreach ($category_id_arr['add'] as $category_parent_id)
            {
                $category_brand['brand_id'] = $brand_id;
                $category_brand['category_parent_id'] = $category_parent_id;
                $category_brand['category_id']=0;

                $category_brand_arr[] = $category_brand;
                $category_brand = [];
            }
            Yii::$app->db->createCommand()->batchInsert( CategoryBrand::tableName(), ['brand_id','category_parent_id','category_id'], $category_brand_arr)->execute();
        }else{
            return false;
        }
        return true;
    }
    /**
     * 通过新旧ID数组获取需要删除和增加的ID数组
     * @param  array $new_category_id_arr 新brand_id数组
     * @param  array $old_category_id_arr 原来brand_id数组
     * @return mixed
     */
    public static function getUpdateBrandIdArr($new_category_id_arr,$old_category_id_arr)
    {
        $temp_new_category_id_arr = $new_category_id_arr;
        $temp_old_category_id_arr = $old_category_id_arr;
        $category_id_arr = [];
        if(empty($new_category_id_arr)){
            $category_id_arr['add'] = [];
            $category_id_arr['del'] = $old_category_id_arr;
        }elseif(empty($old_category_id_arr)){
            $category_id_arr['add'] = $new_category_id_arr;
            $category_id_arr['del'] = [];
        }else{
            foreach ($temp_new_category_id_arr as $key => $new_category_id)
            {
                if(in_array($new_category_id,$temp_old_category_id_arr)){
                    unset($new_category_id_arr[$key]);
                }
            }
            foreach ($temp_old_category_id_arr as $key => $old_category_id)
            {
                if(in_array($old_category_id,$temp_new_category_id_arr)){
                    unset($old_category_id_arr[$key]);
                }
            }
            $category_id_arr['add'] = $new_category_id_arr;
            $category_id_arr['del'] = $old_category_id_arr;
        }
        return $category_id_arr;
    }
    /**
     * 通过品牌ID获取category_brand_data
     * @param  integer $brand_id
     * @return mixed
     */
    public static function getCategoryBrandData($brand_id)
    {
        $category_brand_data =[];
        $category_brands =CategoryBrand::find()->where('brand_id=:bid',[':bid'=>$brand_id])->asArray()->all();
        if(!empty($category_brands) && is_array($category_brands)){
            $category_id_arr = [];
            foreach ($category_brands as $category_brand){
                $category_id_arr[] = $category_brand['category_parent_id'];
            }
            $category = Category::find()->select('id,name')->where(['in','id',$category_id_arr])->asArray()->all();
            if (!empty($category) && is_array($category)){
                foreach ($category as $cate)
                {
                    $category_brand_data[$cate['id']] = $cate['name'];
                }
            }
        }
        return $category_brand_data;
    }
    /**
     *
     * @param  integer $brand_id
     * @return mixed
     * 根据品牌ID去查询所有该品牌下的分类信息
     *
     */
    public static function getCategoryBrandIdArr($brand_id)
    {
        $brand_category_id_arr = [];
        $brand_category = CategoryBrand::find()->where('brand_id=:sid',[':sid'=>$brand_id])->asArray()->all();
        foreach ($brand_category as $brand_cate)
        {
            $brand_category_id_arr[] = $brand_cate['category_parent_id'];
        }
        return $brand_category_id_arr;
    }

}