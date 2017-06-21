<?php
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="import-inventory-form">

    <?php $form = ActiveForm::begin([
        'id' => 'import_inventory_form',
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'import_file')->widget(FileInput::classname(), [
        'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/warehouse/inventory/import-inventory','tag'=>1]),
            'uploadAsync' => true,
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => true,
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, id, index) {
                if(!data.response.status){
                    var err_msg ="";
                    for(var i=0;i < data.response.error_msg.length;i++){
                        err_msg +=data.response.error_msg[i]+"\n";
                    }
                    $("#importinventoryform-import_error").val(err_msg);
                }
             }',
        ]
    ]);
    ?>

    <?= $form->field($model, 'import_error')->textarea(['rows'=>10]) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>