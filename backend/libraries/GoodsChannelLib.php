<?php
namespace backend\libraries;

use common\models\GoodsChannel;

class GoodsChannelLib{
    /*
     * 获取商品的来源渠道
     */
    public static function getGoodsChanels(){
        $goods_channels = GoodsChannel::find()->asArray()->all();
        return $goods_channels?$goods_channels:[];
    }
}