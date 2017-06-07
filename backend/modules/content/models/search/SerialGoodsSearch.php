<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SerialGoods;

/**
 * SerialGoodsSearch represents the model behind the search form of `common\models\SerialGoods`.
 */
class SerialGoodsSearch extends SerialGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'serial_id', 'good_id', 'order_no'], 'integer'],
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
        $query = SerialGoods::find();

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
            'serial_id' => $this->serial_id,
            'good_id' => $this->good_id,
            'order_no' => $this->order_no,
        ]);

        return $dataProvider;
    }
}
