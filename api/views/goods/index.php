<?php
use common\models\GoodsChannel;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
//$this->title = '商品列表';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="head-item-nav w1024px clear">
    <div class="classify">分类</div>
    <a class="item-nav-btn" href="javascript:;">推荐</a>
    <a class="item-nav-btn" href="javascript:;">活动</a>
    <a class="item-nav-btn" href="javascript:;">订单</a>
    <a class="item-nav-btn" href="javascript:;">账户</a>
</div>

<div class="banner-warp">
    <div class="banner-box">
        <!-- Swiper -->
        <div class="swiper-container swiper-container-1">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><a href="javasript:void;" ><img src="images/list/loop1.jpg" alt=""></a></div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-1"></div>
        </div>
        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper('.swiper-container-1', {
                pagination: '.swiper-pagination-1',
                paginationClickable: true,
                loop: true,
                autoplay : 30000
            });
        </script>
    </div>
    <div class="nav-layout">
        <ul>
            <?php foreach ($catesTree as $l1) { ?>
                <li>
                <span class="icon"><img src="images/public/nav_icon.png"></span>
                <span class="text">
                    <?=Html::a($l1['name'],Url::to(["goods/cate","cid"=>$l1['id']]),['target'=>'_blank'])?>
                </span>
                <div class="sub-menus">
                    <?php if (isset($l1['children']) && empty($l1['children']) == false){
                    foreach ($l1['children'] as $l2) { ?>
                        <dl class=''>
                        <dt>
                            <?=Html::a($l2['name'],Url::to(["goods/cate","cid"=>$l2['id']]),['target'=>'_blank'])?>
                        </dt>
                            <dd>
                        <?php if (isset($l2['children']) && empty($l2['children']) == false) {
                            foreach ($l2['children'] as $l3) {?>
                                <?=Html::a($l3['name'],Url::to(["goods/cate","cid"=>$l3['id']]),['target'=>'_blank'])?>
                         <?php   }
                        }?>
                        </dd>
                        </dl>

                    <?php   }
                }?>
                </div>
                </li>
            <?php }?>
            ?>
        </ul>
    </div>
</div>
<script type="text/javascript" src="js/public.js"></script>

<script type="text/javascript">
    $(function () {

    });
</script>
