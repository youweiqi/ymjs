<?php

namespace backend\modules\goods\models\form;

use Yii;
use yii\base\Model;

/**
 *
 */
class GoodsForm extends Model
{
    public $goods_id;
    public $classify_id;
    public $classify_name;
    public $spec_id;
    public $spec_name;
    //[['classify_detail_id'=>100,'classify_detail_name'=>'白色','classify_detail_image'=>'baise.png'],[...]]
    public $classify_details;
    //[['spec_detail_id'=>200,'spec_detail_name'=>'XL'],[...]]
    public $spec_details;
    //[['product_id'=>1,'classify_detail_name'=>'白色','classify_detail_id'=>100,'spec_detail_id'=>200,'spec_detail_name'=>'XL','product_bn'=>'test','bar_code'=>'test','status'=>1],[...]]
    public $products;
    //[['goods_navigate_id'=>10,'goods_navigate'=>'base64的数据'],[...]]
    public $goods_navigates;
    //[['goods_detail_id'=>10,'goods_detail'=>'base64的数据'],[...]]
    public $goods_details;


    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'classify_id' => '商品分类ID',
            'classify_name' => '商品分类名称',
            'spec_id' => '商品规格ID',
            'spec_name' => '商品规格名称',
            'classify_details' => '商品分类值',
            'spec_details' => '商品规格值',
            'products' => '货品信息',
            'goods_navigates' => '商品轮播图',
            'goods_details' => '商品明细',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id','classify_id','classify_name','spec_id','spec_name','classify_details','spec_details','products','goods_navigates','goods_details'], 'safe'],
        ];
    }
}
