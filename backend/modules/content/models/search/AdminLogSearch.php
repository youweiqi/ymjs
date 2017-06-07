<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form of `common\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    public $user_name;
    public $begin_time;
    public $end_time;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'create_time', 'status'], 'integer'],
            [['title', 'controller', 'action', 'querystring', 'remark', 'ip'], 'safe'],
            [['user_name','begin_time','end_time'],'trim']
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
            ->select('admin_log.*,admin.username')
            ->joinWith(['admin'])
            ->orderBy(['admin_log.id'=>SORT_DESC]);


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
            'admin_log.id' => $this->id,
            'status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['>', 'create_time', $this->begin_time])
            ->andFilterWhere(['<', 'create_time', $this->end_time])
            ->andFilterWhere(['like', 'admin.username', $this->user_name])
           ;

        return $dataProvider;
    }
}
