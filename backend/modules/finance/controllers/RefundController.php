<?php

namespace backend\modules\finance\controllers;

use backend\libraries\RefundLib;
use common\models\OrderObject;
use Yii;
use common\models\AfterSales;
use backend\modules\finance\models\search\RefundSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\QueueTasks;

/**
 * RefundController implements the CRUD actions for AfterSales model.
 */
class RefundController extends Controller
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
        $searchModel = new RefundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->get('sub') === 'export') {
            $task = new QueueTasks();
            $task->operater = Yii::$app->user->getId();
            $task->create_time = date("Y-m-d H:i:s");
            $task->task_type = 2;
            $task->task_content = json_encode(Yii::$app->request->get('RefundSearch'));
            $task->save(false);
            //加入队列
            $payload = [
                "task_id" => $task->task_id,
                "task_content" => Yii::$app->request->get('RefundSearch'),
            ];
            //入队成功
            if (Yii::$app->amqp->product("yugou_exchange", "export_queue", "export_routing_key", json_encode($payload))) {
                $task->task_status = 1;
                $task->save(false);
            }
            return $this->redirect(['/content/queue-tasks/index']);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

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

        return $this->redirect(Yii::$app->request->getReferrer());

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
        if($model->status!=2){
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $order_object = OrderObject::findOne($model->order_object_id);
        if(empty($order_object)){
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $result = RefundLib::processRefund($model->after_sn,$model->refund_money);
        if($result['code']==10000){
            Yii::$app->session->setFlash('success',$result);
        }else{
            Yii::$app->session->setFlash('error',$result);
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}
