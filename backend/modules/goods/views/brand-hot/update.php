<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BrandHot */

$this->title = 'Update Brand Hot: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Brand Hots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brand-hot-update">

    <?= $this->render('_form1', [
        'model' => $model,
    ]) ?>

</div>
