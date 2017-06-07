<?php

namespace backend\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderInfo;

/**
 * OrderInfoSearch represents the model behind the search form of `common\models\OrderInfo`.
 */
class OrderInfoSearch extends OrderInfo
{
    public $user_name;
    public $order_object_bn;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'order_object_id', 'store_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id', 'send_goods_bauser_id'], 'integer'],
            [['order_sn', 'store_name', 'store_province', 'store_city', 'store_area', 'store_address', 'settlement_man', 'settlement_account', 'settlement_bank', 'pay_time', 'express_name', 'express_code', 'express_no', 'complete_time', 'bill_header', 'link_man','province', 'city', 'area', 'street', 'address', 'refund_date', 'remark', 'back_remark', 'in_date', 'in_verification', 'pay_id', 'create_time', 'update_time'], 'safe'],
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
        $query = OrderInfo::find()
            ->select('order_info.*,c_user.user_name,order_object.order_sn as p_order_sn')
            ->joinWith(['c_user','order_object'])
            ->orderBy(['order_info.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）;

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere([
            'order_info.status'=>$this->status,
            'order_info.refund'=>$this->refund
        ]);

        $query->andFilterWhere(['like', 'order_info.order_sn', $this->order_sn])
              ->andFilterWhere(['like', 'store_name', $this->store_name])
              ->andFilterWhere(['like', 'order_info.link_man', $this->link_man])
              ->andFilterWhere(['like', 'order_info.mobile', $this->mobile])
              ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_bn])
              ->andFilterWhere(['like', 'c_user.user_name', $this->user_name]);
        return $dataProvider;
    }
}
