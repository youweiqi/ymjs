<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StoreGoodsFreight */

$this->title = 'Create Store Goods Freight';
$this->params['breadcrumbs'][] = ['label' => 'Store Goods Freights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-goods-freight-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
