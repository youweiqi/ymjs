<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promotion */

$this->title = '更新礼包: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '礼包列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="promotion-update">

    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => '礼包基本信息',
                'content' => $this->render('_form', [
                    'model' => $model,
                ]),


            ],
            [
                'label' => '礼包详情',
                'content' => $this->render('update_promotion_detail', [
                    'promotion_id' => $model->id,
                    'model' => $promotion_detail_model,
                    'dataProvider' => $promotion_detail_data,
                ]),
                'active' => true

            ],


        ],
    ]);
    ?>


</div>
