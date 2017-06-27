<?php

use backend\libraries\BrandLib;
use backend\libraries\CategoryLib;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\modules\goods\models\form\SetCategoryForm */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="member-journal-add-form">

<?php $form = ActiveForm::begin([
    'id' => 'category_form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['set-brand-validate-form']),
    'options' => [
        'class'=>'form-horizontal',
        'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
    ],
    'fieldConfig' => [
        'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

    ]
]); ?>

<?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

        <?= $form->field($model, 'brand_id')->label('品牌')->dropDownList(ArrayHelper::map(BrandLib::getBrand(),'id','name_cn'),
            [
                'prompt' => '请选择品牌',
            ]) ?>

        <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

<?php ActiveForm::end(); ?>


