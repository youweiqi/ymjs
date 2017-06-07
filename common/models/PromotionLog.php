<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promotion_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $store_id
 * @property integer $promotion_detail_id
 * @property integer $draw_channel
 * @property string $create_time
 */
class PromotionLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.promotion_log';
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
            [['user_id', 'store_id', 'promotion_detail_id', 'draw_channel'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户Id',
            'store_id' => '店铺ID',
            'promotion_detail_id' => '优惠劵Detail的ID',
            'draw_channel' => '领用渠道  1兑换码;  2签到; 3付费会员获得礼包; 4店员或店长分发然后用户自己领取;',
            'create_time' => '创建时间',
        ];
    }
}
