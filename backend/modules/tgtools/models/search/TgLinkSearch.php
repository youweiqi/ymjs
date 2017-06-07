<?php

namespace backend\modules\tgtools\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TgLink;

/**
 * TgLinkSearch represents the model behind the search form of `common\models\TgLink`.
 */
class TgLinkSearch extends TgLink
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'promotion_detail_id', 'promotion_total_num', 'promotion_person_num', 'type', 'serial_id'], 'integer'],
            [['identifier', 'create_time'], 'safe'],
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
        $query = TgLink::find();

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
            'channel_id' => $this->channel_id,
            'promotion_detail_id' => $this->promotion_detail_id,
            'promotion_total_num' => $this->promotion_total_num,
            'promotion_person_num' => $this->promotion_person_num,
            'create_time' => $this->create_time,
            'type' => $this->type,
            'serial_id' => $this->serial_id,
        ]);

        $query->andFilterWhere(['like', 'identifier', $this->identifier]);

        return $dataProvider;
    }
}
