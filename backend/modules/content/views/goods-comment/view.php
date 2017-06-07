<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Goods Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-comment-view">

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
            'good_id',
            'user_id',
            'order_detail_id',
            'comment_text:ntext',
            'spec_name',
            'image1',
            'image2',
            'image3',
            'create_time',
            'status',
        ],
    ]) ?>

</div>
