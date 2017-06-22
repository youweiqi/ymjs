<?php

namespace backend\modules\content\controllers;

use common\models\Inventory;
use common\models\Product;
use Yii;
use common\models\ActivityDetail;
use backend\modules\content\models\search\ActivityDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityDetailController implements the CRUD actions for ActivityDetail model.
 */
class ActivityDetailController extends Controller
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
     * Lists all ActivityDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivityDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivityDetail model.
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
     * Creates a new ActivityDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivityDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ActivityDetail model.
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
     * Deletes an existing ActivityDetail model.
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
     * Finds the ActivityDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActivityDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivityDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInitialize()
    {
        $product_id_arr = $product_arr = $activity_details = [];
        $goods_id = Yii::$app->request->post('goods_id');
        $store_id = Yii::$app->request->post('store_id');
        $inventories = Inventory::find()->where(['and',['=','goods_id',$goods_id],['=','store_id',$store_id]])->asArray()->all();
        foreach ($inventories as $inventory)
        {
            $product_id_arr[] = $inventory['product_id'];

        }
        $products = Product::find()->select('id,product_bn')->where(['in','id',$product_id_arr])->asArray()->all();
        foreach ($products as $product)
        {
            $product_arr[$product['id']] = $product['product_bn'];
        }
        foreach ($inventories as $inventory)
        {
            $activity_detail['product_id'] = $inventory['product_id'];
            $activity_detail['product_bn'] = $product_arr[$inventory['product_id']];
            $activity_detail['inventory_id'] = $inventory['id'];
            $activity_detail['inventory_num'] = $inventory['inventory_num'];
            $activity_details[]= $activity_detail;
            unset($activity_detail);
        }
        echo json_encode($activity_details);

    }

}
