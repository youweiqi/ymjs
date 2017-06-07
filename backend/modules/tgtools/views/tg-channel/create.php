<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TgChannel */

$this->title = '新增渠道';
$this->params['breadcrumbs'][] = ['label' => 'Tg Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-channel-create">

<!--    <h1><?//= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
