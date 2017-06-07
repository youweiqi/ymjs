<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-view">

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
            'goods_code',
            'brand_id',
            'name',
            'spec_desc:ntext',
            'service_desc:ntext',
            'label_name',
            'suggested_price',
            'lowest_price',
            'unit',
            'remark:ntext',
            'category_parent_id',
            'category_id',
            'online_time',
            'offline_time',
            'talent_limit',
            'threshold',
            'ascription',
            'talent_display',
            'discount',
            'operate_costing',
            'score_rate',
            'self_support',
            'create_time',
            'wx_small_imgpath',
            'channel',
            'api_goods_id',
        ],
    ]) ?>

</div>
