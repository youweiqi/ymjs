<?php
namespace backend\libraries;

use common\models\Goods;
use common\models\GoodsSpecificationImages;
use common\models\Product;
use common\models\Specification;
use common\models\SpecificationDetail;

class SpecificationLib{
    /**
     * 新增商品时初始化商品规格数据
     * @param  integer $classify_id 分类ID
     * @param  integer $spec_id 规格ID
     * @return mixed
     */
    public static function initGoodsSpecDesc($classify_id,$spec_id)
    {
        $classify = Specification::find()->where(['id'=>$classify_id])->asArray()->one();
        $spec = Specification::find()->where(['id'=>$spec_id])->asArray()->one();
        $goods_spec_desc= [];
        if(!empty($classify) && is_array($classify)){
            $classify_desc['name'] = $classify['name'];
            $classify_desc['specificationId'] = $classify['id'];
            $classify_desc['value'][0]['specificationDetailImage'] = '';
            $classify_desc['value'][0]['specificationDetailId'] = '';
            $classify_desc['value'][0]['detailName'] = '';
            $goods_spec_desc[] = $classify_desc;
        }
        if(!empty($spec) && is_array($spec)){
            $spec_desc['name'] = $spec['name'];
            $spec_desc['specificationId'] = $spec['id'];
            $spec_desc['value'][0]['specificationDetailImage'] = '';
            $spec_desc['value'][0]['specificationDetailId'] = '';
            $spec_desc['value'][0]['detailName'] = '';
            $goods_spec_desc[] = $spec_desc;
        }
        return json_encode($goods_spec_desc,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 通过商品ID重新组织商品的规格数据
     * @param  integer $goods_id
     * @return mixed
     */
    public static function getGoodsSpecDesc($goods_id)
    {
        $temp_arr = $spec_detail_value_arr = [];
        $spec_id_arr = [];
        $goods_spec_desc = Goods::find()->select('spec_desc')->where('id=:gid',[':gid'=>$goods_id])->asArray()->one();
        $goods_spec_desc_arr = json_decode($goods_spec_desc['spec_desc'],true);
        foreach ($goods_spec_desc_arr as $key=>$value) {
            $spec_id_arr[$key] = $value['specificationId'];
        }
        $product_spec_infos = Product::find()->select('spec_info')->where('good_id=:gid',[':gid'=>$goods_id])->asArray()->all();
        foreach ($product_spec_infos as $product_spec_info)
        {
            $temp_arr[] = $product_spec_info['spec_info'];
        }
        $product_spec_info_str = implode('|',$temp_arr);
        $spec_detail_id_arr = array_unique(explode('|',$product_spec_info_str));
        $spec_details = SpecificationDetail::find()->where(['and',['in','specification_id',$spec_id_arr],['in','id',$spec_detail_id_arr]])->asArray()->all();
        $goods_specification_images = GoodsSpecificationImages::find()->where('good_id=:gid',[':gid'=>$goods_id])->andWhere(['in','specification_detail_id',$spec_detail_id_arr])->asArray()->all();
        foreach ($goods_specification_images as $goods_specification_image) {
            $goods_specification_image_arr[$goods_specification_image['specification_detail_id']] = $goods_specification_image;
        }

        foreach ($spec_details as $spec_detail) {
            $value_data['specificationDetailId'] = $spec_detail['id'];
            $value_data['detailName'] = $spec_detail['detail_name'];
            $value_data['specificationDetailImage'] = isset($goods_specification_image_arr[$spec_detail['id']])?$goods_specification_image_arr[$spec_detail['id']]['image_path']:'';
            $spec_detail_value_arr[$spec_detail['specification_id']][] = $value_data;
        }
        foreach ($goods_spec_desc_arr as $key => $goods_spec_desc) {
            $goods_spec_desc_arr[$key]['value'] = isset($spec_detail_value_arr[$goods_spec_desc['specificationId']])?$spec_detail_value_arr[$goods_spec_desc['specificationId']]:[['specificationDetailId'=>'','detailName'=>'','specificationDetailImage'=>'']];
        }
        return json_encode($goods_spec_desc_arr,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 获取根据规格id获取商品需要的规格
     * @param  integer $classify_id 分类ID
     * @param  integer $spec_id 规格ID
     * @return mixed
     */
    public static function geGoodSpecificationData($classify_id,$spec_id)
    {
        $classify = Specification::find()->where(['id'=>$classify_id])->asArray()->one();
        $spec = Specification::find()->where(['id'=>$spec_id])->asArray()->one();
        $classify_details = SpecificationDetail::find()->where(['specification_id'=>$classify_id])->asArray()->all();
        $spec_details = SpecificationDetail::find()->where(['specification_id'=>$spec_id])->asArray()->all();
        $goods_specification_data= [];
        if(!empty($classify) && is_array($classify)){
            $goods_specification_data[$classify['name']] = self::processGoodSpecification($classify_details);
        }
        if(!empty($spec) && is_array($spec)){
            $goods_specification_data[$spec['name']] = self::processGoodSpecification($spec_details);
        }
        return json_encode($goods_specification_data,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 获取根据规格id获取货品需要的规格
     * @param  integer $classify_detail_id 分类ID
     * @param  integer $spec_detail_id 规格ID
     * @return mixed
     */
    public static function getProductSpecificationData($classify_detail_id,$spec_detail_id)
    {
        $classify_detail = SpecificationDetail::find()->where(['id'=>$classify_detail_id])->asArray()->one();
        $spec_detail = SpecificationDetail::find()->where(['id'=>$spec_detail_id])->asArray()->one();
        $product_specification_data[] = self::processProductSpecification($classify_detail);
        $product_specification_data[] = self::processProductSpecification($spec_detail);
        return json_encode($product_specification_data,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 处理商品规格信息
     * @param  array $specifications
     * @return mixed
     */
    public static function processGoodSpecification($specifications)
    {
        $datas =[];
        if(!empty($specifications)){
            foreach ($specifications as $specification ){
                $data['detailName'] = $specification['detail_name'];
                $data['specificationDetailImage'] = '';
                $data['specificationDetailId'] = $specification['id'];
                $datas[] = $data;
            }
        }else{
            $data['detailName'] = '';
            $data['specificationDetailImage'] = '';
            $data['specificationDetailId'] = '';
            $datas[] = $data;
        }
        return $datas;
    }
    /**
     * 处理货品规格信息
     * @param  array $specification_detail
     * @return mixed
     */
    public static function processProductSpecification($specification_detail)
    {
        if(!empty($specification_detail) && is_array($specification_detail)){
            $data['specificationDetailId'] = $specification_detail['id'];
            $data['detailName'] = $specification_detail['detail_name'];
        }else{
            $data['specificationDetailId'] = '';
            $data['detailName'] = '';
        }
        return $data;
    }
    /**
     *
     * @param  integer $classify_detail_id
     * @param  integer $spec_detail_id
     * @return mixed
     */
    public static function getProductSpecNameData($classify_detail_id,$spec_detail_id)
    {
        $product_spec_name_data= '';
        $classify_detail = SpecificationDetail::find()->where(['id'=>$classify_detail_id])->asArray()->one();
        $spec_detail = SpecificationDetail::find()->where(['id'=>$spec_detail_id])->asArray()->one();
        $product_spec_name_data.= $classify_detail['detail_name'].' ';
        $product_spec_name_data .= $spec_detail['detail_name'];
        return $product_spec_name_data;
    }
}