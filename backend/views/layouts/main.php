<?php

/** @var $this \yii\web\View */
/** @var $content string */
/** @var $context \yii\web\Controller */

use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\models\Menu;
use yii\widgets\Breadcrumbs;

AppAsset::register($this); // 注册前端资源

$context = $this->context;
$route = $context->action->getUniqueId()?:$context->getUniqueId().'/'.$context->defaultAction;
$allMenu = Menu::getMenus($route); // 获取后台栏目
$breadcrumbs = Menu::getBreadcrumbs($route); // 面包屑导航

$this->beginPage();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= Html::encode($this->title) ?> | 欲购购物平台后台管理系统</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php $this->head() ?>
        <link rel="shortcut icon" href="<?=Yii::getAlias('@web/favicon.ico')?>" />
        <script language="JavaScript">
            var BaseUrl = '<?=Yii::getAlias('@web')?>';
        </script>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <?php $this->beginBody() ?>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?=Yii::getAlias('@web')?>" style="text-decoration: none;color:#48C5D4" >
                        <h3 class="logo-default" style="margin-top: 10px;"> <?= env('BACKEND_TITLE')?></h3>
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN MEGA MENU -->
                <!-- BEGIN HORIZANTAL MENU 一级栏目 -->
                <?php echo $this->render('@app/views/layouts/public/menu.php', ['allMenu'=>$allMenu]); ?>
                <!-- END HORIZANTAL MENU -->
                
                <!-- END MEGA MENU -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER 手机版栏目图标 -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?=Yii::getAlias('@web/statics/images/logo.png')?>" />
                                <span class="username username-hide-on-mobile"> <?=Yii::$app->user->identity->username?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><a href="<?=Url::to(['/admin/admin/edit','uid'=>Yii::$app->user->identity->uid])?>"><i class="icon-user"></i> 修改密码 </a></li>
                                <li><a href="#"><i class="icon-lock"></i> 锁屏 </a></li>
                                <li><a href="<?=Url::toRoute('login/logout')?>"><i class="icon-key"></i> 注销 </a></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="<?=Url::toRoute('/login/logout')?>" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER 正文内容 -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar navbar-collapse collapse" >
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- 二级子栏目 -->
                    <?php echo $this->render('@app/views/layouts/public/menu-sub.php', ['allMenu'=>$allMenu]); ?>
                    <!-- END SIDEBAR MENU -->
                    <!--  窄屏幕（手机版）下显示的栏目-->
                    <?php echo $this->render('@app/views/layouts/public/menu-mobile.php', ['allMenu'=>$allMenu]) ?>
                    
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">

                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL 设置界面 -->
                    <!-- <?php //$this->beginContent('@app/views/layouts/public/setting.php') ?>
                    <?php //$this->endContent() ?>-->
                    <!-- END THEME PANEL -->
                    <!-- BEGIN PAGE BAR 快速导航 -->


                    <div class="page-bar" style="margin-bottom: 10px;">
                        <?= Breadcrumbs::widget([
                            'homeLink'=>[
                                'label' => '<i class="fa fa-home mr5"></i>首页 ',
                                'url' => '/',
                                'encode' => false,
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'tag'=>'ol',
                            'options' => ['class' => 'page-breadcrumb breadcrumb-metronic']
                        ]) ?>

                    </div>
                    <?= Alert::widget() ?>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE CONTENT 正文内容 -->
                    <div class="row">
                        <div class="col-md-12">
                            <?=$content?>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->
                    <!-- END PAGE HEADER-->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->

        <div class="page-footer">
            <div class="page-footer-inner">
                2016-<?php echo date('Y') ?> &copy; 吉贡科技 by jioao.cn.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <?php \backend\assets\LayoutAsset::register($this); ?>

        <?php $this->endBody() ?>
        <!-- END PAGE LEVEL PLUGINS -->
    </body>
    <?php
    $create_modal_title = isset($this->params['create_modal_title'])?$this->params['create_modal_title']:'';
    $update_modal_title = isset($this->params['update_modal_title'])?$this->params['update_modal_title']:'';
    $view_modal_title = isset($this->params['view_modal_title'])?$this->params['view_modal_title']:'';
    Modal::begin([
        'id'=>'create-modal',
        'header'=>'<h4 class="modal-title">'.$create_modal_title.'</h4>',
        'options' => [
            'tabindex' => false,
            'style' => 'margin-top:80px',
            'data-backdrop' => 'static',
            'data-keyboard' => false
        ],
    ]);
    Modal::end();
    Modal::begin([
        'id'=>'update-modal',
        'header'=>'<h4 class="modal-title">'.$update_modal_title.'</h4>',
        'options' => [
            'tabindex' => false,
            'style' => 'margin-top:80px',
            'data-backdrop' => 'static',
            'data-keyboard' => false
        ],
    ]);
    Modal::end();
    Modal::begin([
        'id'=>'view-modal',
        'header'=>'<h4 class="modal-title">'.$view_modal_title.'</h4>',
        'options' => [
            'tabindex' => false,
            'style' => 'margin-top:80px',
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
    $('#data-create').on('click', function () {
        $('.modal-body').html('');
        $('#create-modal').find('.modal-body').css('height','{$modal_height}');
        $('#create-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_create_url}',
            function (data) {
                $('#create-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-update').on('click', function () {
        $('.modal-body').html('');
        $('#update-modal').find('.modal-body').css('height','{$modal_height}');
        $('#update-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_update_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#update-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-view').on('click', function () {
        $('.modal-body').html('');
        $('#view-modal').find('.modal-body').css('height','{$modal_height}');
        $('#view-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_view_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#view-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
    $this->registerJs($modal_js,3);
    ?>

</html>
<?php $this->endPage() ?>