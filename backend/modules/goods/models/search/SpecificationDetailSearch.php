<?php

namespace backend\modules\goods\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SpecificationDetail;

/**
 * SpecificationDetailSearch represents the model behind the search form of `common\models\SpecificationDetail`.
 */
class SpecificationDetailSearch extends SpecificationDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'specification_id', 'order_no'], 'integer'],
            [['detail_name'], 'safe'],
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
        $query = SpecificationDetail::find();

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
            'specification_id' => $this->specification_id,
            'order_no' => $this->order_no,
        ]);

        $query->andFilterWhere(['like', 'detail_name', $this->detail_name]);

        return $dataProvider;
    }
}
