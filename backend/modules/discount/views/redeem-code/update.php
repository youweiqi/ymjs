<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RedeemCode */

$this->title = 'Update Redeem Code: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redeem Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="redeem-code-update">

    <?= $this->render('_form', [
        'model' => $model,
        'promotion_data' => $promotion_data,
    ]) ?>

</div>
