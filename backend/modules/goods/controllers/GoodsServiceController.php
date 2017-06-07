<?php

namespace backend\modules\goods\controllers;

use common\components\QiNiu;
use Yii;
use common\models\GoodsService;
use backend\modules\goods\models\search\GoodsServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * GoodsServiceController implements the CRUD actions for GoodsService model.
 */
class GoodsServiceController extends Controller
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

    /**
     * Lists all GoodsService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsService model.
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
     * Creates a new GoodsService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsService();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $logo_ret = QiNiu::qiNiuUploadByModel($model,'image','goods-service');

            if(isset($logo_ret['key'])){
                $model->image = $logo_ret['key'];
            }

            if($model->save(false)){
                return $this->redirect(['index', 'id' => $model->id] );
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GoodsService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $logo_ret = QiNiu::qiNiuUploadByModel($model,'image','goods-service');

            if(isset($logo_ret['key'])){
                $model->image = $logo_ret['key'];
            }else{
                unset($model->image);
            }

            if($model->save()){
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,

        ]);
    }

    /**
     * Deletes an existing GoodsService model.
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
     * Finds the GoodsService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSearchGoodsService($service_name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = GoodsService::find()
            ->select('goods_service.id as id, goods_service.name as text')
            ->andFilterWhere(['like', 'goods_service.name', $service_name])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = $data?$data:[];
        return $out;
    }
    public function actionValidateForm ($id = null) {

        $model = $id === null ? new GoodsService() : GoodsService::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
