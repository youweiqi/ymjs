<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QueueTasks;

/**
 * QueueTasksSearch represents the model behind the search form of `common\models\QueueTasks`.
 */
class QueueTasksSearch extends QueueTasks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'task_type', 'task_status'], 'integer'],
            [['task_content', 'create_time', 'over_time', 'task_result', 'operater'], 'safe'],
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
        $query = QueueTasks::find()->orderBy(["task_id" => SORT_DESC]);

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
            'task_id' => $this->task_id,
            'task_type' => $this->task_type,
            'task_status' => $this->task_status,
            'create_time' => $this->create_time,
            'over_time' => $this->over_time,
        ]);

        $query->andFilterWhere(['like', 'task_content', $this->task_content])
            ->andFilterWhere(['like', 'task_result', $this->task_result])
            ->andFilterWhere(['like', 'operater', $this->operater]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'task_id' => '任务id',
            'task_type' => '任务类型',
            'task_content' => '任务内容',
            'task_status' => '任务状态',
            'create_time' => '开始时间',
            'over_time' => '结束时间',
            'task_result' => '结果',
            'operater' => '操作人',
        ];
    }
}
