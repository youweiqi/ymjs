<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsService */

$this->title = '商品服务';
$this->params['breadcrumbs'][] = ['label' => '商品服务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-service-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
