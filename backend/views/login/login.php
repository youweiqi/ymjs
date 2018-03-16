<?php
use yii\captcha\Captcha;

\backend\assets\AppAsset::register($this);
\backend\assets\LoginAsset::register($this);
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
        <title>登录 | OMS管理后台 by jioao.cn</title>
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

    <body class=" login">
    <?php $this->beginBody() ?>
        <!-- BEGIN LOGO -->
        <div class="logo">
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?=\yii\helpers\Url::toRoute('login/login')?>" method="post">
                <h3 class="form-title font-green">欢迎登录OMS管理后台</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> 用户名或密码错误 </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">用户名</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="用户名" name="info[username]" /> 
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">密码</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="密码" name="info[password]" />

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                </div>


                <div class="form-actions">
                    <label class="rememberme check mt-checkbox mt-checkbox-outline" style="padding-left:25px;">
                        <input type="checkbox" name="info[rememberMe]" value="1" checked/>记住我
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right" style="margin-top:-10px;">登录</button>
                </div>
                <div class="create-account"></div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
        <div class="copyright">Copyright &copy; 2016-<?php echo date('Y')?> by 贡云科技. jioao.cn</div>

    <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>