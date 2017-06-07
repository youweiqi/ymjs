<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserJournal */

$this->title = 'Update User Journal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-journal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
