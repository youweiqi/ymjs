<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_goods_freight".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $good_id
 * @property integer $freight_template_id
 */
class StoreGoodsFreight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_goods_freight';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'good_id', 'freight_template_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '门店id',
            'good_id' => '商品id',
            'freight_template_id' => '运费模板id',
        ];
    }
    public function getStore(){
        return $this->hasOne(Store::className(),['id'=>'store_id']);
    }
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'good_id']);
    }
    public function getFreight_template(){
        return $this->hasOne(FreightTemplate::className(),['id'=>'freight_template_id']);
    }
}
