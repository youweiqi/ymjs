<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%logistics}}".
 *
 * @property int $id
 * @property string $name
 * @property string $name_code 物流编码
 * @property int $is_all_warehouse 0是单仓库 1是全仓库
 * @property int $warehouse_id
 */
class Logistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logistics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_all_warehouse'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name_code'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '物流',
            'name_code' => '物流编码',
            'is_all_warehouse' => '所属仓库',
            'warehouse_id' => '仓库'
        ];
    }
}
