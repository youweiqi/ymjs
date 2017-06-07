<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "share_goods".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $good_id
 * @property integer $agio
 */
class ShareGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.share_goods';
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
            [['user_id', 'good_id', 'agio'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '达人id',
            'good_id' => '商品id',
            'agio' => '折扣  1 无佣   2半佣   3 全拥',
        ];
    }
}
