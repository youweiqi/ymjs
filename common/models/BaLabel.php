<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ba_label}}".
 *
 * @property int $id
 * @property int $ba_user_id 店员id
 * @property string $label_name 标签·
 */
class BaLabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ba_label}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_ba_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ba_user_id'], 'integer'],
            [['label_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ba_user_id' => 'Ba User ID',
            'label_name' => 'Label Name',
        ];
    }
}
