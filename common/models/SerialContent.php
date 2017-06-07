<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "serial_content".
 *
 * @property integer $id
 * @property integer $serial_id
 * @property string $image_path
 * @property integer $order_no
 * @property integer $jump_style
 * @property string $jump_to
 * @property integer $img_width
 * @property integer $img_height
 */
class SerialContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.serial_content';
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
            [['serial_id', 'order_no', 'jump_style', 'img_width', 'img_height'], 'integer'],
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
            'serial_id' => '期资讯',
            'image_path' => '图片',
            'order_no' => '排序',
            'jump_style' => '图片跳转方式',
            'jump_to' => 'Jump To',
            'img_width' => '图片宽度',
            'img_height' => '图片高度',
        ];
    }
    public static function dropDown($column,$value=null)
    {
        $dropDownList=[
            'jump_style'=>[
                '1'=>'不跳转',
                '2'=>'商品详情',
                '3'=>'跳转到微商城',
                '4'=>'其他期资讯'
            ]
        ];
        if ($value!==null){
            return array_key_exists($column,$dropDownList)? $dropDownList[$column][$value]:false;
        }else{
            return array_key_exists($column,$dropDownList)? $dropDownList[$column]:false;
        }
    }
}
