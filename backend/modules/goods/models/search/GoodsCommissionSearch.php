<?php

namespace backend\modules\goods\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsCommission;

/**
 * GoodsCommissionSearch represents the model behind the search form of `common\models\GoodsCommission`.
 */
class GoodsCommissionSearch extends GoodsCommission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'good_id', 'role_id', 'commission', 'indirect_commission'], 'integer'],
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
        $query = GoodsCommission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
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
            'good_id' => $this->good_id,
            'role_id' => $this->role_id,
            'commission' => $this->commission,
            'indirect_commission' => $this->indirect_commission,
        ]);

        return $dataProvider;
    }
}
