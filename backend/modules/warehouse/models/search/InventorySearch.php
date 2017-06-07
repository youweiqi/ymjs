<?php

namespace backend\modules\warehouse\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inventory;

/**
 * InventorySearch represents the model behind the search form of `common\models\Inventory`.
 */
class InventorySearch extends Inventory
{
    public $product_bn;
    public $store_name;
    public $goods_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'goods_id', 'store_id', 'inventory_num', 'lock_inventory_num', 'sale_price', 'settlement_price', 'is_transfer', 'cooperate_price', 'is_cooperate', 'disabled_cooperate', 'can_use_membership_card', 'status'], 'integer'],
            [['out_start_time', 'out_end_time'], 'safe'],
            [['id','product_bn','goods_name','store_name'],'trim']
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
        $query = Inventory::find()
            ->select('inventory.*,store.store_name,goods.name,product.product_bn')
            ->joinWith(['store','goods','product'])
            ->orderBy(['inventory.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）

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
            'inventory.id' => $this->id,

        ]);
        $query->andFilterWhere(['like', 'store.store_name', $this->store_name])
              ->andFilterWhere(['like', 'goods.name', $this->goods_name])
              ->andFilterWhere(['like', 'product.product_bn', $this->product_bn]);


        return $dataProvider;
    }
}
