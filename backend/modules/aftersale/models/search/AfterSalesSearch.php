<?php

namespace backend\modules\aftersale\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfterSales;

/**
 * AfterSalesSearch represents the model behind the search form of `common\models\AfterSales`.
 */
class AfterSalesSearch extends AfterSales
{
    public $user_name;
    public $order_object_bn;
    public $store_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_object_id', 'order_info_id', 'order_detail_id', 'user_id', 'product_id', 'quantity', 'refund_money', 'refund_cash_money', 'store_id', 'is_refund', 'type', 'send_back', 'platform_opinion', 'before_order_status', 'status', 'pay_type',], 'integer'],
            [['order_info_sn', 'product_bn', 'after_sn', 'user_refund_reason', 'user_first_reason', 'supplementary_reason', 'img_proof1', 'img_proof2', 'img_proof3', 'store_refuse_reason', 'store_refuse_reason1', 'courier_company', 'courier_company_en', 'courier_number','app_id', 'create_time', 'update_time', 'refund_id'], 'safe'],
            [['after_sn','order_info_sn','product_bn','order_object_bn','user_name','store_name'],'trim']
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
        $query = AfterSales::find()
            ->where('after_sales.type=1')
            ->joinWith(['order_object','store','c_user'])
            ->select('after_sales.*,order_object.order_sn as p_order_sn,c_user.user_name,store.store_name')
            ->orderBy(['after_sales.id'=>SORT_DESC]);

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

        $query
            ->andFilterWhere(['like', 'order_info_sn', $this->order_info_sn])
            ->andFilterWhere(['like', 'after_sn', $this->after_sn])
            ->andFilterWhere(['like', 'product_bn', $this->product_bn])
            ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_bn])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
            ->andFilterWhere(['like', 'store.store_name', $this->store_name]);

        return $dataProvider;
    }
}
