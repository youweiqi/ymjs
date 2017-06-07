<?php

namespace backend\modules\discount\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RedeemCodeLog;

/**
 * RedeemLogCodeSearch represents the model behind the search form of `common\models\RedeemCodeLog`.
 */
class RedeemLogCodeSearch extends RedeemCodeLog
{
    public $user_name;
    public $redeem_code;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'redeem_code_id', 'user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['id','user_name','redeem_code'],'trim']
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
        $query = RedeemCodeLog::find()
        ->joinWith(['c_user','redeem_code'])
        ->select('redeem_code_log.* ,c_user.user_name,redeem_code.redeem_code')
        ->orderBy(['redeem_code_log.id'=>SORT_DESC]);


        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'redeem_code_log.id' => $this->id,

        ]);
        $query->andFilterWhere(['like', 'redeem_code.redeem_code', $this->redeem_code])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name]);

        return $dataProvider;
    }
}
