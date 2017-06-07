<?php
namespace backend\libraries;

use common\models\Inventory;
use common\models\Product;
use common\models\SpecificationDetail;
use Yii;


class ProductLib{
    public static function getSpecificationDetailIds($specification_detail_id){
        $specification_detail_arr = SpecificationDetail::find()->where(['specification_id'=>$specification_detail_id])->asArray()->all();
        return $specification_detail_arr;
    }
    /**
     * 获取货品规格明细ID数组
     * @param  string $spec_info
     * @return mixed
     */
    public static function getProductSpecDetailIds($spec_info)
    {
        $product_spec_detail_id_arr = [0=>'',1=>''];
        if(!empty($spec_info)){
            $product_spec_detail_id_arr = explode('|',$spec_info);
        }
        return $product_spec_detail_id_arr;
    }

    public static function processProductData($goods_id,$product_data)
    {
        $products = [];
        foreach ($product_data as $product_info)
        {
            $spec_desc = json_encode([
                [
                    'specificationDetailId'=>$product_info['classifyDetailId'],
                    'detailName'=>$product_info['classifyDetailName'],
                ],
                [
                    'specificationDetailId'=>$product_info['specDetailId'],
                    'detailName'=>$product_info['specDetailName'],
                ]
            ],JSON_UNESCAPED_UNICODE);
            $product['goods_id'] = $goods_id;
            $product['spec_info'] = $product_info['classifyDetailId'].','.$product_info['specDetailId'];
            $product['spec_desc'] = $spec_desc;
            $product['spec_name'] = $product_info['classifyDetailName'].' '.$product_info['specDetailName'];
            $product['bar_code'] = $product_info['barCode'];
            $product['product_bn'] = $product_info['productBn'];
            $product['status'] = $product_info['status'];
            $products[] = $product;
            unset($product,$spec_desc);
        }
        Yii::$app->db->createCommand()->batchInsert(Product::tableName(), ['goods_id','spec_info','spec_desc','spec_name','bar_code','product_bn','status'], $products)->execute();
        return true;
    }

    public static function updateProductData($goods_id,$product_data)
    {
        //error_log(var_export($product_data,true), 3, "/data/logs/product_data".time().".log");

        $products = Product::find()->where(['=', 'goods_id', $goods_id])->asArray()->all();
        $id_spec_desc = [];
        foreach ($products as $product)
        {
            $id_spec_desc[$product['id']] = $product['spec_info'];
            unset($product);
        }
        $product_arr = $update_ids = [];
        foreach ($product_data as $product_info)
        {
            $spec_key = $product_info['classifyDetailId'].','.$product_info['specDetailId'];
            if(in_array($spec_key, $id_spec_desc)){
                $product_id = array_search($spec_key, $id_spec_desc);
                Product::updateAll(['product_bn'=>$product_info['productBn'],'bar_code'=>$product_info['barCode'],'status'=>$product_info['status'],'is_del'=>0],['id'=>$product_id]);
                $update_ids[] = $product_id;
            }else{
                $spec_desc = json_encode([
                    [
                        'specificationDetailId'=>$product_info['classifyDetailId'],
                        'detailName'=>$product_info['classifyDetailName'],
                    ],
                    [
                        'specificationDetailId'=>$product_info['specDetailId'],
                        'detailName'=>$product_info['specDetailName'],
                    ]
                ],JSON_UNESCAPED_UNICODE);
                $product['goods_id'] = $goods_id;
                $product['spec_info'] = $product_info['classifyDetailId'].','.$product_info['specDetailId'];
                $product['spec_desc'] = $spec_desc;
                $product['spec_name'] = $product_info['classifyDetailName'].' '.$product_info['specDetailName'];
                $product['bar_code'] = $product_info['barCode'];
                $product['product_bn'] = $product_info['productBn'];
                $product['is_del'] = 0;
                $product['status'] = $product_info['status'];
                $product_arr[] = $product;
                unset($product,$spec_desc);
            }
        }
        $product_ids = array_keys($id_spec_desc);
        $del_ids = array_diff($product_ids, $update_ids);
        self::delProductByIds($del_ids);
        Yii::$app->db->createCommand()->batchInsert(Product::tableName(), ['goods_id','spec_info','spec_desc','spec_name','bar_code','product_bn','is_del','status'], $product_arr)->execute();
        return true;
    }
    /**
     * 通过货品的ID数组删除对应的货品信息（仅仅是逻辑上的删除：将is_del设置为1，status设置为0）.
     * @param  array $ids
     * @return mixed
     */
    public static function delProductByIds($ids)
    {
        if(is_array($ids) && !empty($ids)){
            Product::updateAll(['is_del'=>1,'status'=>0],['id'=>$ids]);
        }
        return true;
    }
}