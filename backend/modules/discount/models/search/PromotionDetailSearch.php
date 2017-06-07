<?php

namespace backend\modules\discount\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PromotionDetail;

/**
 * PromotionDetailSearch represents the model behind the search form of `common\models\PromotionDetail`.
 */
class PromotionDetailSearch extends PromotionDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'promotion_id', 'type', 'is_one', 'brand_id', 'good_id', 'limited', 'is_discount', 'amount', 'discount', 'mall_store_id', 'status', 'total_number', 'remaining_number', 'used_number', 'for_register', 'for_mall_display'], 'integer'],
            [['promotion_detail_name', 'effective_time', 'expiration_time', 'create_time', 'update_time'], 'safe'],
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
        $query = PromotionDetail::find()
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
            'promotion_id' => $this->promotion_id,
            'type' => $this->type,
            'is_one' => $this->is_one,
            'brand_id' => $this->brand_id,
            'good_id' => $this->good_id,
            'effective_time' => $this->effective_time,
            'expiration_time' => $this->expiration_time,
            'limited' => $this->limited,
            'is_discount' => $this->is_discount,
            'amount' => $this->amount,
            'discount' => $this->discount,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'mall_store_id' => $this->mall_store_id,
            'status' => $this->status,
            'total_number' => $this->total_number,
            'remaining_number' => $this->remaining_number,
            'used_number' => $this->used_number,
            'for_register' => $this->for_register,
            'for_mall_display' => $this->for_mall_display,
        ]);

        $query->andFilterWhere(['like', 'promotion_detail_name', $this->promotion_detail_name]);

        return $dataProvider;
    }
}
