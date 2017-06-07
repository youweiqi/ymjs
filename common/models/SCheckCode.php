<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_check_code}}".
 *
 * @property int $id
 * @property string $mobile 手机号
 * @property string $code 验证码
 * @property int $type type(1:注册类型 2：找回密码)
 * @property string $create_time 创建时间
 */
class SCheckCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_check_code}}';
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
            [['type'], 'integer'],
            [['create_time'], 'safe'],
            [['mobile'], 'string', 'max' => 11],
            [['code'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'code' => 'Code',
            'type' => 'Type',
            'create_time' => 'Create Time',
        ];
    }
}
