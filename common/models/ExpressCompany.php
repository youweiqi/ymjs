<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "express_company".
 *
 * @property integer $id
 * @property string $company_no
 * @property string $company_name
 * @property string $creater_time
 * @property string $update_time
 * @property integer $status
 */
class ExpressCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.express_company';
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
            [['company_no', 'company_name'], 'required'],
            [['creater_time', 'update_time'], 'safe'],
            [['status'], 'integer'],
            [['company_no'], 'string', 'max' => 11],
            [['company_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_no' => '快递公司编号',
            'company_name' => '快递公司名称',
            'creater_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用1启用',
        ];
    }
}
