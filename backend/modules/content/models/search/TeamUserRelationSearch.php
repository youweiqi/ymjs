<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TeamUserRelation;

/**
 * TeamUserRelationSearch represents the model behind the search form of `common\models\TeamUserRelation`.
 */
class TeamUserRelationSearch extends TeamUserRelation
{
    public $team_name;
    public $user_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'team_id', 'user_id'], 'integer'],
            [['team_name','user_name'],'trim']
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
        $query = TeamUserRelation::find()
            ->joinWith(['user','team'])
            ->select('team_user_relation.*,user.username,team.team_name')
            ->orderBy(['team_user_relation.id' => SORT_DESC]);

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
        $query->andFilterWhere(['like', 'user.username', $this->user_name])
              ->andFilterWhere(['like', 'team.team_name', $this->team_name]);
        return $dataProvider;
    }
}
