<?php

namespace backend\modules\discount\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RedeemCode;

/**
 * RedeemCodeSearch represents the model behind the search form of `common\models\RedeemCode`.
 */
class RedeemCodeSearch extends RedeemCode
{
    public $promotion_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'usable_times', 'used_times', 'promotion_id', 'status'], 'integer'],
            [['redeem_code', 'creater', 'start_date', 'end_date', 'create_time', 'update_time'], 'safe'],
            [['id','redeem_code','remark','promotion_name'],'trim']
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
        $query = RedeemCode::find()
            ->select('redeem_code.*,promotion.name')
            ->joinWith(['promotion'])
            ->orderBy(['redeem_code.id'=>SORT_DESC]);

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
            'type' => $this->type,
            'usable_times' => $this->usable_times,
            'used_times' => $this->used_times,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'redeem_code', $this->redeem_code])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'promotion.name', $this->promotion_name]);

        return $dataProvider;
    }
}
