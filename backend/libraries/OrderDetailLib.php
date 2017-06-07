<?php
namespace backend\libraries;

use common\models\OrderDetail;
use common\models\Product;
use yii\helpers\Html;

class OrderDetailLib{
    public static function getOrderDetailHtml ($order_id)
    {
        $order_details = OrderDetail::find()
            ->where('order_id=:oid',[':oid'=>$order_id])
            ->asArray()
            ->all();
        $order_detail_html = '<div class="division">
                                <h4>订单详情</h4>
                                <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>商品图片</th>
                                            <th>商品名称</th>
                                            <th>货号</th>
                                            <th>规格</th>
                                            <th>购买数量</th>
                                            <th>总售价</th>
                                            <th>总结算价</th>
                                        </tr>
                                    </thead><tbody>';
        foreach ($order_details as $order_detail){
            $order_detail_html .= '<tr>';
            $order_detail_html .= '<td>'. Html::img($order_detail['navigate_img1'],['width' => '60px','height'=>'60px']).'</td>';
            $order_detail_html .= '<td>'.$order_detail['good_name'].'</td>';
            $order_detail_html .= '<td>'.self::getProductBn($order_detail['product_id']).'</td>';
            $order_detail_html .= '<td>'.$order_detail['spec_name'].'</td>';
            $order_detail_html .= '<td>'.$order_detail['quantity'].'</td>';
            $order_detail_html .= '<td>'.$order_detail['total_price']/100 .'</td>';
            $order_detail_html .= '<td>'.($order_detail['api_order_detail_id']=='0'?$order_detail['total_settlementprice']/100 :$order_detail['total_cooperate_price']/100) .'</td>';
            $order_detail_html .= '</tr>';
            ;
        }
        $order_detail_html .= '</tbody></table>
                            </div>';
        return $order_detail_html;
    }
  /*
   * 去取product的货号
   */

  public static function getProductBn($product_id)
  {

      $product=Product::findOne($product_id);
      if (!empty($product)){
          $product_name=$product->product_bn;
          return $product_name;
      }else{
          return $product_id;
      }

  }
}