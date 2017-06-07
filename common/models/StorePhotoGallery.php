<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_photo_gallery".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $image_url
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class StorePhotoGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_photo_gallery';
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
            [['store_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['image_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '店铺id',
            'image_url' => '图片路径',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '1使用  2删除',
        ];
    }
}
