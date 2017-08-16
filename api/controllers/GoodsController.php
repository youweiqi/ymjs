<?php
namespace frontend\controllers;

use common\models\AppSecret;
use common\models\Brand;
use common\models\GoodsNavigate;
use yii\web\Controller;
use common\models\Goods;
use frontend\models\searchs\GoodsSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\Category;
use yii\filters\VerbFilter;
use yii\base\ErrorException;
class GoodsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->layout = 'goods-main';
        if($action->id == 'add')
        {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $catesTree = $this->initCateTree();
        return$this->render('index', [
            'catesTree' => $catesTree
        ]);
    }
    public function actionCate($cid=null,$hd_sj='no')
    {
        $searchModel = new GoodsSearch();
        $cids = $cid ? $this->getLastSubCateIds($cid):[];
        $queryParams['GoodsSearch'] = ['cids'=>$cids,'hd_sj'=>$hd_sj];
        $data = $searchModel->search($queryParams);
//        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->render('list',[
            'data' =>$data,
            'cid' => $cid,
            'hd_sj' => $hd_sj
        ]);
    }
    public function actionMyGoods()
    {
        $app_id = Yii::$app->user->getIdentity()->app_id;
        $searchModel = new GoodsSearch();
//        $cids = $cid ? $this->getLastSubCateIds($cid):[];
        $queryParams['GoodsSearch'] = ['app_id' => $app_id];
        $data = $searchModel->search_my_goods($queryParams);
//        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->render('my-goods',[
            'data' =>$data
        ]);
    }

    public function actionSearch($keyword=null,$hd_sj='no')
    {
        $searchModel = new GoodsSearch();
        if(preg_match("/\p{Han}+/u", $keyword)){ //如果是商品名称
            $queryParams['GoodsSearch'] = ['name'=>$keyword];
        }else{
            $queryParams['GoodsSearch'] = ['goods_code'=>$keyword];
        }
        $queryParams['GoodsSearch']['hd_sj'] = $hd_sj;

        $data = $searchModel->search($queryParams);
        $this->view->params['keyword'] = $keyword;

        return $this->render('search',[
            'data' =>$data,
            'hd_sj' => $hd_sj
        ]);
    }

    public function actionDetail($gcode= null)
    {
        $searchModel = new GoodsSearch();
        $queryParams['GoodsSearch'] = ['goods_code'=>$gcode];
        try{
            $goods = $searchModel->search_goods_detail($queryParams);
        }catch (ErrorException $e){
            throw new NotFoundHttpException();
        }

        return$this->render('detail',[
            'goods' => $goods
        ]);
    }
    public function actionAdd()
    {
        $app= Yii::$app->user->getIdentity();
        $app_id = $app->app_id;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $goods_id = Yii::$app->request->post('goods_id');
        if(!$result = Goods::findOne($goods_id)) {
            return ['status'=>'fail'];
        }
        if($r = GoodsAppRecord::find()->where(['app_id'=>$app_id,'goods_id'=>$goods_id])->one()) {
            return ['status'=>'succ'];
        }

        if(!($app->config))
        {
            return['status' => 'fail','code'=>'APP_API_URL','message'=>'api url need config'];
        }
        $record = new GoodsAppRecord();
        $record->app_id = $app_id;
        $record->create_time= date("Y-m-d H:i:s");
        $record->status = 0;
        $record->goods_id= $goods_id;
        $record->goods_id= $goods_id;
        $record->save(false);
        //加入队列
        $payload = [
            "record_id" => $record->id,
            "app_id" => $record->app_id,
            "goods_id" => $record->goods_id,
            "api_url" => $app->config
        ];
        //入队成功
        Yii::$app->amqp->product("gongyun_exchange","push_goods","push_goods_routing_key", json_encode($payload));
        return ['status'=>'succ'];
    }
    public function actionError()
    {
        return $this->render('not-found');
    }
    private function initCateTree()
    {
        $cates = Category::find()->select(['id','parent_id','name','deep'])->orderBy(['deep'=>SORT_DESC])->all();
        $tree = [];
        /** @var Category $cate */
        foreach ($cates as $cate)
        {
            switch ($cate->deep)
            {
                case 3:
                    if(!isset( $level2[$cate->parent_id]))
                    {
                        $level2[$cate->parent_id] = [
                            'id' => $cate->parent_id,
                            'name' => '',
                            'pid' => '',
                            'children'=> []
                        ];
                    }
                    $level2[$cate->parent_id]['children'][] = [
                        'id' => $cate->id,
                        'name' => $cate->name,
                        'pid' => $cate->parent_id
                    ];
                    break;
                case 2:
                    $level2[$cate->id]['id'] = $cate->id;
                    $level2[$cate->id]['name'] = $cate->name;
                    $level2[$cate->id]['pid'] = $cate->parent_id;

                    if(!isset($tree[$cate->parent_id]))
                    {
                        $tree[$cate->parent_id] = [
                            'id' =>  $cate->parent_id,
                            'name' => '',
                        ];
                    }
                    $tree[$cate->parent_id]['children'][] = $level2[$cate->id];
                    break;
                case 1:
                    $tree[$cate->id]['id'] = $cate->id;
                    $tree[$cate->id]['name'] = $cate->name;
                    $tree[$cate->id]['pid'] = $cate->parent_id;
                    break;
            }
        }
        return $tree;
    }

    private function getLastSubCateIds($id)
    {
        $cate = Category::findOne($id);
        $ids = [];
        switch ($cate->deep)
        {
            case 1:{//一级分类 取下边的三级分类
                $tree = $this->initCateTree();
                foreach ($tree[$id]['children'] as $level2) {
                    if(isset($level2['children']))
                    {
                        foreach ($level2['children'] as $level3) {
                            $ids[] = $level3['id'];
                        }
                    }
                }
                return $ids;
                break;
            }
            case 2: {//二级分类 取下边的三级分类
                $data = Category::find()->select('id')->where(['parent_id'=>$id])->all();
                $ids = array_column($data,'id');
                return $ids;
                break;
            }
            default:{
                return [$id];
            }
        }

    }


}