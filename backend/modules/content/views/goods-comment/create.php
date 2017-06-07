<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsComment */

$this->title = 'Create Goods Comment';
$this->params['breadcrumbs'][] = ['label' => 'Goods Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
