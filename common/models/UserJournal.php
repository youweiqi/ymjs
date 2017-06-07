<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_journal}}".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property string $order_sn 订单号
 * @property int $promotion_detail_id 优惠券id
 * @property int $money 金额
 * @property string $type 收支类型区分，+是收入，-是支出
 * @property int $bank_id 用户银行卡id
 * @property string $comment 备注
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 状态(0禁用,1推荐分佣,2分佣,3提款中,4提款成功,5提款失败,6系统返还,7订单消费，8其他消费，9系统奖励)
 * @property int $mall_store_id
 */
class UserJournal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_user.user_journal';
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
            [['user_id', 'promotion_detail_id', 'money', 'bank_id', 'status', 'mall_store_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 10],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'order_sn' => '订单号',
            'promotion_detail_id' => '优惠券id',
            'money' => '金额',
            'type' => '收支类型',
            'bank_id' => '用户银行卡id',
            'comment' => '备注',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
            'mall_store_id' => 'Mall Store ID',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'推荐分佣',
                '2'=>'分佣',
                '3'=>'提款中',
                '4'=>'提款成功',
                '5'=>'拒绝提款',
                '6'=>'系统返还',
                '7'=>'订单消费',
                '8'=>'其他消费',
                '9'=>'系统奖励'
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }


    public function getC_user(){
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getC_user_bank(){
        return $this->hasOne(CUserBank::className(),['id'=>'bank_id']);
    }
}
