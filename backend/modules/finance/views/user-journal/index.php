<?php

use common\models\UserJournal;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\finance\models\search\UserJournalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员提现';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<p>
    <?= Html::a('批量审核', '#', [
        'class' => 'btn btn-success  gridview',
        'id' => 'data-batch-update',
    ]); ?>
</p>
<div class="user-journal-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'options'=>[
            'class'=>'grid-view',
            'style'=>'overflow:auto',
            'id'=>'grid'

        ],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',
                'name'=>'id'],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'c_user.user_name',
            'type',
            [
                'attribute'=>'money',
                'value'=>function ($model) {
                    return $model->money/100;
                },
            ],
            [
                'attribute' => 'bank_id',
                'value' => 'c_user_bank.bank_name',
            ],
            [
                'attribute' => 'bank_id',
                'label'=>'银行卡',
                'value' => 'c_user_bank.bank_card',
            ],
            'comment',
            'create_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return UserJournal::dropDown('status', $model->status);
                },
            ],
        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id'=>'batch-update-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
$request_batch_update_url = Url::toRoute('user-journal/batch-update');

$batch_update_modal_js = <<<JS
    
    $('#data-batch-update').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
         if(keys.length>0){
           $('#batch-update-modal').modal('toggle')
            $('#batch-update-modal').find('.modal-header').html('<h4 class="modal-title">批量处理</h4>');
              $.post('{$request_batch_update_url}', { ids: keys },
                    function (data) {
                        $('#batch-update-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });
JS;
$this->registerJs($batch_update_modal_js,3);
?>

