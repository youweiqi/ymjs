<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Team */

$this->title = '添加小组成员';
$this->params['breadcrumbs'][] = ['label' => 'Team User Relations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
