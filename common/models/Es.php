<?php

namespace common\models;
use yii\elasticsearch\ActiveRecord;
class Es extends ActiveRecord
{
    /**
     * @inheritdoc
     * Es 查询处理类
     * index方法是索引
     */
    public static function index()
    {
        return [
            'yg_goods',
            'yg_product',
            'yg_brand'
        ];
    }
    /*
     * Es 的type
     */
    public static function type()
    {
        return [
            'goods',
            'product',
            'brand'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'id' ,
            'name',
            'label',
            'good_code'
        ];
    }
}
