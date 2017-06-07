<?php

namespace backend\modules\finance\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderObject;

/**
 * OrderObjectSearch represents the model behind the search form of `common\models\OrderObject`.
 */
class OrderObjectSearch extends OrderObject
{
    public $user_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'refund_start_time', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id'], 'integer'],
            [['order_sn', 'pay_time', 'bill_header', 'link_man', 'mobile', 'province', 'city', 'area', 'street', 'address', 'refund_date', 'remark', 'in_date', 'in_verification', 'pay_id', 'create_time', 'update_time', 'open_id', 'api_order_sn'], 'safe'],
            [['lon', 'lat'], 'number'],
            [['id','user_name','order_sn'],'trim']
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
        $query = OrderObject::find()
            ->where(['status'=>['2','3','4','7']])
            ->andWhere(['>','freight','0'])
            ->select('order_object.*,c_user.user_name')
            ->joinWith(['c_user'])
            ->orderBy(['order_object.id'=>SORT_DESC]);

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
            'refund_start_time' => $this->refund_start_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'status' => $this->status,
            'refund' => $this->refund,
            'comment_status' => $this->comment_status,
            'type' => $this->type,
            'app_id' => $this->app_id,
            'mall_store_id' => $this->mall_store_id,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'bill_header', $this->bill_header])
            ->andFilterWhere(['like', 'link_man', $this->link_man])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'in_verification', $this->in_verification])
            ->andFilterWhere(['like', 'pay_id', $this->pay_id])
            ->andFilterWhere(['like', 'open_id', $this->open_id])
            ->andFilterWhere(['like', 'api_order_sn', $this->api_order_sn]);

        return $dataProvider;
    }

    public static function findIdBySn($order_sn)
    {
        $o = self::findOne(["order_sn" => $order_sn]);
        if($o) {
            return $o->id;
        }else{
            return false;
        }
    }
}
