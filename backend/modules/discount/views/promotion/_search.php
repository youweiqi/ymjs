<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\discount\models\search\PromotionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promotion-search">

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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?php  echo $form->field($model, 'status')->dropDownList([''=>'全部','0'=>'禁用','1'=>'启用']) ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
