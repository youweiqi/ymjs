<?php
namespace backend\libraries;

use common\components\QiNiu;
use common\models\GoodsNavigate;

class GoodsNavigateLib
{
    /**
     * 根据原来数据的数组删除商品轮播图（七牛云上的图片也进行删除）.
     * @param  array $goods_navigate_imgs
     */
    public static function delGoodsNavigates($goods_navigate_imgs)
    {
        $ids = [];
        foreach ($goods_navigate_imgs as $goods_navigate_img)
        {
            QiNiu::deleteFile($goods_navigate_img['navigate_image']);
            $ids[] = $goods_navigate_img['id'];
        }
        if(is_array($ids) && !empty($ids)){
            GoodsNavigate::deleteAll(['in', 'id', $ids]);
        }

    }
}