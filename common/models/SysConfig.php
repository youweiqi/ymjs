<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sys_config}}".
 *
 * @property int $id
 * @property string $code 功能编码
 * @property string $description 功能描述
 * @property int $type 功能实现类型（0无，1:欲购,2:校妆）
 */
class SysConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_config}}';
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
            [['code', 'description'], 'required'],
            [['type'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'type' => 'Type',
        ];
    }
}
