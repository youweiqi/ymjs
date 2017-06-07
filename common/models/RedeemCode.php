<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%redeem_code}}".
 *
 * @property int $id
 * @property string $redeem_code 兑换码
 * @property int $type 兑换码类型（1、优惠券，2、达人）
 * @property int $usable_times 可用次数
 * @property int $used_times 已使用次数
 * @property int $promotion_id 优惠礼包id
 * @property string $creater 添加人
 * @property string $start_date 开始日期
 * @property string $end_date 结束日期
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property string $remark 备注
 * @property int $status 0禁用1使用
 */
class RedeemCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%redeem_code}}';
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
            [['type', 'usable_times', 'used_times', 'promotion_id', 'status'], 'integer'],
            [['remark','start_date', 'end_date', 'create_time', 'update_time'], 'safe'],
            [['redeem_code'], 'string', 'max' => 255],
            [['creater'], 'string', 'max' => 50],
            [['redeem_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'redeem_code' => '兑换码',
            'type' => '兑换码类型',
            'usable_times' => '可用次数',
            'used_times' => '已使用次数',
            'promotion_id' => '优惠礼包id',
            'creater' => '添加人',
            'start_date' => '开始日期',
            'end_date' => '结束日期',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
            'name'=>'优惠礼包',
            'remark'=>'备注'

        ];
    }

    public function getPromotion(){
        return $this->hasOne(Promotion::className(),['id'=>'promotion_id']);
    }

}
