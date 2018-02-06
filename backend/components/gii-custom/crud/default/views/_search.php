<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
         'action' => ['index'],
         'options' => [
                 'class'=>'form-inline',
                 'role'=> 'form',
                 'method' => 'get',
                 'style'=> 'padding:10px 10px;border:1px solid #FFFFFF;margin-bottom:20px;'
    ],
        'fieldConfig' => [
             'template' => "<div style='margin:auto 20px'>{label}&nbsp;&nbsp; {input}</div>",
    ]

<?php if ($generator->enablePjax): ?>
        'options' => [
            'data-pjax' => 1
        ],
<?php endif; ?>
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
    <div class="" style="margin-top:20px;margin-left:18px">
        <?= "<?= " ?>Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= "<?= " ?>Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
