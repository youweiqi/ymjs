<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login">

    <div class="login-box">
        <div class="login-box-title">
            <img src="/images/login/userLogin.png" alt="">
        </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="login-box-user">
        <?= $form->field($model, 'username',[
            'inputOptions' => [
                'placeholder' => '请输入账户',
            ],
        ])->label(false) ?>
        </div>
        <div class="login-box-address">
        <?= $form->field($model, 'password',[
            'inputOptions' => [
                'placeholder' => '请输入密码',
            ],
        ])->passwordInput()->label(false) ?>
        </div>
        <div class="login-box-btn">
            <?= Html::submitButton('登录', ['class' => '', 'name' => 'login-button']) ?>
            <!--<img src="../images/loginBtn.png" alt="">-->
        </div>
        <div class="login-box-tel">
            <p>热线电话：<span class="tel">021-69972601</span></p>
        </div>
    <?php ActiveForm::end(); ?>
      <hr class="invisible">
      <div class="form-group">
      </div>
    </div>
</div><!-- panel -->
<footer>
    <ul class="clear" style="list-style-type: none">
        <li class="li-border"><a href="http://www.jigon.cn/">吉贡关联企业</a></li>
        <li class="li-border">联系我们</li>
        <li><a target="_blank" href="http://www.jigon.cn/">关于贡云</a></li>
    </ul>
    <div>Copyright@2011-2016吉贡(上海)科技股份有限公司版权所有Corporation All Rights Reserved 沪ICP备 16049652号-1</div>
</footer>
  