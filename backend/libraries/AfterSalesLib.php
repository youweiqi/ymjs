<?php
namespace backend\libraries;

use common\components\QiNiu;
use common\models\AfterSales;
use common\models\Goods;
use common\models\OrderDetail;
use common\models\OrderInfo;
use yii\helpers\Html;

class AfterSalesLib
{
    public static function getAfterSalesDetailHtml ($aftersale_id)
    {
        $aftersale = AfterSales::find()
            ->where(['=','id',$aftersale_id])
            ->asArray()
            ->one();
        $aftersale_detail_html = '<div class="division">
                                <ul class=\'clearFix\' onclick="showContent()">
            <li data-index="1">订单信息</li>
            <li data-index="2">货品信息</li>
            <li data-index="3">物流信息</li>
            <li data-index="4">退货图片</li>
        </ul>
    </header>
    <div class="content">
        <!--订单信息-->
        <div id="content-1"  class="content-data">
            <p class="content-data-name">订单信息</p>
            <div class="data-box">
                <div class="content-data-box">
                    <div class="data-top">
                        <p class="data-top-name">商品价格</p>
                        <div class="data-top-main clearFix">
                            <div class="shoujia">
                                <span class="content-n">商品售价:</span>
                                <span class="content-inp">
                                    <input type="text" value="12.30">
                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">平均优惠券抵扣额:</span>
                                <span class="content-inp">
                                    <input type="text" value="12.30">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="data-bottom">
                        <p class="data-top-name">订单其他信息</p>
                        <div class="data-top-main clearFix">
                            <div class="shoujia">
                                <span class="content-n">支付方式:</span>
                                <span class="content-inp" style="width: 90px">
                                    <input type="text" value="在线支付">
                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">是否发票:</span>
                                <span class="content-inp" style="width: 30px;">
                                    <input type="text" value="是">
                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">发票类型:</span>
                                <span class="content-inp" style="width: 100px;">
                                    <input type="text" value="增值专用发票">
                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">发票抬头:</span>
                                <span class="content-inp" style="width: 225px">
                                    <input type="text" value="校妆网">
                                </span>
                            </div>
                        </div>
                        <div class="data-bottom-beizhu clearFix">
                            <div class="order-beizhu clearFix">
                                <span class="beizhu-n">客户留言:</span>
                                <span class="beizhu-con" style="height: 50px">
                                    <textarea></textarea>
                                </span>
                            </div>
                            <div class="order-beizhu clearFix">
                                <span class="beizhu-n" style="padding: 0 22px">后台备注:</span>
                                <span class="beizhu-con">
                                    <textarea></textarea>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--货品信息-->
        <div id="content-2" style="display: none" class="content-data content2-data" >
            <p class="content-data-name">货品信息</p>
            <div class="data2-box">
                <div class="content2-data2-box clearFix">
                    <div class="data2-box-img">
                        <p class="img2-n">货物图片</p>
                        <p class="img2"><img src="img/600_400.png" alt=""></p>
                    </div>
                    <div class="data2-box-con">
                        <div class="con2-inf">信息详情</div>
                        <div class="box-con2-top clearFix">
                            <div class="con2-top-1">
                                <span class="con2-n">名称：</span>
                                <span class="con2-inp con2-inp-1"><input type="text" value="衣服商标"></span>
                            </div>
                            <div class="con2-top-2">
                                <span class="con2-n">货号：</span>
                                <span class="con2-inp con2-inp-2"><input type="text" value="12312312"></span>
                            </div>
                            <div class="con2-top-3">
                                <span class="con2-n">数量：</span>
                                <span class="con2-inp con2-inp-3"><input type="text" value="32"></span>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <!--物流信息-->
        <div id="content-3" style="display: none" class="content-data content3-data" >
            <p class="content-data-name">物流信息</p>
            <div class="data3-box">
                <div class="content3-data3-box">
                    <div class="data3-n1">基本信息</div>
                    <div class="box3-con">
                        <div>
                            <span class="data3-box-n">配送方式：</span>
                            <span class="data3-box-inp" style="width: 120px"><input type="text" value="快递免邮"></span>
                        </div>
                        <div>
                            <span class="data3-box-n">收件人：</span>
                            <span class="data3-box-inp" style="width: 120px"><input type="text" value="小傲娇"></span>
                        </div>
                        <div>
                            <span class="data3-box-n">收件人电话：</span>
                            <span class="data3-box-inp" style="width: 120px"><input type="text" value="18737321207"></span>
                        </div>
                    </div>
                    <div class="box3-con-address">
                        <span class="address">地址：</span>
                        <span class="address-inp" style="width: 592px;">
                            <span class="select1">
                                <span>省:</span>
                                <span class="con1"><input type="text" placeholder="省"></span>
                            </span>
                            <span class="select1">
                                <span>市:</span>
                                <span class="con1"><input type="text" placeholder="市"></span>
                            </span>
                            <span class="select1">
                                <span>区:</span>
                                <span class="con1"><input type="text" placeholder="区"></span>
                            </span>
                            <span class="inp1">
                                <input type="text" placeholder="详细地址">
                            </span>
                        </span>
                    </div>
                    <div class="data3-n1">物流详情</div>
                    <div class="data3-con-box clearFix">
                        <div class="box3-con box3-con3">
                            <div>
                                <span class="data3-box-n">物流公司：</span>
                                <span class="data3-box-inp" style="width: 120px"><input type="text" value="圆通公司"></span>
                            </div>
                            <div>
                                <span class="data3-box-n">物流单号：</span>
                                <span class="data3-box-inp" style="width: 160px"><input type="text" value="1231234324325"></span>
                            </div>
                            <div>
                                <span class="data3-box-n wuliu-n">物流信息：</span>
                            </div>
                        </div>
                        <div class="wuliu-inf">
                            <span class="btn" onmouseover="showWuliuInf()" onmouseout="hideWuliuInf()">查看物流</span>
                            <ul class="wuliu-con" id="Inf" onmouseover="showWuliuInf()" onmouseout="hideWuliuInf()">
                                <li v-for="d in da">
                                    <p class="p1">{{d.text}}</p>
                                    <p>{{d.time}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--退货图片-->
        <div id="content-4" style="display: none" class="content-data content4-data">
            <p class="content-data-name">退货信息</p>
            <div class="img-box">
                <div class="img1">
                    <img src="img/600_400.png" alt="">
                </div>
                <div class="img2">
                    <img src="img/600_400.png" alt="">
                </div>
                <div class="img3">
                    <img src="img/600_400.png" alt="">
                </div>
            </div>
        </div>
    </div>
                            </div>';
        return $aftersale_detail_html;
    }
    public static function getAfterSalesData($aftersale_id)
    {
        $aftersale = AfterSales::findOne($aftersale_id);
        $order_info = OrderInfo::findOne($aftersale->order_info_id);
        $order_detail = OrderDetail::findOne($aftersale->order_detail_id);
        $goods = Goods::find()->select('goods.*')->joinWith('product')
            ->where(['=','product.id',$aftersale->product_id])
            ->one();
        $data['order']['total_price'] = $order_detail->total_price/100;
        $data['order']['promotion_discount'] = $order_detail->promotion_discount/100;
        $data['order']['pay_type'] = OrderInfoLib::getPayType($order_info->pay_type);
        $data['order']['is_bill'] = $order_info->is_bill?'是':'否';
        $data['order']['bill_type'] = $order_info->bill_type=='1'?'个人':'公司';
        $data['order']['bill_header'] = $order_info->bill_header;
        $data['order']['remark'] = $order_info->remark;
        $data['order']['back_remark'] = $order_info->back_remark;

        $data['product']['goods_name'] = $order_detail->good_name;
        $data['product']['product_bn'] = $aftersale->product_bn;
        $data['product']['product_img'] = $order_detail->navigate_img1;
        $data['product']['quantity'] = $aftersale->quantity;
        $data['logistics']['delivery_way'] = OrderInfoLib::getDeliveryWay($order_info->delivery_way);
        $data['logistics']['link_man'] = $order_info->link_man;
        $data['logistics']['mobile'] = $order_info->mobile;
        $data['logistics']['province'] = $order_info->province;
        $data['logistics']['city'] = $order_info->city;
        $data['logistics']['area'] = $order_info->area;
        $data['logistics']['street'] = $order_info->street;
        $data['logistics']['address'] = $order_info->address;
        $data['logistics']['express_name'] = $order_info->express_name;
        $data['logistics']['express_no'] = $order_info->express_no;

        $data['aftersale']['aftersale_id'] = $aftersale_id;
        $data['aftersale']['img_proof1'] = QINIU_URL.$aftersale->img_proof1;
        $data['aftersale']['img_proof2'] = QINIU_URL.$aftersale->img_proof2;
        $data['aftersale']['img_proof3'] = QINIU_URL.$aftersale->img_proof3;
        return $data;
    }
}