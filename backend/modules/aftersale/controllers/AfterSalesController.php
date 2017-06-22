<?php

namespace backend\modules\aftersale\controllers;

use backend\controllers\BaseController;
use backend\libraries\AfterSalesLib;
use common\components\Common;
use Yii;
use common\models\AfterSales;
use backend\modules\aftersale\models\search\AfterSalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AfterSalesController implements the CRUD actions for AfterSales model.
 */
class AfterSalesController extends BaseController
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
     * Lists all AfterSales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AfterSalesSearch();
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
            return $this->redirect(['view', 'id' => $model->id]);
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
    /**
     * 同意售后.
     * @param  integer $id 售后单ID
     * @return mixed
     */
    public function actionAgree($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 2;
            $model->save();
            $description = '同意售后申请';
            $this->writeLog($id,$model->after_sn,'after_sale',$description);
            return $this->redirect(Yii::$app->request->getReferrer());
        }else{
            return $this->renderAjax('agree', [
                'model' => $model,
            ]);
        }
    }
    /**
     * 拒绝售后单.
     * @param  integer $id 售后单ID
     * @return mixed
     */
    public function actionRefuse($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $params = [
                'afterSalesId'=>$id,
                'storeRefuseReason'=>$model->store_refuse_reason,
//                'storeRefuseReason1'=>$model->store_refuse_reason1,
                'type'=>1,
            ];
            $url = Yii::$app->params['apiBaseUrl'].Yii::$app->params['apiBaStoreRefusedAfterSales'];
            $content= Common::requestServer($url,$params);
            $result = json_decode($content, true);
            if($result['code' == '10000']){
                Yii::$app->session->setFlash('success',$result);
                $description = '拒绝售后申请';
                $this->writeLog($id,$model->after_sn,'after_sale',$description);

            }else{
                Yii::$app->session->setFlash('error',$result);
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }else{
            return $this->renderAjax('refuse', [
                'model' => $model,
            ]);
        }
    }

    public function actionAgreeSendBack($id)
    {
        $model = $this->findModel($id);
        $model->send_back = 2;
        $model->save(false);
        $description = '同意回寄的货品';
        $this->writeLog($id,$model->after_sn,'after_sale',$description);
        return $this->redirect(Yii::$app->request->getReferrer());

    }
    public function actionRefuseSendBack($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 4;
            if($model->save()){
                $description = '拒绝回寄的货品';
                $this->writeLog($id,$model->after_sn,'after_sale',$description);
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

    public function actionGetAfterSalesDetailHtml($aftersale_id)
    {
        $data = AfterSalesLib::getAfterSalesData($aftersale_id);
        return $this->renderPartial('after_sales_detail',['data'=>$data]);
    }

}
