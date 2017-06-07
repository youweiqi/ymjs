<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $link_man 联系人
 * @property string $mobile 手机号码
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 收货地址
 * @property string $id_number 身份证号
 * @property double $lon 经度
 * @property double $lat 纬度
 * @property int $is_default 是否设为默认地址
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_address}}';
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
            [['user_id', 'is_default'], 'integer'],
            [['lon', 'lat'], 'number'],
            [['link_man', 'mobile', 'province', 'city', 'area'], 'string', 'max' => 50],
            [['address', 'id_number'], 'string', 'max' => 255],
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
            'link_man' => 'Link Man',
            'mobile' => 'Mobile',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'id_number' => '身份证',
            'lon' => 'Lon',
            'lat' => 'Lat',
            'is_default' => 'Is Default',
        ];
    }
}
