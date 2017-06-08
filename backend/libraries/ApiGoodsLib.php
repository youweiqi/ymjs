<?php
namespace backend\libraries;


use backend\modules\api\core\ApiException;
use common\models\Brand;
use common\models\Goods;
use common\models\Inventory;
use common\models\Product;

class ApiGoodsLib
{
    /**
     * 将接收到的apiGoods处理，并保存到本地.
     * @param  array $goods
     * @return mixed
     */
    public static function processApiGoods($goods)
    {
        $oldGoods = Goods::findOne(['api_goods_id'=>$goods['id']]);
        if($oldGoods) {//如果已经存在直接返回成功
            return true;
        }
        $goodsId = self::addGoods($goods);
        $productRes = self::addProduct($goodsId, $goods['products']);
        return true;
    }

    public static function addProduct($goodsId,$products)
    {
        foreach ($products as $product)
        {
            $productData = [
                'goods_id' => $goodsId,
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

            if(!$productModel->save())
            {
                throw new ApiException(json_encode($productModel->getErrors()));
            }

            $inventoryData = [
                'product_id' => $productModel->id,
                'goods_id' => $goodsId,
                'store_id' => 0,
                'inventory_num' => $product['inventory']['inventory_num'],
                'lock_inventory_num' => $product['inventory']['lock_inventory_num'],
                'sale_price' => $product['inventory']['sale_price'],
                'settlement_price' => $product['inventory']['settlement_price'],
                'is_transfer' => $product['inventory']['is_transfer'],
                'cooperate_price' => $product['inventory']['cooperate_price'],
                'is_cooperate' => $product['inventory']['is_cooperate'],
                'disabled_cooperate' => $product['inventory']['disabled_cooperate'],
                'out_start_time' => $product['inventory']['out_start_time'],
                'out_end_time' => $product['inventory']['out_end_time'],
                'can_use_membership_card' => $product['inventory']['can_use_membership_card'],
                'status' => $product['inventory']['status'],
                'api_inventory_id' => $product['inventory']['id'],
            ];
            $inventoryModel = new Inventory();
            $inventoryModel->setAttributes($inventoryData);
            if(!$inventoryModel->save())
            {
                throw new ApiException(json_encode($inventoryModel->getErrors()));
            }

        }
        return true;
    }

    public static function addGoods($goods)
    {
        $goodsData = [
            'goods_code' => $goods['goods_code'],
            'brand_id' => 0,
            'name' => $goods['name'],
            'spec_desc' => $goods['spec_desc'],
            'service_desc' => $goods['service_desc'],
            'label_name' => $goods['label_name'],
            'suggested_price' => $goods['suggested_price'],
            'lowest_price' => $goods['lowest_price'],
            'unit' => $goods['unit'],
            'remark' => $goods['remark'],
            'category_parent_id' => 0,
            'category_id' => 0,
            'talent_limit' => $goods['talent_limit'],
            'threshold' => $goods['threshold'],
            'ascription' => $goods['ascription'],
            'talent_display' => $goods['talent_display'],
            'discount' => $goods['discount'],
            'operate_costing' => $goods['operate_costing'],
            'score_rate' => $goods['score_rate'],
            'self_support' => $goods['self_support'],
            'wx_small_imgpath' => $goods['wx_small_imgpath'],
            'channel' => $goods['channel'],
            'api_goods_id' => $goods['id'],
        ];
        $model = new Goods();
        $model->setAttributes($goodsData);

        return $model->id;
    }

    public static function getGoodDetailHtml ($good_id)
    {
        $order_details = Product::find()
            ->where('goods_id=:oid',[':oid'=>$good_id])
            ->asArray()
            ->all();
        $order_detail_html = '<div class="division">
                                <h4>商品详情</h4>
                                <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>货品ID</th>
                                            <th>商品图</th>
                                            <th>货号</th>
                                            <th>条形码</th>
                                            <th>规格</th>
                                            
                                        </tr>
                                    </thead><tbody>';
        foreach ($order_details as $order_detail){
            $order_detail_html .= '<tr>';
            $order_detail_html .= '<td>'.$order_detail['id'].'</td>';
            $order_detail_html .= '<td>'.'</td>';
            $order_detail_html .= '<td>'.$order_detail['product_bn'].'</td>';
            $order_detail_html .= '<td>'.$order_detail['bar_code'].'</td>';
            $order_detail_html .= '<td>'.$order_detail['spec_name'] .'</td>';
            $order_detail_html .= '</tr>';
            ;
        }
        $order_detail_html .= '</tbody></table>
                            </div>';
        return $order_detail_html;
    }


}