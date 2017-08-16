<?php

namespace backend\modules\order\models\search;

use common\components\Common;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderInfo;

/**
 * ReViewSearch represents the model behind the search form of `common\models\OrderInfo`.
 */
class ReViewSearch extends OrderInfo
{
    public $user_name;
    public $order_object_bn;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'order_object_id', 'store_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id', 'send_goods_bauser_id', 'active_status', 'team_id', 'active_user_id'], 'integer'],
            [['order_sn', 'store_name', 'store_province', 'store_city', 'store_area', 'store_address', 'settlement_man', 'settlement_account', 'settlement_bank', 'pay_time', 'express_name', 'express_code', 'express_no', 'complete_time', 'bill_header', 'link_man', 'mobile', 'province', 'city', 'area', 'street', 'address', 'refund_date', 'remark', 'back_remark', 'in_date', 'in_verification', 'pay_id', 'create_time', 'update_time', 'api_order_sn'], 'safe'],
            [['store_lon', 'store_lat', 'lon', 'lat'], 'number'],
            [['user_name','order_sn','order_object_bn','link_man','store_name','mobile'],'trim']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
       // $user = Common::getUser();
        $query = OrderInfo::find()
            //->andWhere(['=','user_id',$user])
            ->where(['active_status'=>'1'])
       ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_object_id' => $this->order_object_id,
            'store_id' => $this->store_id,
            'store_lon' => $this->store_lon,
            'store_lat' => $this->store_lat,
            'total_price' => $this->total_price,
            'total_settlement_price' => $this->total_settlement_price,
            'total_cooperate_price' => $this->total_cooperate_price,
            'cash_coin' => $this->cash_coin,
            'promotion_id' => $this->promotion_id,
            'promotion_discount' => $this->promotion_discount,
            'total_fee' => $this->total_fee,
            'commision_fee' => $this->commision_fee,
            'pay_time' => $this->pay_time,
            'pay_type' => $this->pay_type,
            'complete_time' => $this->complete_time,
            'member_delivery_address_id' => $this->member_delivery_address_id,
            'delivery_way' => $this->delivery_way,
            'is_bill' => $this->is_bill,
            'bill_type' => $this->bill_type,
            'freight' => $this->freight,
            'payment_fee' => $this->payment_fee,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'refund_date' => $this->refund_date,
            'refund_fee' => $this->refund_fee,
            'refund_cash_coin' => $this->refund_cash_coin,
            'in_state' => $this->in_state,
            'in_date' => $this->in_date,
            'procedure_fee' => $this->procedure_fee,
            'bank_in' => $this->bank_in,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'status' => $this->status,
            'refund' => $this->refund,
            'comment_status' => $this->comment_status,
            'type' => $this->type,
            'app_id' => $this->app_id,
            'mall_store_id' => $this->mall_store_id,
            'send_goods_bauser_id' => $this->send_goods_bauser_id,
            'active_status' => $this->active_status,
            'team_id' => $this->team_id,
            'active_user_id' => $this->active_user_id,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'store_province', $this->store_province])
            ->andFilterWhere(['like', 'store_city', $this->store_city])
            ->andFilterWhere(['like', 'store_area', $this->store_area])
            ->andFilterWhere(['like', 'store_address', $this->store_address])
            ->andFilterWhere(['like', 'settlement_man', $this->settlement_man])
            ->andFilterWhere(['like', 'settlement_account', $this->settlement_account])
            ->andFilterWhere(['like', 'settlement_bank', $this->settlement_bank])
            ->andFilterWhere(['like', 'express_name', $this->express_name])
            ->andFilterWhere(['like', 'express_code', $this->express_code])
            ->andFilterWhere(['like', 'express_no', $this->express_no])
            ->andFilterWhere(['like', 'bill_header', $this->bill_header])
            ->andFilterWhere(['like', 'link_man', $this->link_man])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'back_remark', $this->back_remark])
            ->andFilterWhere(['like', 'in_verification', $this->in_verification])
            ->andFilterWhere(['like', 'pay_id', $this->pay_id])
            ->andFilterWhere(['like', 'api_order_sn', $this->api_order_sn]);

        return $dataProvider;
    }
}
