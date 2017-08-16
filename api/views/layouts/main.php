<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>

</header>

<section>

<div class="leftpanel">
</div>
  <div class="mainpanel">
    <div class="contentpanel">
        <?= Breadcrumbs::widget([
            'homeLink'=>[
                'label' => '<i class="fa fa-home mr5"></i> '.'首页',
                'url' => '/',
                'encode' => false,
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'tag'=>'ol',
            'options' => ['class' => 'breadcrumb breadcrumb-quirk']
        ]) ?>                
        <hr class="darken"> 
        <?= Alert::widget() ?>
        <?=$content ?>
    </div>
    
  </div><!-- mainpanel -->

</section>
<?php
$create_modal_title = isset($this->params['create_modal_title'])?$this->params['create_modal_title']:'';
$update_modal_title = isset($this->params['update_modal_title'])?$this->params['update_modal_title']:'';
$view_modal_title = isset($this->params['view_modal_title'])?$this->params['view_modal_title']:'';
Modal::begin([
    'id'=>'create-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">'.$create_modal_title.'</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'update-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">'.$update_modal_title.'</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'view-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">'.$view_modal_title.'</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
$request_create_url = Url::toRoute('create');
$request_update_url = Url::toRoute('update');
$request_view_url = Url::toRoute('view');
$modal_height = isset($this->params['modal_height'])?$this->params['modal_height']:'550px';
$modal_js = <<<JS
    console.log('js');
JS;
$this->registerJs($modal_js,3);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
