<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $en_name
 * @property string $ico_path
 * @property integer $order_no
 * @property integer $parent_id
 * @property integer $deep
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
     const STATUS = [
        '0'=>'禁用',
        '1'=>'启用',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.category';
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
            [['order_no', 'parent_id', 'deep', 'status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['en_name'], 'string', 'max' => 50],
            [['ico_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'en_name' => '分类英文名称',
            'ico_path' => '小图标图片路径',
            'order_no' => '排序',
            'parent_id' => '父类ID',
            'deep' => '几级分类',
            'status' => '状态',
        ];
    }

    public static function getCategoryNameById($id)
    {
        $category = self::findOne($id);
        return $category?$category['name']:$id;
    }

    public static function dropDown($column,$value=null)
    {
        $dropDownList=[
            'status'=> self::STATUS,
        ];
        if ($value!==null){
            return array_key_exists($column,$dropDownList)? $dropDownList[$column][$value]:false;
        }else{
            return array_key_exists($column,$dropDownList)? $dropDownList[$column]:false;
        }
    }
}
