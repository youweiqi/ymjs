<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;

?>
<style type="text/css">
    .box{
        border: 1px solid #ddd;
        background-color: white;
    }
    .data-con{
        font-size: 14px;
        color: #000;
        text-align: center;
    }
    .data-con-l{
        text-align: left;
    }
    .fontSizeLower{
        font-size: 12px;
    }
    .box input{
        outline: none;
    }
    .box header{
        border-bottom: 1px solid #ddd;
        padding: 2px 0 2px 2px;
    }
    .box header ul li{
        float: left;
        margin-right: 10px;
        border: 1px solid #ddd;
        padding: 4px 10px;
        background: linear-gradient(to bottom, #f9f8f7, #dfe2e2);
        cursor: pointer;
    }
    .box .content{
        padding: 0 20px;
        padding-bottom: 2px;
    }
    .box .content .content-data{
        border: 1px solid #ddd;
        border-top: none!important;
    }

    .box .content .content-data .data-box{
        padding: 2px;
    }
    .box .content .content-data .content-data-name{
        text-align: center;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }
    .box .content .content-data .content-data-box{
        border: 1px solid #ddd;
    }
    .box .content .content-data .content-data-box .data-top .data-top-name,
    .box .content .content-data .content-data-box .data-bottom .data-top-name{
        text-align: left;
        padding: 6px 0 6px 2px;
        border-bottom: 1px solid #ddd;
    }
    .box .content .content-data .content-data-box .data-top .data-top-main,
    .box .content .content-data .content-data-box .data-bottom .data-top-main{
        border-bottom: 1px solid #ddd;
        font-size: 12px;
    }
    .box .content .content-data .content-data-box .data-top .data-top-main>div,
    .box .content .content-data .content-data-box .data-bottom .data-top-main>div{
        float: left;
        line-height: 37px;
    }
    .box .content .content-data .content-data-box .data-top .data-top-main>div .content-n,
    .box .content .content-data .content-data-box .data-bottom .data-top-main>div .content-n{
        padding: 0 20px;
        display: inline-block;
        border-right: 1px solid #ddd;
    }
    .box .content .content-data .content-data-box .data-top .data-top-main>div .content-inp,
    .box .content .content-data .content-data-box .data-bottom .data-top-main>div .content-inp{
        display: inline-block;
        border-right: 1px solid #ddd;
        width: 75px;
    }
    .box .content .content-data .content-data-box .data-top .data-top-main>div .content-inp input,
    .box .content .content-data .content-data-box .data-bottom .data-top-main>div .content-inp input{
        color: #000;
        width: 100%;
        border: none;
        text-align: center;
        outline: none;
    }
    .box .content .content-data .content-data-box .data-bottom .data-bottom-beizhu{
        font-size: 12px;
    }
    .box .content .content-data .content-data-box .data-bottom .data-bottom-beizhu>div{
        float: left;
    }
    .box .content .content-data .content-data-box .data-bottom .data-bottom-beizhu .order-beizhu span{
        float: left;
    }
    .box .content .content-data .content-data-box .data-bottom .data-bottom-beizhu .order-beizhu .beizhu-n{
        display: inline-block;
        line-height: 38px;
        padding: 0 20px;
        border-bottom: 1px solid #ddd;
    }
    .box .content .content-data .content-data-box .data-bottom .data-bottom-beizhu .order-beizhu .beizhu-con{
        border-left:1px solid #ddd;
        border-right:1px solid #ddd;
        padding: 10px  10px 3px 10px;
        width: 310px;
        line-height: 20px;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient:vertical;
        -webkit-line-clamp:6;
        overflow: hidden;
        font-size: 14px;
    }
    /*  /基本信息 结束  */
    .box .content .data2-box .content2-data2-box{
        display: -webkit-box;
        display: flex;
    }
    .box .content .data2-box .content2-data2-box input{
        /*font-size: 12px;*/
    }
    .box .content .data2-box .content2-data2-box .data2-box-con{
        -webkit-box-flex: 1;
        flex: 1;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div,
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom>div{
        float: left;
    }
    .box .content .data2-box{
        padding: 2px;
    }
    .box .content .data2-box .content2-data2-box{
        border: 1px solid #ddd;
    }
    .box .content .data2-box .content2-data2-box .data2-box-img .img2{
        width: 100px;
        height: 100px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-img .img2-n{
        width: 100px;
        text-align: center;
        line-height: 37px;
        border-right: 1px solid #ddd;
        font-size: 12px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-img .img2{
        border: 1px solid #ddd;
        border-left:none;
        border-bottom: none;
    }
    .box .content .data2-box .content2-data2-box .data2-box-img .img2 img{
        width: 100%;
        height: 100%;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .con2-inf{
        text-align: center;
        line-height: 37px;
        border-bottom: 1px solid #ddd;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top{
        border-bottom: 1px solid #ddd;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-n{
        display: inline-block;
        line-height: 37px;
        padding: 0 20px;
        border-right: 1px solid #ddd;
        font-size: 12px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp-1{
        width: 140px;
        display: inline-block;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp-2{
        display: inline-block;
        width: 140px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp-3{
        display: inline-block;
        width: 66px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp-1 input{

    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp{
        border-right: 1px solid #ddd;
        line-height: 37px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-top>div .con2-inp input{
        width: 100%;
        text-align: center;
        border: none;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom span{
        line-height: 37px;
        display: inline-block;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom{
        border-bottom: 1px solid #ddd;
    }

    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom .con2-bottom-n{
        padding: 0 20px;
        border-right: 1px solid #ddd;
        font-size: 12px;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom .con2-bottom-inp{
        border-right: 1px solid #ddd;
    }
    .box .content .data2-box .content2-data2-box .data2-box-con .box-con2-bottom input{
        width: 100%;
        border:none;
        text-align: center;
    }
    /* 货品信息结束 */
    .box .content .data3-box{
        padding: 2px;
    }
    .box .content .data3-box .content3-data3-box{
        border: 1px solid #ddd;
    }
    .box .content .data3-box .content3-data3-box .data3-n1{
        line-height: 37px;
        padding-left: 4px;
        border-bottom: 1px solid #ddd;
    }
    .box .content .data3-box .content3-data3-box .box3-con{
        display: -webkit-box;
        display: flex;
        font-size: 12px;
        border-bottom: 1px solid #ddd;
    }
    .box .content .data3-box .content3-data3-box .box3-con span{
        display: inline-block;
    }
    .box .content .data3-box .content3-data3-box .box3-con .data3-box-n{
        line-height: 37px;
        padding: 0 20px;
        border-right: 1px solid #ddd;
    }
    .box .content .data3-box .content3-data3-box .box3-con div .data3-box-inp{
        border-right: 1px solid #ddd;
        line-height: 37px;
    }
    .box .content .data3-box .content3-data3-box .box3-con input{
        width: 100%;
        text-align: center;
        border: none;
        /*font-size: 12px;*/
    }
    .box .content .data3-box .content3-data3-box .box3-con-address{
        border-bottom: 1px solid #ddd;
        display: -webkit-box;
        display: flex;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address{
        display: inline-block;
        padding: 0 32px;
        border-right: 1px solid #ddd;
        line-height: 37px;
        font-size: 12px;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp{
        height: 37px;
        -webkit-box-flex: 1;
        flex: 1;
        display: -webkit-box;
        display: flex;
        padding-left: 35px;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp .select1{
        display: inline-block;
        width: 140px;
        line-height: 37px;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp .select1 .con1{
        display: inline-block;
        width: 90px;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp .select1 .con1 input{
        display: inline-block;
        width: 100%;
        border: none;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp .inp1{
        -webkit-box-flex: 1;
        flex: 1;
        display: inline-block;
        line-height: 37px;
    }
    .box .content .data3-box .content3-data3-box .box3-con-address .address-inp .inp1 input{
        display: inline-block;
        width: 100%;
        text-align: left;
        border: none;
    }
    .box .content .data3-box .content3-data3-box .box3-con .wuliu-n{
        border-right: none;
    }

    .box .content .data3-box .content3-data3-box .data3-con-box>div{
        float: left;
    }
    .box .content .data3-box .content3-data3-box .data3-con-box .box3-con3{
        border-bottom: none;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf{
        border-left: 1px solid #ddd;
        position: relative;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf .btn{
        display: inline-block;
        padding: 10px 20px;
        font-size: 13px;
        border: 1px solid #ddd;
        border-radius: 2px;
        cursor: pointer;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf .wuliu-con{
        padding:10px 0 10px 6px ;
        position: absolute;
        left: 0;
        top: 37px;
        background: white;
        width: 194px;
        border: 1px solid #ddd;
        display: none;
        height: 200px;
        overflow-y: scroll;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf .wuliu-con.active{
        display: block;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf .wuliu-con li{
        padding: 10px 0;
        position: relative;
    }
    .box .content .data3-box .content3-data3-box .wuliu-inf .wuliu-con li .p1{
        margin-bottom: 3px;
    }
    .box .content .content4-data .img-box{
        display: -webkit-box;
        display: flex;
        padding: 2px;
        justify-content:flex-start;
    }
    .box .content .content4-data .img-box>div{
        width: 200px;
        height: 200px;
        border: 1px solid #ddd;
        padding: 2px;
        align-self:flex-start;
    }
    .box .content .content4-data .img-box .img2{
        margin: 0 10px;
    }
    .box .content .content4-data .img-box>div img{
        width: 100%;
        height: 100%;
    }

    ol,ul,li { list-style-type:none; }
    .clearFix::after{content: "";clear:both;display: block;  }
</style>
<div class="box">
    <header>
        <ul class='clearFix' >
            <li  onclick="showContent(<?php echo $data['aftersale']['aftersale_id']?>,'0')">订单信息</li>
            <li  onclick="showContent(<?php echo $data['aftersale']['aftersale_id']?>,'1')">货品信息</li>
            <li  onclick="showContent(<?php echo $data['aftersale']['aftersale_id']?>,'2')">物流信息</li>
            <li  onclick="showContent(<?php echo $data['aftersale']['aftersale_id']?>,'3')">退货图片</li>
        </ul>
    </header>
    <div class="content">
        <!--订单信息-->
        <div id="content-1" class="content-data">
            <p class="content-data-name">订单信息</p>
            <div class="data-box">
                <div class="content-data-box">
                    <div class="data-top">
                        <p class="data-top-name">商品价格</p>
                        <div class="data-top-main clearFix">
                            <div class="shoujia">
                                <span class="content-n">商品售价:</span>
                                <span class="content-inp data-con">
                                <?php echo $data['order']['total_price'] ?>

                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">平均优惠券抵扣额:</span>
                                <span class="content-inp data-con">
                                 <?php echo $data['order']['promotion_discount'] ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="data-bottom">
                        <p class="data-top-name">订单其他信息</p>
                        <div class="data-top-main clearFix">
                            <div class="shoujia">
                                <span class="content-n">支付方式:</span>
                                <span class="content-inp data-con" style="width: 90px">
                                    <?php echo $data['order']['pay_type'] ?>

                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">是否发票:</span>
                                <span class="content-inp data-con" style="width: 30px;">
                                    <?php echo $data['order']['is_bill'] ?>

                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">发票类型:</span>
                                <span class="content-inp data-con" style="width: 100px;">
                                    <?php echo $data['order']['bill_type'] ?>

                                </span>
                            </div>
                            <div class="pingjun">
                                <span class="content-n">发票抬头:</span>
                                <span class="content-inp data-con" style="width: 225px">
                                    <?php echo $data['order']['bill_header'] ?>

                                </span>
                            </div>
                        </div>
                        <div class="data-bottom-beizhu clearFix">
                            <div class="order-beizhu clearFix">
                                <span class="beizhu-n">客户留言:</span>
                                <span class="beizhu-con" style="height: 120px">
                                    <?php echo $data['order']['remark'] ?>

                                </span>
                            </div>
                            <div class="order-beizhu clearFix">
                                <span class="beizhu-n" style="padding: 0 22px">后台备注:</span>
                                <span class="beizhu-con" style="height: 120px">
                                    <?php echo $data['order']['back_remark'] ?>

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
                        <p class="img2"><img src="<?php echo $data['product']['product_img'] ?>" alt=""></p>
                    </div>
                    <div class="data2-box-con">
                        <div class="con2-inf">信息详情</div>
                        <div class="box-con2-top clearFix">
                            <div class="con2-top-1">
                                <span class="con2-n">名称：</span>
                                <span class="con2-inp con2-inp-1 data-con"><?php echo $data['product']['goods_name'] ?>
</span>
                            </div>
                            <div class="con2-top-2">
                                <span class="con2-n">货号：</span>
                                <span class="con2-inp con2-inp-2 data-con"><?php echo $data['product']['product_bn'] ?></span>
                            </div>
                            <div class="con2-top-3">
                                <span class="con2-n">数量：</span>
                                <span class="con2-inp con2-inp-3 data-con"><?php echo $data['product']['quantity'] ?></span>
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
                            <span class="data3-box-inp" style="width: 120px"><?php echo $data['logistics']['delivery_way'] ?></span>
                        </div>
                        <div>
                            <span class="data3-box-n">收件人：</span>
                            <span class="data3-box-inp" style="width: 120px"><?php echo $data['logistics']['link_man'] ?></span>
                        </div>
                        <div>
                            <span class="data3-box-n">收件人电话：</span>
                            <span class="data3-box-inp" style="width: 120px"><?php echo $data['logistics']['mobile'] ?></span>
                        </div>
                    </div>
                    <div class="box3-con-address">
                        <span class="address">地址：</span>
                        <span class="address-inp" style="width: 592px;">
                            <span class="select1">
                                <span class="fontSizeLower">省:</span>
                                <span class="con1 data-con data-con-l"><?php echo $data['logistics']['province'] ?></span>
                            </span>
                            <span class="select1">
                                <span class="fontSizeLower">市:</span>
                                <span class="con1 data-con data-con-l"><?php echo $data['logistics']['city'] ?></span>
                            </span>
                            <span class="select1">
                                <span class="fontSizeLower">区:</span>
                                <span class="con1 data-con data-con-l"><?php echo $data['logistics']['area'] ?></span>
                            </span>
                            <span class="inp1 data-con data-con-l">
                                <?php echo $data['logistics']['address'] ?>
                            </span>
                        </span>
                    </div>
                    <div class="data3-n1">物流详情</div>
                    <div class="data3-con-box clearFix">
                        <div class="box3-con box3-con3">
                            <div>
                                <span class="data3-box-n">物流公司：</span>
                                <span class="data3-box-inp data-con" style="width: 120px"><?php echo $data['logistics']['express_name'] ?></span>
                            </div>
                            <div>
                                <span class="data3-box-n">物流单号：</span>
                                <span class="data3-box-inp data-con" style="width: 160px"><?php echo $data['logistics']['express_no'] ?></span>
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
                    <img src="<?php echo $data['aftersale']['img_proof1'] ?>" alt="">
                </div>
                <div class="img2">
                    <img src="<?php echo $data['aftersale']['img_proof2'] ?>" alt="">
                </div>
                <div class="img3">
                    <img src="<?php echo $data['aftersale']['img_proof3'] ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showContent(id,index){
        if(id && index){
            $("#tdid"+id+" .content").find("div.content-data").eq(index).show().siblings().hide();
        }
    }
</script>

