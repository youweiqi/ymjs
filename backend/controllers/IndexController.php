<?php

namespace backend\controllers;

use common\helpers\ArrayHelper;
use common\models\Category;
use common\models\Es;
use Yii;
use yii\elasticsearch\ActiveDataProvider;


/**
 * 后台首页
 * @author longfei <phphome@qq.com>
 */
class IndexController extends BaseController
{
    public function actionIndex()
    {
        //Yii::$app->kafka->send(['i want pa pa pa']);

        return $this->render('index');

    }

    /*
     * $highlight  高亮Es 的匹配结果
     * $keyword  关键字
     *
     *
     */

    public function actionSearch()
    {
       $keyword = htmlspecialchars(Yii::$app->request->get("keyword"));
        $highlight = [
          "pre_tags"=>["<em>"],
          "post_tags"=>["</em>"],
          "fields" =>[
              "name" => new \stdClass(),//空对象
              "goods_code" => new \stdClass(),
              "label_name" => new \stdClass(),
          ]

        ];
        $EsModel= Es::find()->query([
            "multi_match" =>[
                "query" => $keyword,
                "fields" => ["name","goods_code","label_name"]
            ]
        ]);
        $searchModel = $EsModel;
        $dataProvider = $EsModel->highlight($highlight)->all();

        $this->render('@backend/modules/goods/views/goods/index',[
            'dataProvider' =>$dataProvider,
            'searchModel' =>$EsModel
        ]);
    }


    public function GetData()
    {
       $categorys = Category::find()->all();
        $categorys = ArrayHelper::toArray($categorys);
        return $categorys;
    }

    public function GetTree($categorys,$pid)
    {

            $tree = [];
            foreach ($categorys as $category)
            {
                if($category['parent_id']==$pid){
                    $tree[] =$category; //一级分类
                    $tree= array_merge($tree,$this->GetTree($categorys,$category['id']));//循环调用压到对应的一级分类下面
                }
            }
        return $tree;
    }
}
