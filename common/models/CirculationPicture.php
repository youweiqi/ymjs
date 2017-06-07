<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "circulation_picture".
 *
 * @property integer $id
 * @property integer $type
 * @property string $activity
 * @property string $image
 * @property integer $status
 * @property integer $order_no
 */
class CirculationPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_system.circulation_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'order_no'], 'integer'],
            [['activity', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '轮播类型',
            'activity' => '活动',
            'image' => '图片地址',
            'status' => '状态',
            'order_no' => '排序',
        ];
    }

    public static function dropDown($column, $value = null)
    {
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
            'type'=> [
                '0'=>'无',
                '1'=>'商品',
                '2'=>'资讯',
                '3'=>'其他',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
