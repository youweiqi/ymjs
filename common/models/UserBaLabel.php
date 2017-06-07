<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_ba_label}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $ba_user_id 店员id
 * @property int $label_id 标签id
 */
class UserBaLabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_ba_label}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_ba_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ba_user_id', 'label_id'], 'integer'],
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
            'ba_user_id' => 'Ba User ID',
            'label_id' => 'Label ID',
        ];
    }
}
