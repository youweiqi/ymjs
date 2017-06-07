<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%app_secret}}".
 *
 * @property int $id
 * @property string $app_key
 * @property string $secret
 * @property string $platform_name
 * @property int $money 金额
 * @property int $line_of_credit 授信额度
 * @property string $create_time
 * @property string $update_time
 */
class AppSecret extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_secret}}';
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
            [['app_key', 'secret', 'platform_name'], 'required'],
            [['money', 'line_of_credit'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['app_key', 'secret'], 'string', 'max' => 32],
            [['platform_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_key' => 'App Key',
            'secret' => 'Secret',
            'platform_name' => 'Platform Name',
            'money' => 'Money',
            'line_of_credit' => 'Line Of Credit',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
