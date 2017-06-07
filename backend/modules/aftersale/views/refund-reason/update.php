<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RefundReason */

$this->title = 'Update Refund Reason: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-reason-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
