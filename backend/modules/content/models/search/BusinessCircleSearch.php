<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BusinessCircle;

/**
 * BusinessCircleSearch represents the model behind the search form of `common\models\BusinessCircle`.
 */
class BusinessCircleSearch extends BusinessCircle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'radiation_raidus', 'advertising', 'status'], 'integer'],
            [['circle_name', 'back_image_path', 'province','address', 'city', 'area', 'create_time', 'update_time'], 'safe'],
            [['lon', 'lat'], 'number'],
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
        $query = BusinessCircle::find()->orderBy(['business_circle.advertising'=>SORT_DESC]);

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
            'lon' => $this->lon,
            'lat' => $this->lat,
            'radiation_raidus' => $this->radiation_raidus,
            'advertising' => $this->advertising,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'circle_name', $this->circle_name])
            ->andFilterWhere(['like', 'back_image_path', $this->back_image_path])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area]);

        return $dataProvider;
    }
}
