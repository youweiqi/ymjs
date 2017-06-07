<?php

namespace backend\modules\discount\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserPromotion;

/**
 * UserPromotionSearch represents the model behind the search form of `common\models\UserPromotion`.
 */
class UserPromotionSearch extends UserPromotion
{
    public $user_name;
    public $promotion_detail_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'promotion_detail_id', 'user_id', 'promotion_number', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['id','user_name','promotion_detail_name'],'trim']
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
        $query = UserPromotion::find()
        ->joinWith(['c_user','promotion_detail'])
        ->select('user_promotion.* ,c_user.user_name,promotion_detail.promotion_detail_name')
        ->orderBy(['user_promotion.id'=>SORT_DESC]);

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
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'store.store_name', $this->user_name])
            ->andFilterWhere(['like', 'promotion_detail.promotion_detail_name', $this->promotion_detail_name]);

        return $dataProvider;
    }
}
