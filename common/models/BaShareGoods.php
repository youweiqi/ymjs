<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ba_share_goods".
 *
 * @property integer $id
 * @property integer $ba_user_id
 * @property integer $good_id
 */
class BaShareGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.ba_share_goods';
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
            [['ba_user_id', 'good_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ba_user_id' => '商户通用户id',
            'good_id' => '商品id',
        ];
    }
}
