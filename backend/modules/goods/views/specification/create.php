<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Specification */

$this->title = 'Create Specification';
$this->params['breadcrumbs'][] = ['label' => 'Specifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
