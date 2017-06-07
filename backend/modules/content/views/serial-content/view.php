<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SerialContent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Serial Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-content-view">

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
            'serial_id',
            'image_path',
            'order_no',
            'jump_style',
            'jump_to',
            'img_width',
            'img_height',
        ],
    ]) ?>

</div>
