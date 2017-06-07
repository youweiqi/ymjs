<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_select".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $ico_path
 * @property integer $order_no
 */
class CategorySelect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.category_select';
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
            [['category_id'], 'required'],
            [['category_id', 'order_no'], 'integer'],
            [['name'], 'string', 'max' => 11],
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
            'name' => '自定义分类名称',
            'category_id' => '分类ID',
            'ico_path' => '分类图片',
            'order_no' => '排序',
        ];
    }
}
