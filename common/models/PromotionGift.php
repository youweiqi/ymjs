<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promotion_gift".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $promotion_id
 */
class PromotionGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.promotion_gift';
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
            [['type', 'promotion_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '赠送的礼包类型(1-付费会员赠送礼包；2-新用户赠送礼包）',
            'promotion_id' => '礼包ID',
        ];
    }
}
