<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TgLink */

$this->title = 'Create Tg Link';
$this->params['breadcrumbs'][] = ['label' => 'Tg Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
