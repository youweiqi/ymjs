<?php

use common\widgets\link_pager\LinkPager;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\discount\models\search\RedeemCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '兑换码列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redeem-code-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增兑换码', ['batch-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => '75'],
                ],

                'promotion.name',
                'redeem_code',
                'remark',
                'usable_times',
                'used_times',
                'start_date',
                'end_date',
            ],
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => '导出兑换码',
                'class' => 'btn btn-success'
            ],
            'exportConfig' =>[
                ExportMenu::FORMAT_HTML=> false,
                ExportMenu::FORMAT_CSV=> false,
                ExportMenu::FORMAT_TEXT=> false,
                ExportMenu::FORMAT_PDF=> false,
                ExportMenu::FORMAT_EXCEL=> false,
            ],
            'target'=>ExportMenu::TARGET_SELF,
            'filename'=>$this->title.date("Y-m-d H:i:s"),

        ]). "<hr>\n".
        GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [

            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100'],
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('编辑', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'class' => 'data-update',
                            'data-id' => $key,
                        ]);
                    },

                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url,
                            [
                                'title' => '删除',
                                'aria-label' => '兑换码删除',
                                'data-confirm' => '你确认删除该兑换码么?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'data-id' => $key,
                            ]);
                    },
                ],
            ],

            'id',
            'promotion.name',
            'redeem_code',
            'remark',
            'usable_times',
            'used_times',
            'start_date',
            'end_date',



        ],
    ]); ?>
</div>
