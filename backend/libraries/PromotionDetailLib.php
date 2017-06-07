<?php
namespace backend\libraries;

use common\models\Brand;
use common\models\Goods;
use common\models\Member;
use common\models\PromotionDetail;
use common\models\User;
use common\models\UserPromotion;
use Yii;

class PromotionDetailLib
{
    public static function getPromotionDetail($id)
    {
        $promotion=PromotionDetail::findOne($id);

        if($promotion->type==3){

           $brand= Brand::findOne($promotion->brand_id);
            $promotion_detail = [$promotion->brand_id => $brand->name_cn.($brand->name_en)];

        }elseif($promotion->type==5){
            $good=Goods::findOne($promotion->good_id);
            $promotion_detail = [$promotion->good_id => $good->name];

        }else{
            $promotion_detail=[];
        }

        return $promotion_detail;
    }

    /**
     * 分发优惠券
     * @param  object $model 分发优惠券的表单对象
     */
    public static function dispatchPromotionDetail($model)
    {
        $promotion_id = $model->promotion_id;
        //单用户
        if($model->type==0){
            $member_id_arr = $model->user_id;
        }else {
            $members = Member::find()->select('id')->asArray()->all();
            $member_id_arr = [];
            foreach ($members as $member)
            {
                $member_id_arr[]=$member['id'];
            }
        }
        self::processDispatch($promotion_id, $member_id_arr);
    }
    /**
     * Displays a single Menu model.
     * @param  integer $promotion_id    优惠礼包ID
     * @param  array $member_id_arr    优惠券数据的数组
     */
    public static function processDispatch($promotion_id,$member_id_arr)
    {
        $promotion_detail_arr = ['add'=>[],'update'=>[]];
        $promotion_details = PromotionDetail::find()->where(['=','promotion_id',$promotion_id])->asArray()->all();
        foreach($member_id_arr as $member_id)
        {
            foreach ($promotion_details as $promotion_detail)
            {
                $user_promotion = UserPromotion::find()
                    ->where(['and',['=','user_id',$member_id],['=','promotion_detail_id',$promotion_detail['id']]])
                    ->one();
                //用户已经持有该优惠券
                if(!empty($user_promotion)){
                    $user_promotion->promotion_id = $promotion_id;
                    $user_promotion->promotion_detail_id = $promotion_detail['id'];
                    $user_promotion->type = $promotion_detail['type'];
                    $user_promotion->promotion_detail_name = $promotion_detail['promotion_detail_name'];
                    $user_promotion->user_id = $member_id;
                    $user_promotion->brand_id = $promotion_detail['brand_id'];
                    $user_promotion->good_id = $promotion_detail['good_id'];
                    $user_promotion->limited = $promotion_detail['limited'];
                    $user_promotion->is_discount = $promotion_detail['is_discount'];
                    $user_promotion->discount = $promotion_detail['discount'];
                    $user_promotion->amount = $promotion_detail['amount'];
                    $user_promotion->effective_time = $promotion_detail['effective_time'];
                    $user_promotion->expiration_time = $promotion_detail['expiration_time'];
                    $user_promotion->status = 1;
                    if($promotion_detail['is_one']){
                        $user_promotion->promotion_number = 1;
                    }else{
                        $user_promotion->promotion_number += 1;
                    }
                    $user_promotion->save(false);
                }else{
                    //用户未持有该优惠券
                    $promotion_detail_data['promotion_id'] = $promotion_id;
                    $promotion_detail_data['promotion_detail_id'] = $promotion_detail['id'];
                    $promotion_detail_data['type'] = $promotion_detail['type'];
                    $promotion_detail_data['promotion_detail_name'] = $promotion_detail['promotion_detail_name'];
                    $promotion_detail_data['user_id'] = $member_id;
                    $promotion_detail_data['brand_id'] = $promotion_detail['brand_id'];
                    $promotion_detail_data['good_id'] = $promotion_detail['good_id'];
                    $promotion_detail_data['limited'] = $promotion_detail['limited'];
                    $promotion_detail_data['is_discount'] = $promotion_detail['is_discount'];
                    $promotion_detail_data['discount'] = $promotion_detail['discount'];
                    $promotion_detail_data['amount'] = $promotion_detail['amount'];
                    $promotion_detail_data['promotion_number'] = 1;
                    $promotion_detail_data['effective_time'] = $promotion_detail['effective_time'];
                    $promotion_detail_data['expiration_time'] = $promotion_detail['expiration_time'];
                    $promotion_detail_data['status'] = 1;
                    $promotion_detail_arr['add'][] = $promotion_detail_data;
                    $promotion_detail_data = [];
                }
            }
            if(!empty($promotion_detail_arr['add']) && is_array($promotion_detail_arr['add'])){
                Yii::$app->db->createCommand()
                    ->batchInsert(UserPromotion::tableName(),
                        [
                            'promotion_id',
                            'promotion_detail_id',
                            'type',
                            'promotion_detail_name',
                            'user_id',
                            'brand_id',
                            'good_id',
                            'limited',
                            'is_discount',
                            'discount',
                            'amount',
                            'promotion_number',
                            'effective_time',
                            'expiration_time',
                            'status'
                        ],$promotion_detail_arr['add'])
                    ->execute();
            }
        }
    }

}