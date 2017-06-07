<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SerialGoods */

$this->title = 'Update Serial Goods: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Serial Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="serial-goods-update">

    <?= $this->render('_form', [
        'model' => $model,
        'goods_data' => $goods_data,
    ]) ?>

</div>
