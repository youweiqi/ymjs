<?php

namespace backend\modules\content\controllers;

use common\components\QiNiu;
use Yii;
use common\models\BusinessCircle;
use backend\modules\content\models\search\BusinessCircleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BusinessCircleController implements the CRUD actions for BusinessCircle model.
 */
class BusinessCircleController extends Controller
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
     * Lists all BusinessCircle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BusinessCircleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BusinessCircle model.
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
     * Creates a new BusinessCircle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BusinessCircle();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $logo_ret = QiNiu::qiNiuUploadByModel($model,'back_image_path','business-circle');

            if(isset($logo_ret['key'])){
                $model->back_image_path = $logo_ret['key'];
            }

            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());

            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing BusinessCircle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $logo_ret = QiNiu::qiNiuUploadByModel($model,'back_image_path','business-circle');

            if(isset($logo_ret['key'])){
                $model->back_image_path = $logo_ret['key'];
            }else{
                unset($model->back_image_path);
            }

            if($model->save()){
                return $this->redirect(Yii::$app->request->getReferrer());

            }
        }
        return $this->renderAjax('update', [
            'model' => $model,

        ]);
    }

    /**
     * Deletes an existing BusinessCircle model.
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
     * Finds the BusinessCircle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BusinessCircle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BusinessCircle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new BusinessCircle() : BusinessCircle::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
