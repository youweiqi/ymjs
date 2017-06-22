<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%system_biz_config}}".
 *
 * @property int $id
 * @property string $code 编码
 * @property string $value 值
 * @property string $description 描述
 * @property string $type 类型编码
 * @property int $status (0禁用,1使用)
 * @property string $create_time
 * @property string $update_time
 */
class SystemBizConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_biz_config}}';
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
            [['code', 'value', 'description', 'type'], 'required'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['code', 'type'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => '编码',
            'value' => '值',
            'description' => '描述',
            'type' => '类型编码',
            'status' => '(0禁用,1使用)',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
