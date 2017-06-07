<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "store_info_v2".
 *
 * @property int $id
 * @property string $storeName 店铺名称
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 地址
 * @property string $coords 地图经纬度以逗号分隔
 * @property int $managerId 管理员id
 * @property int $cloudId 云图id
 * @property string $settlementAccount 结算账户
 * @property string $settlementBank 结算银行
 * @property string $settlementMan 结算人
 * @property int $openFlashExpress 是否及时送
 * @property int $flashExpressBeginTime 及时送开始时间
 * @property int $flashExpressEndTime 及时送结束时间
 * @property int $openInstall 是否到店取
 * @property int $installBeginTime 到店取开始时间
 * @property int $installEndTime 到店取结束时间
 * @property int $openExpress 是否开通快递送
 * @property int $storeType 店铺类型（1.直营店2.加盟店3.电商店）
 * @property int $checkoutType 是否可修改佣金 0不可修改 1可修改
 * @property int $isShowCommit 是否返佣  1 是  0 不是
 * @property int $isShowMap 是否显示在地图上  1显示 0 不显示
 * @property int $isModifyInventory 是否可修改库存 1.可修改 0.不可修改
 * @property string $tel 店铺电话
 * @property int $commisionlimit APP下单最低佣金比率
 * @property int $servicelimit 微信下单佣金比例
 * @property double $lat 经度
 * @property double $lng 纬度
 * @property int $timerDiscountPercent 限时折扣率
 * @property int $timerDiscountCount 限时折扣件数
 * @property int $wxPayDiscount 微信支付折扣
 * @property int $settlementInterval 结算周期
 * @property int $state 店铺状态： 0停用1启用
 */
class StoreInfoV2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration.store_info_v2';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_migration');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storeName'], 'required'],
            [['managerId', 'cloudId', 'openFlashExpress', 'flashExpressBeginTime', 'flashExpressEndTime', 'openInstall', 'installBeginTime', 'installEndTime', 'openExpress', 'storeType', 'checkoutType', 'isShowCommit', 'isShowMap', 'isModifyInventory', 'commisionlimit', 'servicelimit', 'timerDiscountPercent', 'timerDiscountCount', 'wxPayDiscount', 'settlementInterval', 'state'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['storeName', 'province', 'city', 'area', 'address', 'coords', 'settlementAccount'], 'string', 'max' => 255],
            [['settlementBank'], 'string', 'max' => 120],
            [['settlementMan'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'storeName' => '店铺名称',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '地址',
            'coords' => '地图经纬度以逗号分隔',
            'managerId' => '管理员id',
            'cloudId' => '云图id',
            'settlementAccount' => '结算账户',
            'settlementBank' => '结算银行',
            'settlementMan' => '结算人',
            'openFlashExpress' => '是否及时送',
            'flashExpressBeginTime' => '及时送开始时间',
            'flashExpressEndTime' => '及时送结束时间',
            'openInstall' => '是否到店取',
            'installBeginTime' => '到店取开始时间',
            'installEndTime' => '到店取结束时间',
            'openExpress' => '是否开通快递送',
            'storeType' => '店铺类型（1.直营店2.加盟店3.电商店）',
            'checkoutType' => '是否可修改佣金 0不可修改 1可修改',
            'isShowCommit' => '是否返佣  1 是  0 不是',
            'isShowMap' => '是否显示在地图上  1显示 0 不显示',
            'isModifyInventory' => '是否可修改库存 1.可修改 0.不可修改',
            'tel' => '店铺电话',
            'commisionlimit' => 'APP下单最低佣金比率',
            'servicelimit' => '微信下单佣金比例',
            'lat' => '经度',
            'lng' => '纬度',
            'timerDiscountPercent' => '限时折扣率',
            'timerDiscountCount' => '限时折扣件数',
            'wxPayDiscount' => '微信支付折扣',
            'settlementInterval' => '结算周期',
            'state' => '店铺状态： 0停用1启用',
        ];
    }
}
