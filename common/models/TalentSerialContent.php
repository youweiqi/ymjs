<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "talent_serial_content".
 *
 * @property integer $id
 * @property integer $talent_serial_id
 * @property string $image_path
 * @property integer $order_no
 * @property integer $jump_style
 * @property string $jump_to
 * @property integer $img_width
 * @property integer $img_height
 */
class TalentSerialContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.talent_serial_content';
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
            [['talent_serial_id', 'order_no', 'jump_style', 'img_width', 'img_height'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['jump_to'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'talent_serial_id' => '达人期咨询id',
            'image_path' => '图片路径',
            'order_no' => '排序（从小到大排序）',
            'jump_style' => '图片跳转方式（1不跳转，2跳转到商品详情页，3跳转到H5，4跳转到另一期的详情页）',
            'jump_to' => '跳转到的期ID、商品ID、URL',
            'img_width' => 'Img Width',
            'img_height' => 'Img Height',
        ];
    }
}
