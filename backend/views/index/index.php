<?php
/* ===========================以下为本页配置信息================================= */
/* 页面基本属性 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use Hisune\EchartsPHP\ECharts;

backend\assets\TestAsset::register($this);
$this->title = '安艺宁';
$this->params['title_sub'] = '';
$this->params['breadcrumbs'][] = ['label' => $this->title];
/* 渲染其他文件 */
//echo $this->renderFile('@app/views/public/login.php');
?>
<div class="inventory-form">

<?php  echo $chart->render('index');

?>

    <?php $form = ActiveForm::begin([
    'action' => ['search'],
    'method' => 'get'
]); ?>



   <input align="center" name="keyword" placeholder="查询商品"/>

    <hr>
<div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>










<!-- 定义数据块 -->
<?php $this->beginBlock('test'); ?>
jQuery(document).ready(function() {
    highlight_subnav('index/index'); //子导航高亮
});
<?php $this->endBlock() ?>
<!-- 将数据块 注入到视图中的某个位置 -->
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
