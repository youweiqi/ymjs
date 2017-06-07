<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\TalentSerialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Talent Serials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talent-serial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Talent Serial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'label_name',
            'image_path',
            'like_count',
            // 'see_count',
            // 'comment_count',
            // 'share_count',
            // 'talent_id',
            // 'create_time',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
