<?php
namespace frontend\widget;
use common\models\Goods;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;
use common\models\Category;
use yii\helpers\Url;

class BreadcrumbsWidget extends Widget
{
    public $route;
    public $html;
    public $params;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        switch ($this->route)
        {
            case "goods/cate":
                $this->getCateBreadcrumbs();
                break;
            case "goods/detail":
                $this->getDetailBreadcrumbs();
                break;
            case "goods/my-goods":
                break;
            case "goods/search":
                $this->getSearchBreadcrumbs();
                break;
        }
        return $this->html;
    }

    private function getCateBreadcrumbs()
    {
        $cid = Yii::$app->request->get('cid');
        $category = Category::findOne($cid);
        if(!$category)
        {
            $this->html = '';
            return;
        }
        switch ($category->deep)
        {
            case 3:
            {
                $html = '<li class="active">'.$category->name.'</li>';//三级
                $secondCate = Category::findOne($category->parent_id);
                $html = '<li><a href="'.Url::to(["goods/cate","cid"=>$secondCate->id]).'">'.$secondCate->name.'</a></li>'.$html;//加二级
                $firstCate = Category::findOne($secondCate->parent_id);
                $this->html = '<li><a href="'.Url::to(["goods/cate","cid"=>$firstCate->id]).'">'.$firstCate->name.'</a></li>'.$html;//加一级
                break;
            }
            case 2:
            {
                $html = '<li class="active">'.$category->name.'</li>';//二级
                $secondCate = Category::findOne($category->parent_id);
                $this->html = '<li><a href="'.Url::to(["goods/cate","cid"=>$secondCate->id]).'">'.$secondCate->name.'</a></li>'.$html;//一级this->
                break;
            }
            case 1:
            {
                $this->html = '<li class="active">'.$category->name.'</li>';//一级
                break;
            }
        }
    }

    private function getDetailBreadcrumbs()
    {
        /** @var Goods $goods */
        $goods = $this->params['goods'];
        $category = Category::findOne($goods['category_id']);
        $html = '<li class="active">'.$goods['name'].'</li>';//商品
        switch ($category->deep)
        {
            case 3:
            {
                $html = '<li><a href="'.Url::to(["goods/cate","cid"=>$category->id]).'">'.$category->name.'</a></li>'.$html;//加三级级
                $secondCate = Category::findOne($category->parent_id);
                $html = '<li><a href="'.Url::to(["goods/cate","cid"=>$secondCate->id]).'">'.$secondCate->name.'</a></li>'.$html;//加二级
                $firstCate = Category::findOne($secondCate->parent_id);
                $this->html = '<li><a href="'.Url::to(["goods/cate","cid"=>$firstCate->id]).'">'.$firstCate->name.'</a></li>'.$html;//加一级
                break;
            }
            case 2:
            {
                $html = '<li class="active">'.$category->name.'</li>';//二级
                $secondCate = Category::findOne($category->parent_id);
                $this->html = '<li><a href="'.Url::to(["goods/cate","cid"=>$secondCate->id]).'">'.$secondCate->name.'</a></li>'.$html;//一级this->
                break;
            }
            case 1:
            {
                $this->html = '<li class="active">'.$category->name.'</li>';//一级
                break;
            }
        }
    }

    private function getSearchBreadcrumbs()
    {
        $keyword = $this->params['keyword'];
        $this->html = '<li class="active"><a href="'.Url::to(["goods/search","keyword"=>$keyword]).'">搜索"'.$keyword.'"</a></li>';
    }


}