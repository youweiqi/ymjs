<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "freight_template_detail".
 *
 * @property integer $id
 * @property integer $freight_template_id
 * @property string $province
 * @property integer $freight
 * @property string $area_code
 */
class FreightTemplateDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.freight_template_detail';
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
            [['freight_template_id', 'freight'], 'integer'],
            [['province'], 'required'],
            [['province'], 'string', 'max' => 30],
            [['area_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'freight_template_id' => '运费模板id',
            'province' => '省',
            'freight' => '运费',
            'area_code' => 'Area Code',
        ];
    }
}
