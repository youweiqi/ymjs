<?php
namespace backend\libraries;


use common\components\QiNiu;
use common\models\GoodsSpecificationImages;

class GoodsSpecificationImagesLib
{
    /**
     * 根据原来数据的数组删除商品规格图（七牛云上的图片也进行删除）.
     * @param  array $goods_spec_imgs
     */
    public static function delGoodsSpecImgs($goods_spec_imgs)
    {
        $ids = [];
        foreach ($goods_spec_imgs as $goods_spec_img)
        {
            QiNiu::deleteFile($goods_spec_img['image_path']);
            $ids[] = $goods_spec_img['id'];
        }
        if(is_array($ids) && !empty($ids)){
            GoodsSpecificationImages::deleteAll(['in', 'id', $ids]);
        }

    }
}