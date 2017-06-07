<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RedeemCodeLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redeem Code Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redeem-code-log-view">

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
            'redeem_code_id',
            'user_id',
            'create_time',
        ],
    ]) ?>

</div>
