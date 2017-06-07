<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "talent_serial".
 *
 * @property integer $id
 * @property string $title
 * @property string $label_name
 * @property string $image_path
 * @property integer $like_count
 * @property integer $see_count
 * @property integer $comment_count
 * @property integer $share_count
 * @property integer $talent_id
 * @property string $create_time
 * @property integer $status
 */
class TalentSerial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.talent_serial';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['like_count', 'see_count', 'comment_count', 'share_count', 'talent_id', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['title', 'label_name', 'image_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id 标识id',
            'title' => '标题',
            'label_name' => '副标题',
            'image_path' => '封面图',
            'like_count' => '喜欢数',
            'see_count' => '浏览数',
            'comment_count' => '评论数',
            'share_count' => '分享数',
            'talent_id' => '创建者id（达人用户id）',
            'create_time' => '创建时间',
            'status' => '状态（0禁用，1启用）',
        ];
    }
}
