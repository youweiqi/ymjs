<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "push_message".
 *
 * @property integer $id
 * @property integer $is_all
 * @property integer $user_id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property integer $is_read
 * @property integer $tag
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class PushMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_system.push_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_all', 'user_id', 'type', 'is_read', 'tag', 'status'], 'integer'],
            [['content'], 'string'],
            [['tag'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_all' => '是否推送全部  1是  0否',
            'user_id' => '如果  is_all 为 0 必输  设置推送用户id',
            'type' => '0系统消息 1钱包消息 2物流消息',
            'title' => '必输  消息标题',
            'content' => '必输  消息内容',
            'is_read' => '0未阅读  1阅读',
            'tag' => '组别（店铺id）',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用  1待发送  2已发送  3发送失败',
        ];
    }
}
