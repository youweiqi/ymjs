<?php

namespace backend\modules\warehouse\controllers;

use common\models\Inventory;
use common\models\Store;
use Yii;
use common\models\Product;
use backend\modules\warehouse\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInsertInventory()
    {

        $post = Yii::$app->request->post();
        if ($post) {
            $inventory_ids = Inventory::find()->select('product_id')->where(['=','store_id', $post['store_id']])->asArray()->all();
            $product_arr = [];
            foreach ($inventory_ids as $inventory_id) {
                $product_arr[] = $inventory_id['product_id'];
            }
            $diff_product_ids = array_diff($post['ids'], $product_arr);
            if (is_array($diff_product_ids) && !empty($diff_product_ids)) {
                $product_ids = Product::find()->select('id,goods_id')->where(['in', 'id', $diff_product_ids])->asArray()->all();
                $product_data = $inventory_data = [];
                foreach ($product_ids as $product_id) {
                    $product_data['product_id'] = $product_id['id'];
                    $product_data['goods_id'] = $product_id['goods_id'];
                    $product_data['store_id'] = $post['store_id'];
                    $inventory_data[] = $product_data;
                    $product_data = [];
                }
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $res = Yii::$app->db->createCommand()->batchInsert(Inventory::tableName(), ['product_id', 'goods_id', 'store_id',], $inventory_data)->execute();
                    if ($res === '') {
                        throw new \Exception('操作插入到库存表的步骤失败！');
                    }
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                return $this->redirect(['inventory/index']);
            }

        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}
