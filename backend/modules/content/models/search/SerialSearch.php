<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Serial;

/**
 * SerialSearch represents the model behind the search form of `common\models\Serial`.
 */
class SerialSearch extends Serial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'like_count', 'see_count', 'share_count', 'comment_count', 'category_id', 'is_recommend', 'is_display', 'cover_imgwidth', 'cover_imgheight', 'type', 'status'], 'integer'],
            [['online_time', 'offline_time', 'title', 'label_name', 'cover_imgpath', 'freerate', 'wx_big_imgpath', 'wx_small_imgpath', 'create_time'], 'safe'],
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
        $query = Serial::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['offline_time'=>SORT_DESC,'id'=>SORT_DESC]]
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
            'online_time' => $this->online_time,
            'offline_time' => $this->offline_time,
            'like_count' => $this->like_count,
            'see_count' => $this->see_count,
            'share_count' => $this->share_count,
            'comment_count' => $this->comment_count,
            'category_id' => $this->category_id,
            'is_recommend' => $this->is_recommend,
            'is_display' => $this->is_display,
            'cover_imgwidth' => $this->cover_imgwidth,
            'cover_imgheight' => $this->cover_imgheight,
            'type' => $this->type,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'label_name', $this->label_name])
            ->andFilterWhere(['like', 'cover_imgpath', $this->cover_imgpath])
            ->andFilterWhere(['like', 'freerate', $this->freerate])
            ->andFilterWhere(['like', 'wx_big_imgpath', $this->wx_big_imgpath])
            ->andFilterWhere(['like', 'wx_small_imgpath', $this->wx_small_imgpath]);

        return $dataProvider;
    }
}
