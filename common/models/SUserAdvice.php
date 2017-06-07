<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_user_advice}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $title 标题
 * @property string $content 反馈内容
 * @property string $contact_way 联系方式
 * @property string $create_time 创建时间
 */
class SUserAdvice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_user_advice}}';
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
            [['user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['content'], 'string', 'max' => 2000],
            [['contact_way'], 'string', 'max' => 32],
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
            'title' => 'Title',
            'content' => 'Content',
            'contact_way' => 'Contact Way',
            'create_time' => 'Create Time',
        ];
    }
}
