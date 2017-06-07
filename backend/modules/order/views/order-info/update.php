<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */

$this->title = 'Update Order Info: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
