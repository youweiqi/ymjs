<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%bank}}".
 *
 * @property int $id
 * @property string $bank_name 银行名称
 * @property string $icon 银行图标
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 0禁用1使用
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bank}}';
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
            [['create_time', 'update_time'], 'safe'],
            [['status'], 'integer'],
            [['bank_name'], 'string', 'max' => 32],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
            'icon' => 'Icon',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
