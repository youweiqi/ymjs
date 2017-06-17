<?php

namespace backend\modules\warehouse\controllers;


use backend\modules\warehouse\models\form\AddInventoryForm;
use backend\modules\warehouse\models\form\FreightTemplateForm;
use common\models\Goods;
use common\models\Product;
use common\models\Store;
use common\models\StoreGoodsFreight;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\Inventory;
use backend\modules\warehouse\models\search\InventorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
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
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inventory model.
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
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post())) {
            $product = Product::findOne($model->product_id);
            $model->goods_id = $product->goods_id;

            $model->sale_price = intval(strval($model->sale_price * 100));
            $model->settlement_price = intval(strval($model->settlement_price * 100));

            if($model->save(false)){
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->store_id == '0'){
            $store = new Store(['id' => 0,'store_name' => '贡云商城']);
        }else{
            $store = Store::findOne($model->store_id);
        }

        $product = Product::findOne($model->product_id);
        $store_name_data = [$store->id=>$store->store_name];
        $product_bn_data = [$product->id=>$product->product_bn];

        if ($model->load(Yii::$app->request->post())) {
            $model->sale_price = intval(strval($model->sale_price * 100));
            $model->settlement_price = intval(strval($model->settlement_price * 100));
            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        $model->sale_price = $model->sale_price/100;
        $model->settlement_price = $model->settlement_price/100;
        return $this->renderAjax('update', [
            'model' => $model,
            'store_name_data' => $store_name_data,
            'product_bn_data' => $product_bn_data,
        ]);
    }

    /**
     * Deletes an existing Inventory model.
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
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm($id = null)
    {
        $model = $id === null ? new Inventory() : Inventory::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionValidateForm1()
    {
        $model = new AddInventoryForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionBatchAdd()
    {

        $model = new FreightTemplateForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids = unserialize($model->ids);

            $inventory_ids=Inventory::find()->select('goods_id,store_id')->where(['in','id',$ids])->asArray()->all();

            $inventory=[];

            foreach ($inventory_ids as $inventory_id)
            {
                $inventory_arr['good_id']=$inventory_id['goods_id'];
                $inventory_arr['store_id']=$inventory_id['store_id'];
                $inventory_arr['freight_template_id']=$post['FreightTemplateForm']['freight_template_id'];
                $inventory[]=$inventory_arr;
                $a=StoreGoodsFreight::findOne(['good_id'=>$inventory_id['goods_id'],'store_id'=>$inventory_id['store_id']]);

                if(!empty($a)){
                    StoreGoodsFreight::updateAll(['freight_template_id'=>$post['FreightTemplateForm']['freight_template_id']],['good_id'=>$inventory_arr['good_id'],'store_id'=>$inventory_arr['store_id']]);
                }else{
                    Yii::$app->db->createCommand()->batchInsert(StoreGoodsFreight::tableName(), ['good_id', 'store_id','freight_template_id'],$inventory)->execute();
                }
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('batch_add', ['model' => $model]);
    }

    public function actionBatchInventory()
    {
        $model=new AddInventoryForm();

        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids= unserialize($model->ids);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = Inventory::updateAll(
                    ['inventory_num' => $model->inventory_num,], ['id' => $ids]);
                if ($res==='') {
                    throw new \Exception('操作更新库存的步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('batch-inventory', ['model' => $model]);
    }

}
