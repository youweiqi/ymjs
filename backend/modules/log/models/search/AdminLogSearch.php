<?php

namespace backend\modules\log\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form about `common\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    public $user_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ip', 'created_at', 'user_id'], 'integer'],
            [['route', 'description', 'user_name'], 'safe'],
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
        $query = AdminLog::find()
            ->joinWith(['user'])
            ->select('user.username,admin_log.*');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
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
            'ip' => $this->ip,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'user.username', $this->user_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
