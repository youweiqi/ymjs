<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%redeem_code_log}}".
 *
 * @property int $id
 * @property int $redeem_code_id 兑换码id
 * @property int $user_id 用户id
 * @property string $create_time 创建时间
 */
class RedeemCodeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%redeem_code_log}}';
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
            [['redeem_code_id', 'user_id'], 'integer'],
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
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
            'user_name'=>'用户手机号',
            'redeem_code'=>'兑换码'
        ];
    }

    public function getC_user(){

        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getRedeem_code(){

        return $this->hasOne(RedeemCode::className(),['id'=>'redeem_code_id']);
    }
}
