<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%c_user_bank}}".
 *
 * @property int $id
 * @property int $user_id 店铺用户ID
 * @property int $bank_id 银行ID
 * @property string $bank_name
 * @property string $name 开户人名称
 * @property string $bank_card 银行卡帐号
 * @property string $bank_branch_name 开户行支行
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 0禁用1使用
 */
class CUserBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%c_user_bank}}';
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
            [['user_id', 'bank_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['bank_name', 'name', 'bank_card'], 'string', 'max' => 255],
            [['bank_branch_name'], 'string', 'max' => 100],
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
            'bank_id' => 'Bank ID',
            'bank_name' => 'Bank Name',
            'name' => 'Name',
            'bank_card' => 'Bank Card',
            'bank_branch_name' => 'Bank Branch Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
