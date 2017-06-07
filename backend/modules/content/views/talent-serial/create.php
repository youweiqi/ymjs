<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TalentSerial */

$this->title = 'Create Talent Serial';
$this->params['breadcrumbs'][] = ['label' => 'Talent Serials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talent-serial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
