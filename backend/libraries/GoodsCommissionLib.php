<?php
namespace backend\libraries;

use common\models\CRole;
use common\models\Goods;
use common\models\GoodsCommission;

use Yii;
use yii\helpers\Html;


class GoodsCommissionLib{
    /**
     * 获取商品原来分佣数据
     * @param  integer $goods_id
     * @param  object $goods_commission_form
     * @return mixed
     */
    public static function getOriginalGoodsCommission ($goods_id,$goods_commission_form)
    {
        $goods = Goods::findOne($goods_id);
        $original_datas = GoodsCommission::find()
            ->select('goods_commission.*,c_role.level as level')
            ->joinWith(['c_role'])
            ->where('goods_commission.good_id=:gid',[':gid'=>$goods_id])
            ->asArray()->all();
        foreach ($original_datas as $original_data){
            $temp_data[$original_data['level']] = $original_data;
        }
        unset($original_datas);
        $goods_commission_form->score_rate = $goods->score_rate ? $goods->score_rate : 0;
        $goods_commission_form->l200 = isset($temp_data[200]['commission'])?intval($temp_data[200]['commission']):0;

        return $goods_commission_form;

    }
    /**
     * Displays a single Menu model.
     * @param  integer $goods_id
     * @param  object $goods_commission_form
     * @return mixed
     */
    public static function setGoodsCommission ($goods_id,$goods_commission_form)
    {
        $goods = Goods::findOne($goods_id);
        $goods->score_rate = $goods_commission_form->score_rate;
        $goods->talent_limit = $goods_commission_form->talent_limit;
        $goods->save(false);
        return true;
    }
}