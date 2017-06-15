<?php

namespace backend\modules\goods\controllers;

use backend\libraries\GoodsLib;
use backend\libraries\GoodsServiceLib;
use backend\modules\goods\models\form\GoodsCommissionForm;
use backend\modules\goods\models\form\GoodsForm;
use backend\modules\goods\models\form\UpDownGoodsForm;
use common\helpers\ArrayHelper;
use common\models\Activity;
use common\models\ActivityDetail;
use common\models\Brand;
use common\models\Category;
use common\models\GoodsCommission;
use common\models\GoodsDetail;
use common\models\GoodsMallCommission;
use common\models\GoodsNavigate;
use common\models\GoodsService;
use common\models\GoodsSpecificationImages;
use common\models\Inventory;
use common\models\Product;
use common\models\SerialGoods;
use common\models\StoreCooperateGoods;
use Yii;
use common\models\Goods;
use backend\modules\goods\models\search\GoodsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    public $enableCsrfValidation = false;
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

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = Goods::findOne(['id' => $id]);
            $posted=current($_POST['Goods']);
            $post =['Goods' =>$posted];
            $output='';
            if ($model->load($post)){
                $model->save();
                isset($post['score_rate']) && $output = $model->score_rate;
            }
            $out = Json::encode(['output'=>$output, 'message'=>'']);
            return $out;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($goods_id=null,$step=1,$tag=0)
    {
        $post = Yii::$app->request->post();
        if(empty($goods_id) && $step==1){
            $model = new Goods(['scenario' => 'one']);
            if ($model->load($post)) {
                $model->service_desc = implode(',', $model->service_ids);
                unset($model->service_ids);
                $model->suggested_price = intval(strval($model->suggested_price * 100));
                if($model->save(false)){
                    return $this->redirect(['create','goods_id'=>$model->id,'step'=>2]);
                }
            }
            return $this->render('create_one', [
                'model' => $model,
            ]);
        }elseif(!empty($goods_id) && $step==2){
            $goods = Goods::findOne($goods_id);
            if($tag){
                GoodsLib::createGoodsTwo($goods_id,$post);
                return $this->redirect(['index']);
            }
            return $this->render('create_two', [
                'goods_id' => $goods_id,
                'brand_id' => $goods->brand_id,
//                'model'=>$model
            ]);

        }elseif (!empty($goods_id) && $step==3){
            return $this->render('create_three', [
            ]);

        }else{
            return $this->render('create_err', [
            ]);

        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$tag=0)
    {
        $model = new GoodsForm();
        $post = Yii::$app->request->post();
        if ($tag) {
            GoodsLib::updateGoods($id,$post);
            return $this->redirect(['index']);
        }
        $model = GoodsLib::initGoodsForm($id,$model);
        return $this->render('update', [
            'model' => $model,
            'goods_id' => $id,
        ]);

    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Product::deleteAll(['goods_id'=>$id]);
        Inventory::deleteAll(['goods_id'=>$id]);
        ActivityDetail::deleteAll(['goods_id'=>$id]);
        Activity::deleteAll(['good_id'=>$id]);
        GoodsDetail::deleteAll(['good_id'=>$id]);
        GoodsMallCommission::deleteAll(['good_id'=>$id]);
        GoodsNavigate::deleteAll(['good_id'=>$id]);
        GoodsSpecificationImages::deleteAll(['goods_id'=>$id]);
        SerialGoods::deleteAll(['good_id'=>$id]);
        StoreCooperateGoods::deleteAll(['good_id'=>$id]);


        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionUpDownGoods()
    {
        $model=new UpDownGoodsForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids= unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = Goods::updateAll(['online_time' =>$model->online_time,'offline_time'=>$model->offline_time], ['id' => $ids]);
                if (!$res) {
                    throw new \Exception('操作更新上下架时间的步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('up_down_goods', ['model' => $model]);
    }
    //验证UpDownGoodsForm
    public function actionValidateUpDownGoodsForm ()
    {
        $model=new UpDownGoodsForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }


    public function actionUpdateGoodsCommission()
    {
        $model=new GoodsCommissionForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids = unserialize($model->ids);
         $good_ids = GoodsCommission::find()->select('good_id')->asArray()->all();
           $good_id = ArrayHelper::getColumn($good_ids,'good_id');
            $goods_some = array_intersect($ids,$good_id);
            $goods_diff = array_diff($ids,$good_id);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = GoodsCommission::updateAll(['commission' =>$model->commission], ['good_id' => $goods_some]);

                $goods = [];
                foreach ($goods_diff as $v){
                    $good = [];
                    $good['good_id'] = $v;
                    $good['commission'] = $model->commission;
                    $good['role_id'] = 0;
                    $good['indirect_commission'] = 0;
                    $goods[] = $good;

                }
                $res1 = Yii::$app->db->createCommand()->batchInsert(GoodsCommission::tableName(), ['good_id', 'commission', 'role_id', 'indirect_commission'], $goods)->execute();


                if ($res===false && $res1 === false) {
                    throw new \Exception('操作更新分佣的步骤失败！');
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success','批量设置商品分佣成功');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error','批量设置商品分佣失败');
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('goods_commission_form', ['model' => $model]);
    }
    public function actionSearchGood($name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Goods::find()
            ->select('goods.id as id, goods.name as text')
            ->andFilterWhere(['like', 'goods.name', $name])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }


    public function actionGoodsCommissionValidateForm()
    {
        $model = new GoodsCommissionForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
