<?php

namespace backend\modules\content\controllers;

use backend\libraries\BrandLib;
use common\models\Brand;
use Yii;
use common\models\BrandHot;
use backend\modules\content\models\search\BrandHotSearch;
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
     * Lists all BrandHot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandHotSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count = BrandHot::find()->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'count' => $count,
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
        if ($model->load(Yii::$app->request->post())) {
            $img_path = Yii::$app->qiniu->UploadImg($model,'logo_path','brandHot');
            if($img_path){
                $model->logo_path = $img_path;
            }
            $model->brand_name = BrandLib::getBrandName($model->brand_id);
            $model->save(false);
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
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
            $img_path = Yii::$app->qiniu->UploadImg($model,'logo_path','brandHot');
            if($img_path){
                $model->logo_path = $img_path;
            }else{
                unset($model->logo_path);
            }
            $model->brand_name = BrandLib::getBrandName($model->brand_id);
            $model->save(false);
            return $this->redirect(Yii::$app->request->getReferrer());
        } else {
            $brand_data = [$model->brand_id => $model->brand_name];
            return $this->renderAjax('update', [
                'model' => $model,
                'brand_data' => $brand_data,
            ]);
        }
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
    /**
     * 根据品牌名称查询品牌相关信息
     * @param  string $brand_name 品牌名称
     * @return array
     */
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
