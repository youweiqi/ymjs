<?php

use common\models\Warehouse;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Logistics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logistics-form">

    <?php $form = ActiveForm::begin([
        'id' => 'team-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-4'>{input}</div><div>{hint}</div><div class='col-sm-4 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_all_warehouse')->radioList(['0'=>'单个仓库','1' => '全部仓库']) ?>

    <?= $form->field($model, 'warehouse_id')->dropDownList(Warehouse::find()->select(['name','id'])->indexBy('id')->column()) ?>

    <div class="form-group" style="text-align:center">
        <button id="submit_form_btn" class="btn btn-success" style="margin-right: 20px">保存</button>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
