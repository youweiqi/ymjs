<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Serial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'online_time')->textInput() ?>

    <?= $form->field($model, 'offline_time')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_imgpath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'freerate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'like_count')->textInput() ?>

    <?= $form->field($model, 'see_count')->textInput() ?>

    <?= $form->field($model, 'share_count')->textInput() ?>

    <?= $form->field($model, 'comment_count')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'is_recommend')->textInput() ?>

    <?= $form->field($model, 'is_display')->textInput() ?>

    <?= $form->field($model, 'wx_big_imgpath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wx_small_imgpath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_imgwidth')->textInput() ?>

    <?= $form->field($model, 'cover_imgheight')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
