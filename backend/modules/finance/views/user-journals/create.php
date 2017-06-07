<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserJournal */

$this->title = 'Create User Journal';
$this->params['breadcrumbs'][] = ['label' => 'User Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-journal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
