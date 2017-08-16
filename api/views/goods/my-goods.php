<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<div class="w1024px">
    <div class="breadcrumb-box">
        <ol class="breadcrumb">
            <li><a href="<?=Url::to("/")?>">首页</a></li>
            <li class="active">我的货架</li>
        </ol>
    </div>
    <div class="list-where clear">
        <div class="list-where-left">
            <ul class="clear">
                <li class="active"><a href="javascript:;">最新</a></li>
                <li><a href="javascript:;">销量</a></li>
                <li><a href="javascript:;">佣金</a></li>
                <!--状态class有  price  price-asc price-desc-->
                <li class="price"><a  href="javascript:;">价格</a></li>
            </ul>
        </div>
        <div class="list-where-right">
            <div class="list-where-right-l">

            </div>
            <div class="f-pager">
                <a  class="fp-prev disabled" href="javascript:;"> < </a>
                <span class="fp-text">
                    <b><?=$data['pagination']->getPage()+1?></b>
                    <em>/</em>
                    <i><?=$data['pagination']->getPageCount()?></i>
                </span>
                <a  class="fp-next" href="javascript:;"> > </a>
            </div>
        </div>
    </div>
    <div class="content">
        <ul class="list-content clear">

            <?php foreach ($data['goods'] as $d) {?>
                <li>
                    <a class="img" href="<?=Url::to(["goods/detail","gcode"=>$d['goods_code']])?>" target="_blank">
                        <img src="<?= $d['goods_img'] ?>">
                        <div class="img-price">结算价 ¥<?=$d['settlement_price']?></div>
                    </a>
                    <div class="con-border">
                        <div class="price-box clear">
                            <div class="price">
                                <span>¥</span>
                                <strong><?=$d['goods_price']?></strong>
                            </div>
                                                    <div class="d-right">
                                                        <div class="brokerage">佣金</div>
                                                        <div class="lab-price">¥<?=$d['commission']?></div>
                                                    </div>
                        </div>
                        <h4 class="name"><?=Html::a($d['name'],Url::to(["goods/detail","gcode"=>$d['goods_code']]),['target'=>'_blank'])?></h4>
                        <div class="sales clear">
                                                    <span>销量:28172</span>
                            <span class="f"><?=$d['sale_store_num']?>人正在卖</span>
                        </div>
                    </div>
                    <div class="add-shop-box <?=$d['is_selected']?'disabled':''?>" data="<?=$d['goods_id']?>">
                        <a class="add-shop"  href="javascript:;"><span class="bg"></span><span class="add-shope-box-title"><?=$d['is_selected']?'已上架':'加入购物车'?></span></a>
                    </div>
                </li>
            <?php }?>
        </ul>
        <div class="pagination-box">
            <nav aria-label="Page navigation" style="text-align: center">
                <?php echo LinkPager::widget([
                    'pagination' => $data['pagination'],
                ]);?>
            </nav>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

    });
</script>