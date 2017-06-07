<?php

namespace backend\modules\warehouse\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StoreGoodsFreight;

/**
 * StoreGoodsFreightSearch represents the model behind the search form of `common\models\StoreGoodsFreight`.
 */
class StoreGoodsFreightSearch extends StoreGoodsFreight
{
    public $store_name;
    public $good_name;
    public $freight_template_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'good_id', 'freight_template_id'], 'integer'],
            [['id','store_name','good_name','freight_template_name'],'trim']

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
        $query = StoreGoodsFreight::find()
        ->select('store_goods_freight.*,store.store_name,goods.name,freight_template.name')
        ->joinWith(['store','goods','freight_template'])
        ->orderBy(['store_goods_freight.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）

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
            'store_goods_freight.id' => $this->id,

        ]);
        $query->andFilterWhere(['like', 'store.store_name', $this->store_name])
            ->andFilterWhere(['like', 'goods.name', $this->good_name])
            ->andFilterWhere(['like', 'freight_template.name', $this->freight_template_name]);

        return $dataProvider;
    }
}
