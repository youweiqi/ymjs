<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "freight_template".
 *
 * @property integer $id
 * @property string $name
 * @property integer $default_freight
 */
class FreightTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.freight_template';
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
            [['default_freight'], 'integer'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '运费模板名',
            'default_freight' => '默认运费',
        ];
    }
}
