<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_commission".
 *
 * @property integer $id
 * @property integer $good_id
 * @property integer $role_id
 * @property integer $commission
 * @property integer $indirect_commission
 */
class GoodsCommission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_commission';
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
            [['good_id', 'role_id', 'commission', 'indirect_commission'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_id' => '商品id',
            'role_id' => '角色id',
            'commission' => '分佣',
            'indirect_commission' => '间接分佣',
        ];
    }

    public function getC_role()
    {
        return $this->hasOne(CRole::className(),['id'=>'role_id']);
    }
}
