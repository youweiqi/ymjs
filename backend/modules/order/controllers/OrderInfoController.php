<?php

namespace backend\modules\order\controllers;


use backend\controllers\BaseController;
use backend\modules\order\models\form\DeliveryForm;
use backend\modules\order\models\search\OrderDetailSearch;
use backend\modules\order\models\search\OrderExport;
use common\components\Common;
use common\models\OrderDetail;
use common\models\QueueTasks;
use common\models\UserAddress;
use Yii;
use common\models\OrderInfo;
use backend\modules\order\models\search\OrderInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * OrderInfoController implements the CRUD actions for OrderInfo model.
 */
class OrderInfoController extends BaseController
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
     * Lists all OrderInfo models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OrderInfoSearch();
        if(Yii::$app->request->get('sub') === 'export'){
            $params = Yii::$app->request->get('OrderInfoSearch');
            parent::setQueueTask(1,$params);
            return $this->redirect(['/content/queue-tasks/index']);

        }else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single OrderInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $order_info = $this->findModel($id);


        $orders = OrderInfo::findOne($id);
        $user_id = $orders->user_id;
        $address = $orders->address;

        $user_address = UserAddress::find()->select('id_number')->where(['user_id'=>$user_id,'address'=>$address])->one();

        $order_details = OrderDetail::find()
            ->where(['order_id' => $id])
            ->orderBy('id')
            ->all();
        return $this->renderAjax('view', [
            'model' => $order_info,
            'order_details' => $order_details,
            'user_address' => $user_address
        ]);
    }

    /**
     * Creates a new OrderInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderInfo model.
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
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrderInfo model.
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
     * Finds the OrderInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null) {

        $model = $id === null ? new OrderInfo() : OrderInfo::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionDelivery($id)
    {
        $order_info = $this->findModel($id);
        $model = new DeliveryForm();
        if ($model->load(Yii::$app->request->post())) {

            if($order_info->status =='2') {
                $data = [
                    'orderSn' => $model->order_sn,
                    'expressName' => $model->express_name,
                    'expressNo' => $model->express_no,
                ];

                $params = $data;
                $content = Common::requestServer(YG_BASE_URL . YG_DELIVER_GOODS, $params);
                $result = json_decode($content, true);
                if($result['code'] != '10000'){
                    Yii::$app->session->setFlash('error', $result);
                }
            }else{
                $order_info->order_sn =$model->order_sn;
                $order_info->express_name =$model->express_name;
                $order_info->express_no =$model->express_no;
                $order_info->save(false);

            }

            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $model->order_id = $order_info->id;
        $model->order_sn = $order_info->order_sn;
        $model->link_man = $order_info->link_man;
        return $this->renderAjax('delivery',['model'=>$model]);
    }

    public function actionDeliveryDirect($id)
    {
        $order_info = $this->findModel($id);
        if ($order_info->status==2){
            $data=[
                'orderSn' => $order_info->order_sn,
            ];
            $content=Common::requestServer(YG_BASE_URL.YG_DELIVER_GOODS,$data);
            $result = json_decode($content, true);
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}
