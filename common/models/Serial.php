<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "serial".
 *
 * @property integer $id
 * @property string $online_time
 * @property string $offline_time
 * @property string $title
 * @property string $label_name
 * @property string $cover_imgpath
 * @property string $freerate
 * @property integer $like_count
 * @property integer $see_count
 * @property integer $share_count
 * @property integer $comment_count
 * @property integer $category_id
 * @property integer $is_recommend
 * @property integer $is_display
 * @property string $wx_big_imgpath
 * @property string $wx_small_imgpath
 * @property integer $cover_imgwidth
 * @property integer $cover_imgheight
 * @property integer $type
 * @property string $create_time
 * @property integer $status
 * @property integer $jump_style
 * @property integer $jump_to
 */
class Serial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.serial';
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
            [['online_time', 'offline_time','jump_style'], 'required'],
            [['online_time', 'offline_time', 'create_time','jump_to'], 'safe'],
            [['like_count', 'see_count', 'share_count', 'comment_count', 'category_id', 'is_recommend', 'is_display', 'cover_imgwidth', 'cover_imgheight', 'type', 'status'], 'integer'],
            [['title', 'label_name', 'cover_imgpath', 'freerate', 'wx_big_imgpath', 'wx_small_imgpath'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'online_time' => '上线时间',
            'offline_time' => '下线时间',
            'title' => '标题',
            'label_name' => '别名',
            'cover_imgpath' => '封面图',
            'freerate' => '免单率',
            'like_count' => '喜欢数',
            'see_count' => '浏览数',
            'share_count' => '分享数',
            'comment_count' => '评论数',
            'category_id' => '品牌分类id',
            'is_recommend' => '是否推荐',
            'is_display' => '显示',
            'wx_big_imgpath' => '微信大图链接',
            'wx_small_imgpath' => '微信小图链接',
            'cover_imgwidth' => '封面图宽度',
            'cover_imgheight' => '封面图高度',
            'type' => '所属类型 ',
            'create_time' => '创建时间',
            'status' => '状态',
            'jump_style'=>'期类型',
            'jump_to' => '期活动内容'
        ];
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id'])
            ->viaTable('serial_brand', ['serial_id' => 'id']);
    }

    public static function getSerialTitleById($serial_id)
    {
        $serial = self::find()->where('id = :sid', [':sid' => $serial_id])->one();
        return $serial ? $serial['title'] : $serial_id;
    }
}
