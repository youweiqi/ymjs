<?php
namespace frontend\widget;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\GoodsAppRecord;
use Yii;
class ShoppingCartWidget extends Widget
{
    public $goods_num;

    public function init()
    {
        $app = Yii::$app->user->getIdentity();
        parent::init();
        $this->goods_num = $app?GoodsAppRecord::getGoodsNumByAppId($app->app_id):0;
    }

    public function run()
    {
        return $this->goods_num;
    }
}