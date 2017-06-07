<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsComment;

/**
 * GoodsCommentSearch represents the model behind the search form of `common\models\GoodsComment`.
 */
class GoodsCommentSearch extends GoodsComment
{
    public $good_name;
    public $user_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'good_id', 'user_id', 'order_detail_id', 'status'], 'integer'],
            [['comment_text', 'spec_name', 'image1', 'image2', 'image3', 'create_time'], 'safe'],
            [['id','good_name','user_name'],'trim']
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
        $query = GoodsComment::find()
            ->select('goods_comment.*,c_user.user_name,goods.name')
            ->joinWith(['c_user','goods'])
            ->orderBy(['goods_comment.id'=>SORT_DESC]);

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
            'goods_comment.id' => $this->id,
            'order_detail_id' => $this->order_detail_id,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'comment_text', $this->comment_text])
            ->andFilterWhere(['like', 'goods.name', $this->good_name])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name]);

        return $dataProvider;
    }
}
