<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_daily_log}}".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $type 1签到 2分享 3评论 4推荐新用户注册
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 0禁用1使用
 */
class UserDailyLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_daily_log}}';
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
            [['user_id', 'type', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
            'type' => 'Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
