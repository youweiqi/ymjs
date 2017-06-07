<?php

namespace backend\modules\content\controllers;

use common\components\QiNiu;
use Yii;
use common\models\SerialContent;
use backend\modules\content\models\search\SerialContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * SerialContentController implements the CRUD actions for SerialContent model.
 */
class SerialContentController extends Controller
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
     * Lists all SerialContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SerialContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SerialContent model.
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
     * Creates a new SerialContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SerialContent();

        if ($model->load(Yii::$app->request->post())) {
            $image_path_ret = QiNiu::qiNiuUploadByModel($model,'image_path','serialContent');
            if(isset($image_path_ret['key'])){
                $model->image_path = $image_path_ret['key'];
            }
            if($model->save()){
                return $this->redirect(['/content/serial/update','id'=>$model->serial_id]);
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SerialContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $image_path_ret = QiNiu::qiNiuUploadByModel($model,'image_path','serialContent');
            if(isset($image_path_ret['key'])){
                $model->image_path = $image_path_ret['key'];
            }else{
                unset($model['image_path']);
            }
            if($model->save()) {
                return $this->redirect(['/content/serial/update', 'id' => $model->serial_id]);
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing SerialContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $serial_id = $model->serial_id;
        $model->delete();
        return $this->redirect(['/content/serial/update','id'=>$serial_id]);
    }

    /**
     * Finds the SerialContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SerialContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SerialContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new SerialContent() : SerialContent::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
