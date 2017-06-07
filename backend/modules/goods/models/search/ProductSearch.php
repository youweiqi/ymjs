<?php

namespace backend\modules\goods\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    public $goods_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'status'], 'integer'],
            [['spec_info', 'spec_desc', 'spec_name', 'bar_code', 'product_bn', 'create_time', 'update_time','goods_name'], 'safe'],
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
        $query = Product::find();
        $query->orderBy(['product.id'=>SORT_DESC]);
        $query->joinWith('goods')->select('product.*,goods.name');

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
            'product.goods_id' => $this->goods_id,

        ]);

        $query->andFilterWhere(['like', 'product_bn', $this->product_bn])
            ->andFilterWhere(['like', 'goods.name', $this->goods_name]);

        return $dataProvider;
    }
}
