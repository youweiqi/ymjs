<?php

namespace backend\modules\warehouse\controllers;

use backend\libraries\StoreBrandLib;
use common\components\Common;
use common\components\QiNiu;
use Yii;
use common\models\Store;
use backend\modules\warehouse\models\search\StoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
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
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Store model.
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
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Store();
        $post=Yii::$app->request->post();

        if ($model->load($post)) {
            $brand_ids = $model->brand_ids;//代理品牌
            unset($model->brand_ids);
            //不在验证
            $model->money = intval(strval($model->money * 100));
            if($model->price_no_freight==''){
                $model->price_no_freight = '999999';
            }elseif ($model->price_no_freight==0){
                $model->price_no_freight ='0';
            }else{
                $model->price_no_freight = intval(strval($model->price_no_freight * 100));
            }
            if($model->save(false)){
                //保存店铺关联品牌
                StoreBrandLib::saveStoreBrand($brand_ids,$model->id);
            }

            return $this->redirect(Yii::$app->request->getReferrer());

        }
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }


    /**
     * Updates an existing Store model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $store_brand_data = StoreBrandLib::getStoreBrandData($id);//根据店铺ID获取门店品牌数据
        $store_brand_ids = StoreBrandLib::getStoreBrandIdArr($id);

        if ($model->load(Yii::$app->request->post())) {
            $brand_ids = $model->brand_ids;
            unset($model->brand_ids);
            $logo_path = QiNiu::qiNiuUploadByModel($model,'logo_path','store');
            if(isset($logo_path['key'])){
                $model->logo_path = $logo_path['key'];
            }else{
                unset($model->logo_path);
            }
            $model->money = intval(strval($model->money * 100));
            if($model->price_no_freight==''){
                $model->price_no_freight = '999999';
            }elseif ($model->price_no_freight==0){
                $model->price_no_freight ='0';
            }else{
                $model->price_no_freight = intval(strval($model->price_no_freight * 100));
            }
            if($model->save(false)){
                //更新把品牌和门店id存到store_brand
                StoreBrandLib::updateStoreBrand($brand_ids,$model->id);
            }
            return $this->redirect(Yii::$app->request->getReferrer());

        }
        if($model->price_no_freight == '999999'){
            $model->price_no_freight ="";
        }else{
            $model->price_no_freight = $model->price_no_freight/100;
        }
        $model->money = $model->money/100;
        $model->brand_ids = $store_brand_ids;
        return $this->renderAjax('update', [
            'model' => $model,
            'store_brand_data' => $store_brand_data,
        ]);
    }

    /**
     * Deletes an existing Store model.
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
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new Store() : Store::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    /**
     * 根据供门店名称查询门店相关信息
     * @param  string $store_name 门店名称
     * @return array
     */
    public function actionSearchStore($store_name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Store::find()
            ->select('store.id as id, store.store_name as text')
            ->andFilterWhere(['like', 'store.store_name', $store_name])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }

    public function actionGetRegionSearch()
    {
        $post = Yii::$app->request->post();
        $data = Common::getRegionSearch($post['keywords'], $post['level']);
        $option = '';
        if ($data) {
            foreach ($data as $value) {
                $option .= '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
            }
        } else {
            $option .= '<option value="0">暂无地区</option>';
        }
        echo $option;
    }

    public function actionGetLocation()
    {
        $post = Yii::$app->request->post();
        $location = Common::getLocation($post['city'],$post['address']);
        if($location){
            $location = explode(',',$location);
            echo json_encode(['lat'=>$location[1],'lng'=>$location[0]]);
        }else{
            echo json_encode([]);
        }
    }
}
