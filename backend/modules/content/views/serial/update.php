<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Serial */

$this->title = '更新期资讯: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '期资讯列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="serial-update">
    <?php
    echo TabsX::widget([
        'items' => [
            [
                'label' => '期资讯',
                'content' => $this->render('update_serial', [
                    'model' => $model,
                    'serial_brand_model' => $serial_brand_model,
                    'serial_brand_data'=>$serial_brand_data
                ]),
                'active' => true
            ],
            [
                'label' => '期资讯商品',
                'content' => $this->render('update_serial_goods', [
                    'model' => $serial_good_model,
                    'serial_id' => $serial_id,
                    'dataProvider' => $serial_good_data_provider,
                ]),
            ],
            [
                'label' => '期咨询内容',
                'content' => $this->render('update_serial_content', [
                    'model' => $serial_content_model,
                    'serial_id' => $serial_id,
                    'dataProvider' => $serial_content_data_provider,
                ]),
            ]
        ],
    ]);
    ?>

</div>

