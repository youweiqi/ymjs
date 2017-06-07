<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TalentSerial;

/**
 * TalentSerialSearch represents the model behind the search form of `common\models\TalentSerial`.
 */
class TalentSerialSearch extends TalentSerial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'like_count', 'see_count', 'comment_count', 'share_count', 'talent_id', 'status'], 'integer'],
            [['title', 'label_name', 'image_path', 'create_time'], 'safe'],
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
        $query = TalentSerial::find();

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
            'like_count' => $this->like_count,
            'see_count' => $this->see_count,
            'comment_count' => $this->comment_count,
            'share_count' => $this->share_count,
            'talent_id' => $this->talent_id,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'label_name', $this->label_name])
            ->andFilterWhere(['like', 'image_path', $this->image_path]);

        return $dataProvider;
    }
}
