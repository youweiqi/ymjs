<?php

namespace backend\modules\content\controllers;

use common\models\ActivityDetail;
use common\models\Goods;
use common\models\Product;
use common\models\Store;
use Yii;
use common\models\Activity;
use backend\modules\content\models\search\SeckilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SeckilController implements the CRUD actions for Activity model.
 */
class SeckilController extends Controller
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
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeckilSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
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
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();

        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $activity_detail_data = [];
            $total_inventory_num = 0;
            $activity_details = json_decode($post['activity_details'], true);

            if (is_array($activity_details)) {
                foreach ($activity_details as $activity_detail) {
                    $activity_detail['activity_id'] = 0;
                    $activity_detail_data[] = $activity_detail;
                    $total_inventory_num += $activity_detail['inventory_num'];
                    unset($activity_detail);
                }
                unset($activity_details);
            }
            $model->total_inventory_num = $total_inventory_num;
            $model->sale_price = intval(strval($model->sale_price * 100));

            if ($model->save()) {
                foreach ($activity_detail_data as $key => $value) {
                    $activity_detail_data[$key]['activity_id'] = $model->id;
                }
                Yii::$app->db->createCommand()->batchInsert(ActivityDetail::tableName(), ['product_id', 'inventory_num', 'inventory_id', 'activity_id'], $activity_detail_data)->execute();
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $store = Store::findOne($model->store_id);
        $goods = Goods::findOne($model->good_id);
        $store_data = [$store->id=>$store->store_name];
        $goods_data = [$goods->id=>$goods->name];

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $activity_detail_data = [];
            $total_inventory_num = 0;
            $activity_details = json_decode($post['activity_details'],true);
            if(is_array($activity_details)){
                foreach ($activity_details as $activity_detail)
                {
                    $activity_detail['activity_id'] = $model->id;
                    $activity_detail_data[] = $activity_detail;
                    $total_inventory_num += $activity_detail['inventory_num'];
                    unset($activity_detail);
                }
                unset($activity_details);
            }
            $model->total_inventory_num = $total_inventory_num;
            $model->sale_price = intval(strval($model->sale_price * 100));
            if($model->save()){
                ActivityDetail::deleteAll('activity_id = :aid', [':aid' => $id]);
                Yii::$app->db->createCommand()->batchInsert(ActivityDetail::tableName(), ['product_id','inventory_num','inventory_id','activity_id'], $activity_detail_data)->execute();
                return $this->redirect(['index']);
            }
        }
        $activity_details = ActivityDetail::find()->where(['=','activity_id',$model->id])->all();
        if(is_array($activity_details)){
            foreach ($activity_details as $key=>$activity_detail)
            {
                $activity_detail->product_bn = Product::getProductBnById($activity_detail['product_id']);
                $activity_details[$key] = $activity_detail;
                unset($activity_detail);
            }
        }
        $model->sale_price = $model->sale_price/100;
        return $this->renderAjax('update', [
            'model' => $model,
            'store_data' => $store_data,
            'goods_data' => $goods_data,
            'activity_details' => $activity_details,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        ActivityDetail::deleteAll(['activity_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null) {

        $model = $id === null ? new Activity() : Activity::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
