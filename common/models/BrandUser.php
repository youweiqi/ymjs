<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%brand_user}}".
 *
 * @property int $id ID
 * @property int $brand_id 品牌ID
 * @property int $user_id
 * @property string $remark 备注
 */
class BrandUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brand_user}}';
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
            [['brand_id', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['remark'], 'string'],
            [['brand_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'user_id' => 'User ID',
            'remark' => 'Remark',
        ];
    }
}
