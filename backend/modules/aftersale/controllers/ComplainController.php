<?php

namespace backend\modules\aftersale\controllers;

use Yii;
use common\models\AfterSales;
use backend\modules\aftersale\models\search\ComplainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ComplainController implements the CRUD actions for AfterSales model.
 */
class ComplainController extends Controller
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
     * Lists all AfterSales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComplainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfterSales model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AfterSales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AfterSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AfterSales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AfterSales model.
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
     * Finds the AfterSales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AfterSales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AfterSales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAgree($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->save(false);
        return $this->redirect(Yii::$app->request->getReferrer());
    }
    public function actionRefuse($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 4;
            if($model->save()){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('refuse', [
            'model' => $model,
        ]);
    }
    public function actionAgreeSendBack($id)
    {
        $model = $this->findModel($id);
        $model->send_back = 2;
        $model->save(false);
        return $this->redirect(Yii::$app->request->getReferrer());

    }
    public function actionRefuseSendBack($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 4;
            if($model->save()){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('refuse', [
            'model' => $model,
        ]);
    }
    /**
     * 验证表单提交的内容
     * @param  integer $id
     * @return mixed
     */
    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new AfterSales() : AfterSales::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

}
