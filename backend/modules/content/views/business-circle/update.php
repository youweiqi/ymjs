<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessCircle */

$this->title = 'Update Business Circle: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Business Circles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="business-circle-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
