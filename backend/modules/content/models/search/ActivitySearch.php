<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Activity;

/**
 * ActivitySearch represents the model behind the search form of `common\models\Activity`.
 */
class ActivitySearch extends Activity
{
    public $good_name;
    public $store_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'good_id', 'store_id', 'sale_price', 'total_inventory_num', 'type', 'status', 'num', 'app_show'], 'integer'],
            [['start_time', 'end_time', 'create_time', 'update_time', 'show_time'], 'safe'],
            [['id','good_name','store_name'],'trim']
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

        $query = Activity::find()
            ->joinWith(['goods','store'])
            ->select('activity.*,goods.name,store.store_name')
            ->andWhere(['type'=>'2'])
            ->orderBy(['activity.id' => SORT_DESC]);

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
            'activity.id' => $this->id,
            'status' => $this->status,

        ]);
        $query->andFilterWhere(['like', 'store.store_name', $this->store_name])
            ->andFilterWhere(['like', 'goods.name', $this->good_name]);

        return $dataProvider;
    }
}
