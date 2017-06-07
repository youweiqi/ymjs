<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TalentSerialGoods */

$this->title = 'Create Talent Serial Goods';
$this->params['breadcrumbs'][] = ['label' => 'Talent Serial Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talent-serial-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
