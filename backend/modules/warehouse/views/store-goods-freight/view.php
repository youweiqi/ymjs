<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StoreGoodsFreight */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Store Goods Freights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-goods-freight-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'store_id',
            'good_id',
            'freight_template_id',
        ],
    ]) ?>

</div>
