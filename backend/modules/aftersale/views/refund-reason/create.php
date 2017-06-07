<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RefundReason */

$this->title = 'Create Refund Reason';
$this->params['breadcrumbs'][] = ['label' => 'Refund Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-reason-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
