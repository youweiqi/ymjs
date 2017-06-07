<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_promotion".
 *
 * @property int $id
 * @property int $promotion_detail_id 优惠券id
 * @property int $user_id 用户id
 * @property int $promotion_number 持有数量
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 0禁用1未使用  2已使用
 */
class UserPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_promotion';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_detail_id', 'user_id', 'promotion_number', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promotion_detail_id' => '优惠券id',
            'user_id' => '用户id',
            'promotion_number' => '持有数量',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用1未使用  2已使用',
        ];
    }

    public function getC_user()
    {
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }

    public function getPromotion_detail()
    {

        return $this->hasOne(PromotionDetail::className(),['id'=>'promotion_detail_id']);
    }
}
