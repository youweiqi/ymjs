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
    'validationUrl' => Url::toRoute(['set-category-validate-form']),
    'options' => [
        'class'=>'form-horizontal',
        'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
    ],
    'fieldConfig' => [
        'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

    ]
]); ?>

<?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

        <?= $form->field($model, 'category_parent_id')->label('父分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getParentCategories(),'id','name'),
    [
        'prompt' => '请选择父分类',
    ]) ?>

<?= $form->field($model, 'category_id')->label('子分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getChildCategories($model->category_parent_id),'id','name'),
    [
        'prompt' => '请选择子分类',
    ]) ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

<?php ActiveForm::end(); ?>
        <?php
        $this->registerJs('
    $("#setcategoryform-category_parent_id").change(function() {
        var category_parent_id = $(this).val();
        $("#setcategoryform-category_id").html("<option value=\"0\">请选择子分类</option>");
        if (category_parent_id!=0) {
            getChildCategories(category_parent_id);
        }
    });

    function getChildCategories(category_parent_id)
    {
        var href = "'.Url::to(['/goods/category/get-child-categories']).'";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {category_id : category_parent_id},
            success : function(data) {
                $("#setcategoryform-category_id").append(data);
            }
        });
    }
');
        ?>

