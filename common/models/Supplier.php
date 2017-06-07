<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%supplier}}".
 *
 * @property int $id
 * @property int $user_id 后台账户ID
 * @property string $supplier_name 供应商名称
 * @property int $supplier_type 供应商类型（1.电商2.门店3.海淘）
 * @property string $remark 备注
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'supplier_type'], 'integer'],
            [['supplier_name'], 'required'],
            [['remark'], 'string'],
            [['supplier_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'supplier_name' => 'Supplier Name',
            'supplier_type' => 'Supplier Type',
            'remark' => 'Remark',
        ];
    }
}
