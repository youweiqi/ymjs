<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%talent_active_log}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $redeem_code 兑换码id
 * @property int $active_money 消费金额
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 0禁用1使用
 */
class TalentActiveLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talent_active_log}}';
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
            [['user_id', 'active_money', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['redeem_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'redeem_code' => 'Redeem Code',
            'active_money' => 'Active Money',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
