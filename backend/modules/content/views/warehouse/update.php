<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Warehouse */

$this->title = 'Update Warehouse: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="warehouse-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
