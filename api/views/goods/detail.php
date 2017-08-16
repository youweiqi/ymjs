<?php
use yii\helpers\Url;
use frontend\widget\BreadcrumbsWidget;
?>
<div class="w1024px">
    <div class="breadcrumb-box">
        <ol class="breadcrumb">
        <?=BreadcrumbsWidget::widget(['route'=>'goods/detail','params'=>['goods'=>$goods]])?>
<!--            <li><a href="#">一级分类</a></li>-->
<!--            <li><a href="#">二级分类</a></li>-->
<!--            <li><a href="#">三级分类</a></li>-->
<!--            <li class="active">商品详情</li>-->
        </ol>
    </div>
    <div class="content">
        <div class="detail-header clearfix">
            <div class="left">
                <div class="swiper-container swiper-container-horizontal" id="swiper-detail" >
                    <div class="swiper-wrapper" >
                        <?php foreach ($goods['goodsImages'] as $img){?>
                        <div class="swiper-slide" >
                            <img class="bind-img" src="<?=QINIU_URL.$img?>"></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="obj-rows clearfix">
                    <button type="button" class="Previous"></button>
                    <div class="img-content-b">
                        <div class="img-content clearfix">
                            <?php foreach ($goods['goodsImages'] as $k=>$img){ ?>
                            <div class="img-rows <?=$k==0?'active':''?>">
                                <img class="bind-img" src="<?=QINIU_URL.$img?>">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <button type="button" class="next"></button>
                </div>
            </div>
            <div class="right">
                <h3 class="title"><span>电商</span><?=$goods['name']?></h3>
                <div class="lab-name clearfix">
                    <label>品牌名称：<?=$goods['brand_name']?></label>
                    <span>商品编码：<?=$goods['goods_code']?></span>
                </div>
                <div class="label-tag">
                    <span><img src="../images/detail/biaoshi.png">商品包邮</span>
                    <span><img src="../images/detail/biaoshi.png">商品包邮</span>
                    <span><img src="../images/detail/biaoshi.png">商品包邮</span>
                    <span><img src="../images/detail/biaoshi.png">商品包邮</span>
                </div>
                <div class="date">
                    上架时间：<?=date("Y-m-d",strtotime($goods['online_time']))?>
                    <span>下架时间：<i><?=date("Y-m-d",strtotime($goods['offline_time']))?></i></span>
                </div>
                <div class="clos-box">
                    <div class="clos-3">
                        全国共有<span><?=$goods['supply_stores_num']?></span>家店铺供货
                    </div>
                    <span class="border-span"></span>
                    <div class="clos-3">
                        <span><?=$goods['sale_stores_num']?></span>人正在卖
                    </div>
                    <span class="border-span"></span>
                    <div class="clos-3">
                        销量：<span>28371</span>
                    </div>
                </div>
                <div class="price-box">
                    <div class="text">
                        结算价：
                    </div>
                    <div class="price">
                        <span>¥</span>
                        <strong><?=$goods['settlement_price']?></strong>
                    </div>
                    <div class="icon">
                        <img  src="../images/detail/beizhu.png" data-toggle="tooltip" data-placement="right" title="贡云实时拉取的供应链中最低供应结算价">
                    </div>
                </div>
                <div class="price-box price-box-2" style="">
                    <div class="text">
                        市场价：
                    </div>
                    <div class="price">
                        <span>¥</span>
                        <strong><?=$goods['goods_price']?></strong>
                    </div>
                </div>

                <div class="submit-btn">
                    <!--带有（disabled）Class 已上架-->
                    <button data="<?=$goods['id']?>" class="add-shop-btn <?= $goods['is_select']?"disabled":""?>" type='submit' id="submitId"></button>
                </div>
            </div>
        </div>
        <script>
            var mySwiper = new Swiper('#swiper-detail',{});
            var $img= $(".img-rows");
            var $length =$img.length-1;

            $('.Previous').click(function(){
                var $index = $(".img-rows.active").index();
                if(($index-1)==0 || $index==0){
                    $(this).removeClass('active');
                }
                if($index>0){
                    $img.eq($index).removeClass('active');
                    $img.eq($index-1).addClass('active');
                    mySwiper.slideTo($index-1, 1000, false);
                    if($length>3 &&$index==4){
                        //不低于4张图片
                        $(".img-content").animate({left:'0px'});
                    }
                }
                if($length>0){
                    //不低于1张
                    $('.next').addClass('active');
                }
            });
            $('.next').click(function(){
                var $index = $(".img-rows.active").index();
                if(($index+1)==$length || $index==$length){
                    $(this).removeClass('active');
                }
                if($index<$length){
                    $img.eq($index).removeClass('active');
                    $img.eq($index+1).addClass('active');
                    mySwiper.slideTo($index+1, 1000, false);
                    if($length>3 &&$index==3){
                        //不低于4张图片
                        $(".img-content").animate({left:'-332px'});
                    }
                }
                if($length>0){
                    //不低于1张
                    $('.Previous').addClass('active');
                }
            });
            $img.click(function () {
                var _index = $(this).index();
                $(".img-rows.active").removeClass('active');
                $(this).addClass('active').siblings().removeClass('active');
                mySwiper.slideTo(_index, 1000, false);
                if(_index==0){
                    $('.Previous').removeClass('active');
                }else if(_index==$length){
                    $('.next').removeClass('active');
                }
            });
            window.onload = function () {
                if($length>3){$('.next').addClass('active');}
                $('[data-toggle="tooltip"]').tooltip()
            };
        </script>
        <!--货品-->
        <div class="border-title">
            <img src="../images/detail/suoyouhuopin.png">
        </div>
        <div class="bs-example" data-example-id="striped-table">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th >货号</th>
                    <?php
                    $specificationInfo = json_decode($goods['spec_desc'],1);
                    foreach ($specificationInfo as $s)//渲染规格名称
                    {
                        echo "<th >{$s['name']}</th>";
                    }
                    ?>
                    <th>库存</th>
                    <th>售价</th>
                    <th >佣金</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($goods['products'] as $p){ ?>
                <tr>
                    <td><?=$p['product_bn']?></td>
                    <?php
                    foreach ($specificationInfo as $s)//渲染规格值
                    {
                        echo "<td >";
                        if(isset($p['spec_detail'][$s['specificationId']])&&isset($p['spec_detail'][$s['specificationId']]['image'])){
                            $url = $p['spec_detail'][$s['specificationId']]['image']!=''?QINIU_URL.$p['spec_detail'][$s['specificationId']]['image']:'';
                            if($url !== '')
                            {
                                echo "<img src='{$url}'/>";
                            }
                            echo $p['spec_detail'][$s['specificationId']]['value']??'';
                        }
                        echo "</td>";

                    }
                    ?>
<!--                    <td><img src="../images/detail/img2.jpg"/>白色</td>-->
<!--                    <td>S</td>-->
                    <td><?=$p['inventory_num']>0 ?$p['inventory_num']: '缺货'?></td>
                    <td><?php
                        if ($p['inventory_num']>0){//如果缺货价格显示/
                            echo '¥'.$p['sale_price'];
                        }else{
                            echo "/";
                        }
                        ?></td>
                    <td class="price"><?php
                        if($p['inventory_num']>0)
                        {
                            echo "¥".$p['commission'];
                        }else{
                            echo "/";
                        }
                        ?>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!--/货品-->
        <!--详情-->
        <div class="border-title">
            <img src="../images/detail/shangpinxiangqing.png">
        </div>
        <div class="detail-box">
            <?php foreach ($goods['detail_images'] as $img){?>
            <p><img src="<?=QINIU_URL.$img?>"></p>
            <?php }?>
        </div>
        <!--/详情-->
    </div>
</div>
<div class="add-shop-flex">
    <!--带有（disabled）Class 已上架-->
    <button type="button" data="<?=$goods['id']?>" class="flex-add <?= $goods['is_select']?"disabled":""?>"></button>
</div>
<script type="text/javascript" src="../js/public.js"></script>
<script type="text/javascript">
    $(function () {

    });
</script>
<?php
$api_url = Url::to(["goods/add"]);
$js = <<<JS
$(function () {
        $('.add-shop-btn,.flex-add').click(function () {
            var _this = $(this);
            var goods_id = _this.attr('data');
            $.ajax({
                url: "$api_url",
                method: "POST",
                data: { goods_id : goods_id },
                dataType: 'json'
            }).success(function (data) {
                    if(data.status == 'succ')
                    {
                        $('.add-shop-btn,.flex-add').addClass("disabled");
                    }else{
                        alert('系统错误 请联系管理员');
                    }
                }
            );
        });
});
    
JS;
$this->registerJs($js,3);
?>
