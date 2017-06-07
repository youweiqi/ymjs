<?php

use backend\libraries\ExpressCompanyLib;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'action'=> Url::to(['/order/order-info/delivery','id'=>$model->order_id]),
    'fieldConfig' => [
        'template' => "<div class='col-xs-3 text-right'>{label} :</div><div class='col-xs-6'>{input}</div><div class='col-xs-3'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'order_sn')->textInput(['readonly'=>'readonly']) ?>

<?= $form->field($model, 'link_man')->textInput(['readonly'=>'readonly']) ?>


<?= $form->field($model, 'express_name')->label('物流公司')->dropDownList(ArrayHelper::map(ExpressCompanyLib::getExpressCompanies(),'company_name','company_name'),
    [
        'prompt' => '请选择物流公司',
    ]) ?>

<?= $form->field($model, 'express_no')->textInput() ?>
    <hr>
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>


<?php ActiveForm::end(); ?>