<?php

namespace backend\modules\goods\controllers;

use backend\libraries\BrandHotLib;
use common\components\QiNiu;
use common\models\Brand;
use Yii;
use common\models\BrandHot;
use backend\modules\goods\models\search\BrandHotSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BrandHotController implements the CRUD actions for BrandHot model.
 */
class BrandHotController extends Controller
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
     * Lists all BrandHot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandHotSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BrandHot model.
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
     * Creates a new BrandHot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BrandHot();
        $brand_hot_name_data=BrandHotLib::getBrandHotNameData();//查询所有的热门品牌名
        $brand_hot_ids=BrandHotLib::getBrandHotIdArr(); // 已经选择的热门品牌ID
        $post=Yii::$app->request->post();
        if ($model->load($post)) {
            $brand_ids=$model->brand_ids  ;//暂时存所有勾选的热门品牌

            unset($model->brand_ids);
            BrandHotLib::updateBrand($brand_ids);
            return $this->redirect(['index']);
        }
        $model->brand_ids = $brand_hot_ids;
        return $this->renderAjax('create', [
            'model' => $model,
            'brand_hot_name_data'=>$brand_hot_name_data
        ]);
    }

    /**
     * Updates an existing BrandHot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $image_ret = QiNiu::qiNiuUploadByModel($model,'logo_path','brandHot');
            if(isset($image_ret['key'])){
                $model->logo_path = $image_ret['key'];
                if(!empty($model->getOldAttribute('logo_path'))){
                    QiNiu::deleteFile($model->getOldAttribute('logo_path'));
                }
            }else{
                unset($model->logo_path);
            }
            if($model->save(false)){
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BrandHot model.
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
     * Finds the BrandHot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrandHot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BrandHot::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new BrandHot() : BrandHot::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionSearchBrand($brand_name=null)
    {
        $results = $result = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Brand::find()
            ->select('brand.id as id, brand.name_cn as name_cn,brand.name_en as name_en')
            ->orFilterWhere(['like', 'brand.name_cn', $brand_name])
            ->orFilterWhere(['like', 'brand.name_en', $brand_name])
            ->limit(20)
            ->asArray()
            ->all();
        foreach ($data as $key => $value){
            $result['id'] = $value['id'];
            $result['text'] = $value['name_cn'].'('.$value['name_en'].')';
            $results[] = $result;
            $result = [];
        }
        $out['results'] = $results;
        return $out;
    }
}
