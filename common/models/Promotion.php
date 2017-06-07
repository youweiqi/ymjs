<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promotion".
 *
 * @property integer $id
 * @property string $name
 * @property string $descripe
 * @property string $creater
 * @property integer $belong_user_id
 * @property string $create_time
 * @property integer $status
 */
class Promotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.promotion';
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
            [['descripe'], 'string'],
            [['belong_user_id', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['creater'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '优惠礼包名称',
            'descripe' => '描述',
            'creater' => '添加人',
            'belong_user_id' => '激活码礼包归属人ID',
            'create_time' => '创建时间',
            'status' => '状态',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
