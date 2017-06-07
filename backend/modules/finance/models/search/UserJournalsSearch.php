<?php

namespace backend\modules\finance\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserJournal;

/**
 * UserJournalsSearch represents the model behind the search form of `common\models\UserJournal`.
 */
class UserJournalsSearch extends UserJournal
{
    public $user_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'promotion_detail_id', 'money', 'bank_id', 'status', 'mall_store_id'], 'integer'],
            [['order_sn', 'type', 'comment', 'create_time', 'update_time'], 'safe'],
            [['id','user_name'],'trim']
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
        $query = UserJournal::find()
            ->select('user_journal.*,c_user.user_name,c_user_bank.bank_name')
            ->joinWith(['c_user','c_user_bank'])
            ->orderBy(['user_journal.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）;;

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
            'user_journal.id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name]);

        return $dataProvider;
    }
}
