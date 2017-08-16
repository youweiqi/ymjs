<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use frontend\widget\ShoppingCartWidget;
//use frontend\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>供货</title>
    <?php $this->head() ?>
</head>
<body class="home">
<?php $this->beginBody() ?>

<div class="navbar-wrapper">
    <header class="header w1024px clear">
        <div class="left">
            <a href="<?=Url::to('/')?>"><img class="logo" src="/images/public/logo.png"></a>
        </div>
        <div class="cen">
            <form name="searchForm" action="<?=Url::to("/goods/search")?>" method="get" >
                <div class="search-box clear">
                    <div class="icon"><img src="/images/public/search_icon.png"></div>
                    <span class="keyword"><input type="text" name="keyword" value="<?=$this->params['keyword']??''?>" autocomplete="off" placeholder="请输入商品名称或商品编码"></span>
                    <span class="submit-btn"><button type="submit" class="search-btn">搜索</button></span>
                </div>
            </form>
        </div>
        <div class="right">
            <a class="shop-num-show" href="<?=Url::to("/goods/my-goods")?>">
                <img src="/images/public/my_shelf_icon.png">
            </a>
            <span class="num"><?=ShoppingCartWidget::widget()?></span>
        </div>
    </header>
</div>
<?= $content ?>

<div style="padding-top: 100px"></div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

