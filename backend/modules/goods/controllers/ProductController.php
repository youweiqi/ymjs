<?php

namespace backend\modules\goods\controllers;

use backend\libraries\SpecificationLib;
use backend\modules\goods\models\search\ProductSearch;
use common\components\QiNiu;
use common\models\Goods;
use common\models\GoodsSpecificationImages;
use Yii;
use common\models\Product;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Displays a single Menu model.
     * @param  integer $goods_id
     * @return mixed
     */
    public function actionCreate($goods_id)
    {
        $model = new Product();
        $goods = Goods::findOne($goods_id);
        $good_specification_image_model = new GoodsSpecificationImages();

        if ($model->load(Yii::$app->request->post()) ) {
            $image_ret = QiNiu::qiNiuUploadByModel($model,'classify_detail_image','goodSpecificationImage');
            if(isset($image_ret['key'])){
                $good_specification_image_model->image_path = $image_ret['key'];
                $good_specification_image_model->specification_detail_id = $model->classify_detail_id;
                $good_specification_image_model->good_id = $model->good_id;
                $good_specification_image_model->save();
            }
            $model->spec_info = $model->classify_detail_id.'|'.$model->spec_detail_id;
            $model->spec_name = SpecificationLib::getProductSpecNameData($model->classify_detail_id,$model->spec_detail_id);
            $model->spec_desc = SpecificationLib::getProductSpecificationData($model->classify_detail_id,$model->spec_detail_id);
            unset($model->classify_detail_id,$model->spec_detail_id,$model->classify_detail_image);
            if($model->save()){
                $goods_spec = SpecificationLib::getGoodsSpecDesc($model->good_id);
                $goods->setScenario('update');
                $goods->spec_desc = $goods_spec;
                unset($goods->classify_id,$goods->spec_id);
                if($goods->save()) return $this->redirect(['/goods/goods/update', 'id' => $model->good_id]);
            }
        }
        $spec_id_arr = Goods::getSpecIdArr($goods->spec_desc);
        $model->classify_id = $spec_id_arr['classify_id'];
        $model->spec_id = $spec_id_arr['spec_id'];
        $model->good_id = $goods->id;
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
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

        $goods = Goods::findOne($model->good_id);
        $spec_detail_id_arr = explode('|', $model->spec_info);
        $good_specification_image_model = GoodsSpecificationImages::find()->where('good_id=:gid and specification_detail_id=:sdid', [':gid'=>$model->good_id,':sdid'=>$spec_detail_id_arr[0]])->one();

        if ($model->load(Yii::$app->request->post()) ) {
            $image_ret = QiNiu::qiNiuUploadByModel($model,'classify_detail_image','goodSpecificationImage');
            if(isset($image_ret['key'])){
                if($good_specification_image_model->specification_detail_id != $model->classify_detail_id){
                    $good_specification_image_model = new GoodsSpecificationImages();
                    $good_specification_image_model->good_id = $model->good_id;
                    $good_specification_image_model->specification_detail_id = $model->classify_detail_id;
                }
                $good_specification_image_model->image_path = $image_ret['key'];
                $good_specification_image_model->save();
            }
            $model->spec_info = $model->classify_detail_id.'|'.$model->spec_detail_id;
            $model->spec_name = SpecificationLib::getProductSpecNameData($model->classify_detail_id,$model->spec_detail_id);
            $model->spec_desc = SpecificationLib::getProductSpecificationData($model->classify_detail_id,$model->spec_detail_id);
            unset($model->classify_detail_id,$model->spec_detail_id,$model->classify_detail_image);
            if($model->save()){
                $goods_spec = SpecificationLib::getGoodsSpecDesc($model->good_id);
                $goods->setScenario('update');
                $goods->spec_desc = $goods_spec;
                unset($goods->classify_id,$goods->spec_id);
                if($goods->save()) return $this->redirect(['/goods/goods/update', 'id' => $model->good_id]);
            }
        }

        $spec_id_arr = Goods::getSpecIdArr($goods->spec_desc);
        $model->classify_id = $spec_id_arr['classify_id'];
        $model->spec_id = $spec_id_arr['spec_id'];
        $model->classify_detail_id = $spec_detail_id_arr[0];
        $model->spec_detail_id = $spec_detail_id_arr[1];
        $model->classify_detail_image = isset($good_specification_image_model->image_path)?$good_specification_image_model->image_path:'';
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
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
    /**
     * 验证表单提交的内容
     * @param  integer $id
     * @return mixed
     */
    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new Product() : Product::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    /**
     * 根据货号查询货品相关信息
     * @param  string $product_bn 货号
     * @return array
     */
    public function actionSearchProduct($product_bn=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Product::find()
            ->select('product.id as id, product.product_bn as text')
            ->andFilterWhere(['like', 'product.product_bn', $product_bn])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }
}
