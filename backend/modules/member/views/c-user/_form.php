<?php

use backend\libraries\MemberLib;
use common\helpers\ArrayHelper;
use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuser-form">

    <?php $form = ActiveForm::begin([
        'id' => 'cuser_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <div style="width:100%;height:30px;background-color:#D8DCE3;line-height:30px;color:#696C75;padding-left:20px;margin-bottom:10px;">基本信息</div>

    <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'nick_name')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'user_name')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'parent_user_id')->widget(Select2::classname(), [
        'data' => isset($parent_user_name)?$parent_user_name:[],
        'disabled' => true,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/member/c-user/search-user']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>
    <?= $form->field($model, 'root_user_id')->widget(Select2::classname(), [
        'data' => isset($root_user_name)?$root_user_name:[],
        'disabled' => true,
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/member/c-user/search-user']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>
    <?php
    if($model->role_id != 3){
        echo $form->field($model, 'role_id')->radioList(['1'=>'普通用户','2'=>'小分销商','3'=>'大分销商']);
    }
    ?>
    <?php
    switch ($model->role_id)
    {
        case 1:
            echo '<div id="role" style="display: none;">';
            echo $form->field($model, 'talent_effect_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo $form->field($model, 'talent_failure_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo '</div>';
            echo '<div id="commission" style="display: none">';
            echo $form->field($model->user_commission, 'commission')->textInput() ;
            echo $form->field($model->user_commission, 'indirect_commission')->textInput() ;
            echo '</div>';
            break;
        case 2:
        {
            echo '<div id="role" style="display: none;">';
            echo $form->field($model, 'talent_effect_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo $form->field($model, 'talent_failure_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo '</div>';
            echo '<div id="commission" style="display: none;">';
            echo $form->field($model->user_commission, 'commission')->textInput() ;
            echo $form->field($model->user_commission, 'indirect_commission')->textInput() ;
            echo '</div>';
            break;
        }
        case 3:{
            echo '<div id="role" style="display: none;">';
            echo $form->field($model, 'talent_effect_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo $form->field($model, 'talent_failure_time')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => ''],
                'removeButton' => false,
                'pluginOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'autoclose' => true,
                    'startDate' => date('Y-m'),
                    'minView' => 1,
                    'format' => 'yyyy-mm-dd hh:00:00'
                ]
            ]);
            echo '</div>';

            echo '<div id="commission" style="display: block">';
            echo $form->field($model->user_commission, 'commission')->textInput() ;
            echo $form->field($model->user_commission, 'indirect_commission')->textInput() ;
            echo '</div>';
            break;

        }
    }
        ?>



    <?= $form->field($model, 'lock_status')->radioList(['0'=>'冻结','1'=>'激活']) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<<JS
$('body').on('click',"#cuser-role_id",function(){
        var role_id =$(this).find("input[type='radio']:checked").val();
        reChangeOpenFlashExpress1(role_id);
});
    function reChangeOpenFlashExpress1(role_id){
        switch (role_id){
            case '1':{
                        
                $("#role").hide();
                $("#commission").hide();
                break;
            }case '2':{
                 $("#role").hide();
                $("#commission").hide();
                break;
            }case '3':{
                 $("#role").hide();
                $("#commission").show();
                break;
            }
        }
        
    }
JS;

$this->registerJs($js);
?>
