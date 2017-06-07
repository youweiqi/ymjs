<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 1/4/17
 * Time: PM4:43
 */
namespace console\controllers;

use common\models\Product;
use yii\console\Controller;
use common\models\Goods;
use yii\db\Query;
use Yii;
use common\models\Inventory;
class SynDataController extends Controller{
    const limit = 100;

    public function actionSynGoods()
    {
        $count = Goods::find()->where(['>','api_goods_id',0])->count();
        echo $count;echo "\n";
        $pageNum = ceil($count/self::limit);
        foreach (range(1,$pageNum) as $i)
        {
            $this->dealGoods($i);
        }
    }
    private function dealGoods($page)
    {
        $result= Goods::find()->limit(self::limit)->offset(($page-1)*self::limit)->where(['>','api_goods_id',0])->asArray()->all();
        foreach ($result as $goods)
        {
            $products = $this->getProduct($goods['api_goods_id']);
            foreach ($products as $product)
            {
                if(Product::find()->where(['api_product_id'=>$product['id']])->asArray()->one()){
                    continue;
                }
                $product_id = $this->insertProduct($goods['id'],$product);
                if($product_id){
                    $inventory = $this->getInventory($product['id']);
                    isset($inventory[0])&&$this->insertInventory($product_id,$goods['id'],$inventory[0]);
                }

            }
        }
    }

    private function getProduct($goods_id)
    {
        $result = Yii::$app->db_goods
            ->createCommand("select * from `yg_tmp_product`  WHERE  goods_id = $goods_id")
            ->queryAll();
        return $result;
    }

    private function insertProduct($goods_id,$product)
    {
        $productData = [
            'goods_id' => $goods_id,
            'spec_info' => $product['spec_info'],
            'spec_desc' => $product['spec_desc'],
            'spec_name' => $product['spec_name'],
            'bar_code' => $product['bar_code'],
            'product_bn' => $product['product_bn'],
            'supply_threshold' => $product['supply_threshold'],
            'is_stock_warn' => $product['is_stock_warn'],
            'is_del' => $product['is_del'],
            'status' => $product['status'],
            'api_product_id' => $product['id']
        ];
        $productModel = new Product();
        $productModel->setAttributes($productData);
        $productModel->save();
        return $productModel->id;
    }

    private function getInventory($product_id)
    {
        $result = Yii::$app->db_goods
            ->createCommand("SELECT * FROM yg_tmp_inventory WHERE inventory_num > 0 and product_id = $product_id order by inventory_num desc limit 1")
            ->queryALl();
        return $result;
    }

    private function insertInventory($product_id,$goods_id,$inventory)
    {
        $inventoryData = [
            'product_id' => $product_id,
            'goods_id' => $goods_id,
            'store_id' => $inventory['store_id'],
            'inventory_num' => $inventory['inventory_num'],
            'lock_inventory_num' => $inventory['lock_inventory_num'],
            'sale_price' => $inventory['sale_price'],
            'settlement_price' => $inventory['settlement_price'],
            'is_transfer' => $inventory['is_transfer'],
            'cooperate_price' => $inventory['cooperate_price'],
            'is_cooperate' => $inventory['is_cooperate'],
            'disabled_cooperate' => $inventory['disabled_cooperate'],
            'out_start_time' => $inventory['out_start_time'],
            'out_end_time' => $inventory['out_end_time'],
            'can_use_membership_card' => $inventory['can_use_membership_card'],
            'status' => $inventory['status'],
            'api_inventory_id' => $inventory['id'],
        ];
        $inventoryModel = new Inventory();
        $inventoryModel->setAttributes($inventoryData);
        $inventoryModel->save();
        echo "goods_id:$goods_id\t";
        echo "product_id:$product_id\t";
        echo "inventory:$inventoryModel->id \n";
    }



}