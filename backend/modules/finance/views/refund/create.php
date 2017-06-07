<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AfterSales */

$this->title = 'Create After Sales';
$this->params['breadcrumbs'][] = ['label' => 'After Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="after-sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
