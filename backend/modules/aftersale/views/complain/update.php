<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AfterSales */

$this->title = 'Update After Sales: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'After Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="after-sales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
