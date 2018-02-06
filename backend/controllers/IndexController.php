<?php

namespace backend\controllers;

use backend\components\Foo;
use backend\components\MailEvent;
use backend\components\MyBehavior;
use common\helpers\ArrayHelper;
use common\models\Category;
use common\models\Es;
use Yii;
use yii\elasticsearch\ActiveDataProvider;
use yii\filters\VerbFilter;


/**
 * 后台首页
 * @author longfei <phphome@qq.com>
 */
class IndexController extends BaseController
{
    const SEND_MAIL='sendMail';

    public function init()
    {
        parent::init();
        $this->on(self::SEND_MAIL,['backend\components\Mailer','sendMail']); //注册事件
    }

    public function behaviors()
    {
        return [
            //附加行为
            'myBehavior' => MyBehavior::className(),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        //Yii::$app->kafka->send(['i want pa pa pa']);
        // $a=$this->isGuest();
        //var_dump($a);exit();

        $foo= new Foo();
        $foo->on(Foo::EVENT_HELLO,['backend\components\FooT','hello']);//注册事件
        $foo->trigger(Foo::EVENT_HELLO);//触发事件

        return $this->render('index');

    }

    /*
     * $highlight  高亮Es 的匹配结果
     * $keyword  关键字
     *根据type 实例化对应的类 这边写个ES 接口 下面的去实现这个接口 去根据索引去ES 查询
     *传keyword 和 type
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

    /*
     *$event相关参数
     */
    public function actionSend(){

        $event = new MailEvent();
        $event->content = 'this is my test content';
        $event->email ='360063842@qq.com';
        $event->subject ='找回密码';
        $this->trigger(self::SEND_MAIL,$event);
    }



}
