<?php

namespace backend\modules\content\controllers;

use backend\libraries\GoodsLib;
use backend\libraries\SerialLib;
use common\components\QiNiu;
use common\helpers\ArrayHelper;
use common\models\PromotionDetail;
use common\models\SerialBrand;
use common\models\SerialContent;
use common\models\SerialGoods;
use Yii;
use common\models\Serial;
use backend\modules\content\models\search\SerialSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SerialController implements the CRUD actions for Serial model.
 */
class SerialController extends Controller
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
     * Lists all Serial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SerialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Serial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $serial_goods= SerialGoods::find()->select('good_id')->where('serial_id=:sid',[':sid'=>$id])->asArray()->all();
        $serial_contents= SerialContent::find()->select('image_path')->where('serial_id=:sid',[':sid'=>$id])->asArray()->all();
        $goods_id_arr= $serial_goods_data = [];
        if(is_array($serial_goods)&&!empty($serial_goods)){
            foreach ($serial_goods as  $serial_good) {
                $goods_id_arr[]=$serial_good['good_id'];
            }
            $serial_goods_data = GoodsLib::getSerialGoodsData($goods_id_arr);
        }
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'serial_goods'=>$serial_goods,
            'serial_contents'=>$serial_contents,
            'serial_goods_data'=>$serial_goods_data

        ]);
    }

    /**
     * Creates a new Serial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Serial();
        $serial_brand_model = new SerialBrand();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $serial_brand_model->load(Yii::$app->request->post());
            $cover_imgpath_ret = QiNiu::qiNiuUploadByModel($model,'cover_imgpath','serial');
            $wx_small_imgpath_ret = QiNiu::qiNiuUploadByModel($model,'wx_small_imgpath','serial');
            if(isset($cover_imgpath_ret['key'])){
                $model->cover_imgpath = $cover_imgpath_ret['key'];
            }
            if(isset($wx_small_imgpath_ret['key'])){
                $model->wx_small_imgpath = $wx_small_imgpath_ret['key'];
            }
            if($model->save(false)){
                if(!empty($serial_brand_model->brand_id)){
                    $serial_brand_model->serial_id = $model->id;
                    $serial_brand_model->save(false);
                }
                return $this->redirect(['index']);
            }
        }
        $model->is_recommend= '0';
        $model->is_display= '1';
        return $this->renderAjax('create', [
            'model' => $model,
            'serial_brand_model' => $serial_brand_model,
        ]);
    }

    /**
     * Updates an existing Serial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $brand_data = SerialLib::getBrandData($id);
        $serial_brand_data = $brand_data['data'];
        $serial_good_model = new SerialGoods();
        $serial_brand_model = new SerialBrand();
        $serial_brand_model->serial_id = $id;
        $serial_good_model->serial_id = $id;
        $serial_content_model = new SerialContent();
        $serial_content_model->serial_id = $id;
        $serial_good_data_provider = new ActiveDataProvider([
            'query' => SerialGoods::find()->where(['serial_id'=>$id])->orderBy('id'),
        ]);
        $serial_content_data_provider = new ActiveDataProvider([
            'query' => SerialContent::find()->where(['serial_id'=>$id])->orderBy('id'),
        ]);

        $post=Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            $cover_imgpath_ret = QiNiu::qiNiuUploadByModel($model,'cover_imgpath','serial');
            $wx_big_imgpath_ret = QiNiu::qiNiuUploadByModel($model,'wx_big_imgpath','serial');
            $wx_small_imgpath_ret = QiNiu::qiNiuUploadByModel($model,'wx_small_imgpath','serial');
            if(isset($cover_imgpath_ret['key'])){
                $model->cover_imgpath = $cover_imgpath_ret['key'];
            }else{
                unset($model['cover_imgpath']);
            }
            if(isset($wx_big_imgpath_ret['key'])){
                $model->wx_big_imgpath = $wx_big_imgpath_ret['key'];
            }else{
                unset($model['wx_big_imgpath']);
            }
            if(isset($wx_small_imgpath_ret['key'])){
                $model->wx_small_imgpath = $wx_small_imgpath_ret['key'];
            }else{
                unset($model['wx_small_imgpath']);
            }
            if($model->save(false)){
                $serial_brand_model->load($post);

                $serial_brand=$serial_brand_model::findOne(['serial_id'=>$id]);

                if(!empty($serial_brand)) {
                    if(!empty($post['SerialBrand']['brand_id'])) {
                        $serial_brand->brand_id = $post['SerialBrand']['brand_id'];
                        $serial_brand->save(false);

                    }else{
                        $serial_brand_model::deleteAll(['serial_id' => $id]);
                    }
                }else{
                    if(!empty($post['SerialBrand']['brand_id'])){
                        $serial_brand_model->save(false);
                    }else{
                        $model->save(false);
                    }
                }
                return $this->redirect(['index', 'id' => $model->id]);
            }

        }

        $serial_brand_model->brand_id = $brand_data['brand_id'];

        return $this->render('update', [
            'model' => $model,
            'serial_brand_model'=>$serial_brand_model,
            'serial_good_model' => $serial_good_model,
            'serial_content_model' => $serial_content_model,
            'serial_good_data_provider' => $serial_good_data_provider,
            'serial_content_data_provider' => $serial_content_data_provider,
            'serial_brand_data'=>$serial_brand_data,
            'serial_id' => $id,
        ]);
    }

    /**
     * Deletes an existing Serial model.
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
     * Finds the Serial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Serial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Serial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null) {

        $model = $id === null ? new Serial() : Serial::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    //根据品牌券 获取品牌下的期
    public function actionSearchSerial($promotion_detail_id=null, $serial_name = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //品牌券
        $promotion_detail = PromotionDetail::find()->where(['id'=>$promotion_detail_id])->one();
        if(!$promotion_detail) {
            return $out = ['results' => []];
        }
        //品牌下的期
        $serials = SerialBrand::find()->where(['brand_id' => $promotion_detail->brand_id])->asArray()->all();
        if(empty($serials))
        {
            return $out = ['results' => []];
        }
        $serial_ids = ArrayHelper::getColumn($serials,'serial_id');

        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Serial::find()
            ->select('id as id, title as text ')
            ->andFilterWhere(['in','id',$serial_ids])
            ->andFilterWhere(['like','title',$serial_name])
            ->limit(20)
            ->asArray()
            ->all();

        $out['results'] = $data?$data:[];
        return $out;
    }
}
