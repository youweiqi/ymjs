<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsService */

$this->title = 'Update Goods Service: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goods-service-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
