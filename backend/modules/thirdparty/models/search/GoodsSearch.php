<?php

namespace backend\modules\thirdparty\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'suggested_price', 'lowest_price', 'category_parent_id', 'category_id', 'talent_limit', 'threshold', 'ascription', 'talent_display', 'discount', 'operate_costing', 'score_rate', 'self_support', 'channel', 'api_goods_id'], 'integer'],
            [['goods_code', 'name', 'spec_desc', 'service_desc', 'label_name', 'unit', 'remark', 'online_time', 'offline_time', 'create_time', 'wx_small_imgpath'], 'safe'],
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
        $query = Goods::find()->where(['>','api_goods_id','0']);

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
            'brand_id' => $this->brand_id,
            'suggested_price' => $this->suggested_price,
            'lowest_price' => $this->lowest_price,
            'category_parent_id' => $this->category_parent_id,
            'category_id' => $this->category_id,
            'online_time' => $this->online_time,
            'offline_time' => $this->offline_time,
            'talent_limit' => $this->talent_limit,
            'threshold' => $this->threshold,
            'ascription' => $this->ascription,
            'talent_display' => $this->talent_display,
            'discount' => $this->discount,
            'operate_costing' => $this->operate_costing,
            'score_rate' => $this->score_rate,
            'self_support' => $this->self_support,
            'create_time' => $this->create_time,
            'channel' => $this->channel,
            'api_goods_id' => $this->api_goods_id,
        ]);

        $query->andFilterWhere(['like', 'goods_code', $this->goods_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'spec_desc', $this->spec_desc])
            ->andFilterWhere(['like', 'service_desc', $this->service_desc])
            ->andFilterWhere(['like', 'label_name', $this->label_name])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'wx_small_imgpath', $this->wx_small_imgpath]);

        return $dataProvider;
    }
}
