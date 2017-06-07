<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_fans}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $talent_id 达人id
 * @property string $create_time 关注时间
 */
class UserFans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_fans}}';
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
            [['user_id', 'talent_id'], 'integer'],
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
            'user_id' => 'User ID',
            'talent_id' => 'Talent ID',
            'create_time' => 'Create Time',
        ];
    }
}
