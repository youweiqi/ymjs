<?php

namespace backend\modules\goods\controllers;

use backend\libraries\ApiGoodsLib;
use backend\libraries\GoodsCommissionLib;
use backend\modules\goods\models\form\GoodsCommissionForm;
use backend\modules\goods\models\form\SetBrandForm;
use backend\modules\goods\models\form\SetCategoryForm;
use backend\modules\goods\models\form\UpDownGoodsForm;
use common\models\GoodsCommission;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\Goods;
use backend\modules\goods\models\search\GoodsApiSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * GoodsApiController implements the CRUD actions for Goods model.
 */
class GoodsApiController extends Controller
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
        $searchModel = new GoodsApiSearch();
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
    public function actionCreate()
    {
        $model = new Goods();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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


    public function actionGoodsCommissionValidateForm()
    {
        $model = new GoodsCommissionForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionSetCategoryValidateForm()
    {
        $model = new SetCategoryForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    public function actionSetCategory()
    {
        $model=new SetCategoryForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids= unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = Goods::updateAll(['category_parent_id' =>$model->category_parent_id,'category_id'=>$model->category_id], ['id' => $ids]);
                if (!$res) {
                    throw new \Exception('操作设置商品分类的步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('set_category', ['model' => $model]);

    }
    public function actionSetBrand()
    {
        $model=new SetBrandForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids= unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = Goods::updateAll(['brand_id'=>$model->brand_id], ['id' => $ids]);
                if ($res=='0') {
                    throw new \Exception('操作设置商品品牌的步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('set_brand', ['model' => $model]);

    }

    public function actionSetBrandValidateForm()
    {
        $model = new SetBrandForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionGetGoodDetailHtml()
    {
        $good_id = Yii::$app->request->post('good_id');
        echo ApiGoodsLib::getGoodDetailHtml($good_id);
    }


}
