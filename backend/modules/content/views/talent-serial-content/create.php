<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TalentSerialContent */

$this->title = 'Create Talent Serial Content';
$this->params['breadcrumbs'][] = ['label' => 'Talent Serial Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talent-serial-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
