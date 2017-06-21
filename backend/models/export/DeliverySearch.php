<?php

namespace backend\models\export;

use common\components\Common;
use common\models\OrderInfo;
use yii\base\Model;

/**
 * RedeemCodeForm
 */
class DeliverySearch extends \common\models\OrderInfo
{
    public $user_name;
    public $order_object_order_sn;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'order_object_id', 'store_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id'], 'integer'],
            [['user_name','order_object_order_sn','order_sn', 'store_name', 'store_province', 'store_city', 'store_area', 'store_address', 'settlement_man', 'settlement_account', 'settlement_bank', 'pay_time', 'express_name', 'express_code', 'express_no', 'complete_time', 'bill_header', 'link_man', 'mobile', 'province', 'city', 'area', 'street', 'address', 'refund_date', 'remark', 'back_remark', 'in_date', 'in_verification', 'pay_id', 'create_time', 'update_time'], 'safe'],
            [['store_lon', 'store_lat', 'lon', 'lat'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $store_id_arr = Common::getStoreIdArrByUserId();
        $query = OrderInfo::find()
            ->where(['in', 'order_info.store_id', $store_id_arr])
            ->select('order_info.order_sn,order_info.store_name,order_info.express_name,order_info.express_no')
            ->joinWith(['c_user','order_object','order_detail'])
            ->orderBy(['order_info.id'=>SORT_DESC]);

        $this->load($params,'OrderInfoSearch');
        $query->andFilterWhere([
            'order_info.status' => $this->status,
            'order_info.delivery_way' => $this->delivery_way,
        ]);

        $query->andFilterWhere(['like', 'order_info.order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
            ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_order_sn])
            ->andFilterWhere(['like', 'order_info.store_name', $this->store_name])
            ->andFilterWhere(['like', 'order_info.link_man', $this->link_man]);

        return $query->all();
    }

}
