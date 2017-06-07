<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay_key".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $alipay_sellerid
 * @property string $alipay_appId
 * @property string $alipay_pid
 * @property string $alipay_appPrivateKey0
 * @property string $alipay_appPrivateKey
 * @property string $alipay_alipayPublicKey0
 * @property string $alipay_alipayPublicKey
 * @property string $storeName
 * @property string $wechat_appId0
 * @property string $wechat_secret0
 * @property string $wechat_partnerId0
 * @property string $wechat_partnerKey0
 * @property string $wechat_ca0
 * @property string $wechat_appId
 * @property string $wechat_secret
 * @property string $wechat_partnerId
 * @property string $wechat_partnerKey
 * @property string $wechat_ca
 */
class PayKey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.pay_key';
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
            [['store_id'], 'integer'],
            [['alipay_appPrivateKey0', 'alipay_appPrivateKey'], 'string'],
            [['wechat_appId', 'wechat_secret', 'wechat_partnerId', 'wechat_partnerKey', 'wechat_ca'], 'required'],
            [['alipay_sellerid', 'alipay_appId', 'alipay_pid', 'storeName', 'wechat_appId0', 'wechat_secret0', 'wechat_partnerId0', 'wechat_partnerKey0', 'wechat_ca0', 'wechat_appId', 'wechat_secret', 'wechat_partnerId', 'wechat_partnerKey', 'wechat_ca'], 'string', 'max' => 100],
            [['alipay_alipayPublicKey0', 'alipay_alipayPublicKey'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '门店id',
            'alipay_sellerid' => '卖家账号',
            'alipay_appId' => 'Alipay App ID',
            'alipay_pid' => 'Alipay Pid',
            'alipay_appPrivateKey0' => 'Alipay App Private Key0',
            'alipay_appPrivateKey' => 'Alipay App Private Key',
            'alipay_alipayPublicKey0' => '公钥(开放平台)',
            'alipay_alipayPublicKey' => '公钥(商户平台)',
            'storeName' => '门店名',
            'wechat_appId0' => '微信开放平台appid',
            'wechat_secret0' => 'Wechat Secret0',
            'wechat_partnerId0' => 'Wechat Partner Id0',
            'wechat_partnerKey0' => 'Wechat Partner Key0',
            'wechat_ca0' => '签名路径',
            'wechat_appId' => '微信公众平台appid',
            'wechat_secret' => 'Wechat Secret',
            'wechat_partnerId' => 'Wechat Partner ID',
            'wechat_partnerKey' => 'Wechat Partner Key',
            'wechat_ca' => '签名路径',
        ];
    }
}
