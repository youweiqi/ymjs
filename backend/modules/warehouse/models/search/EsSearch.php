<?php

namespace backend\modules\warehouse\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class EsSearch extends Product
{
    public $goods_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id','name','good_code'],'trim']
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
        $query = Product::find()
            ->select('product.*,goods.name')
            ->joinWith(['goods'])
            ->orderBy(['product.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）;

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
            'product.id' => $this->id,
            'supply_threshold' => $this->supply_threshold,
            'is_stock_warn' => $this->is_stock_warn,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_del' => $this->is_del,
            'status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['like', 'goods.name', $this->goods_name])
            ->andFilterWhere(['like', 'bar_code', $this->bar_code])
            ->andFilterWhere(['like', 'product_bn', $this->product_bn]);

        return $dataProvider;
    }
}
