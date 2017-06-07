<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand_user_enjoy".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $brand_id
 * @property string $create_time
 */
class BrandUserEnjoy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.brand_user_enjoy';
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
            [['user_id', 'brand_id'], 'required'],
            [['user_id', 'brand_id'], 'integer'],
            [['create_time'], 'safe'],
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
            'brand_id' => 'Brand ID',
            'create_time' => 'Create Time',
        ];
    }
}
