<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TalentSerialGoods;

/**
 * TalentSerialGoodsSearch represents the model behind the search form of `common\models\TalentSerialGoods`.
 */
class TalentSerialGoodsSearch extends TalentSerialGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'talent_serial_id', 'good_id', 'agio'], 'integer'],
            [['create_time'], 'safe'],
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
        $query = TalentSerialGoods::find();

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
            'talent_serial_id' => $this->talent_serial_id,
            'good_id' => $this->good_id,
            'agio' => $this->agio,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
