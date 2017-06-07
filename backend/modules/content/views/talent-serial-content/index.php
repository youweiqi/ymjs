<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\TalentSerialContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Talent Serial Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talent-serial-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Talent Serial Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'talent_serial_id',
            'image_path',
            'order_no',
            'jump_style',
            // 'jump_to',
            // 'img_width',
            // 'img_height',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
