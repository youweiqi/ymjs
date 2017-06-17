<?php

namespace backend\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Commision;

/**
 * CommissionSearch represents the model behind the search form of `common\models\Commision`.
 */
class CommissionSearch extends Commision
{
    public $user_name;
    public $order_object_bn;
    public $order_info_bn;
    public $begin_time;
    public $end_time;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_detail_id', 'order_info_id', 'order_object_id', 'user_id', 'type', 'fee', 'result', 'status'], 'integer'],
            [['comment', 'result_time', 'create_time', 'update_time'], 'safe'],
            [['user_name','order_object_bn','order_info_bn','begin_time','end_time'],'trim']

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
        $query = Commision::find()
            ->select('commision.*,c_user.user_name,order_object.order_sn,order_info.order_sn,c_role.level')
            ->joinWith(['c_user','order_info','order_object','c_role'])
            ->orderBy(['commision.id'=>SORT_DESC]);;

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
            'order_detail_id' => $this->order_detail_id,
            'order_info_id' => $this->order_info_id,
            'order_object_id' => $this->order_object_id,
            'user_id' => $this->user_id,
            'commision.type' => $this->type,
            'fee' => $this->fee,
            'result_time' => $this->result_time,
            'result' => $this->result,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'commision.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
              ->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
              ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_bn])
              ->andFilterWhere(['like', 'order_info.order_sn', $this->order_info_bn]);

        return $dataProvider;
    }
}
