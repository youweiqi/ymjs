<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "after_sales_operation".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $after_sales_id
 * @property integer $ba_user_id
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class AfterSalesOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.after_sales_operation';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_order');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'after_sales_id', 'ba_user_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '店铺ID',
            'after_sales_id' => '售后ID',
            'ba_user_id' => '操作店员ID',
            'content' => '操作内容',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用 1使用',
        ];
    }
}
