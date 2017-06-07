<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%undefined_user}}".
 *
 * @property int $id
 * @property string $undefined_id 第三方id
 * @property int $undefined_type 第三方类型(1 qq,2 微信)
 * @property int $user_id 用户id
 */
class UndefinedUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%undefined_user}}';
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
            [['undefined_type', 'user_id'], 'integer'],
            [['undefined_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'undefined_id' => 'Undefined ID',
            'undefined_type' => 'Undefined Type',
            'user_id' => 'User ID',
        ];
    }
}
