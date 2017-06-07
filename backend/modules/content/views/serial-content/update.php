<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SerialContent */

$this->title = 'Update Serial Content: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Serial Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="serial-content-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
