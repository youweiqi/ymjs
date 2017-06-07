<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SerialGoods */

$this->title = 'Create Serial Goods';
$this->params['breadcrumbs'][] = ['label' => 'Serial Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
