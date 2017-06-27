<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\log\models\search\AdminLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => [
            'class'=>'form-inline',
            'role'=> 'form',
            'style'=> 'padding:10px 10px;border:1px solid #FFFFFF;margin-bottom:20px;'
        ],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "<div style='margin:auto 20px'>{label}&nbsp;&nbsp; {input}</div>",
        ]

    ]); ?>

    <?= $form->field($model, 'route')->input('text',['class'=>'form-control input-sm']) ?>

    <?= $form->field($model, 'user_name')->label('用户名')->input('text',['class'=>'form-control input-sm']) ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
