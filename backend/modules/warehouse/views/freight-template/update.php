<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FreightTemplate */

$this->title = 'Update Freight Template: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Freight Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="freight-template-update">

    <?= $this->render('_form', [
        'model' => $model,
        'province_form' => $province_form,
    ]) ?>

</div>
