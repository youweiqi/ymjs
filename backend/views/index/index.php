<?php
/* ===========================以下为本页配置信息================================= */
/* 页面基本属性 */
$this->title = '安艺宁';
$this->params['title_sub'] = '';
$this->params['breadcrumbs'][] = ['label' => $this->title];

/* 渲染其他文件 */
//echo $this->renderFile('@app/views/public/login.php');

/* 加载页面级别JS */
//$this->registerJsFile('@web/static/common/js/app.js');

?>

<div class="site-index">
    <div class="center">
        <p><img alt="" src="/statics/images/first.png"></p>
    </div>
</div>



<!-- 定义数据块 -->
<?php $this->beginBlock('test'); ?>
jQuery(document).ready(function() {
    highlight_subnav('index/index'); //子导航高亮
});
<?php $this->endBlock() ?>
<!-- 将数据块 注入到视图中的某个位置 -->
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
