<?php

namespace backend\models\export;

use common\components\Common;
use common\models\Inventory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * RedeemCodeForm
 */
class InventorySearch extends \common\models\Inventory
{
    public $store_name;
    public $goods_name;
    public $product_bn;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'goods_id', 'store_id', 'inventory_num', 'lock_inventory_num', 'sale_price', 'settlement_price', 'is_transfer', 'cooperate_price', 'is_cooperate', 'disabled_cooperate', 'can_use_membership_card', 'status'], 'integer'],
            [['store_name','product_bn','goods_name','out_start_time', 'out_end_time'], 'safe'],
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

        $this->load($params);
        $query->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'goods.name', $this->goods_name])
            ->andFilterWhere(['like', 'product_bn', $this->product_bn]);

        return $query->all();
    }


}
