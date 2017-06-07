<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_service".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $image
 */
class GoodsService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_service';
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
            [['content'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '服务名称',
            'content' => '服务详情介绍',
            'image' => '图片',
        ];
    }
}
