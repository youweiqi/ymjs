<?php

namespace backend\modules\discount\controllers;

use backend\libraries\PromotionDetailLib;
use Yii;
use common\models\PromotionDetail;
use backend\modules\discount\models\search\PromotionDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * PromotionDetailController implements the CRUD actions for PromotionDetail model.
 */
class PromotionDetailController extends Controller
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
     * Lists all PromotionDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromotionDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PromotionDetail model.
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
     * Creates a new PromotionDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PromotionDetail();

            if ($model->load(Yii::$app->request->post())) {

                if($model->is_discount=='0'||$model->type=='0'){
                    $model->amount = intval(strval($model->amount * 100));
                    $model->limited = intval(strval($model->limited * 100));
                }else{
                    $model->limited = intval(strval($model->limited * 100));
                }
                if($model->save(false)){
                    return $this->redirect(['/discount/promotion/update', 'id' => $model->promotion_id]);
                }
            }
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing PromotionDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $promotion_data=PromotionDetailLib::getPromotionDetail($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->limited = intval(strval($model->limited * 100));
            $model->amount = intval(strval($model->amount * 100));
            if($model->save(false)){
                return $this->redirect(['/discount/promotion/update', 'id' => $model->promotion_id]);
            }
        }
        $model->limited = $model->limited/100;
        $model->amount = $model->amount/100;
        return $this->renderAjax('update', [
            'model' => $model,
            'promotion_data'=>$promotion_data
        ]);
    }

    /**
     * Deletes an existing PromotionDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $promotion=PromotionDetail::findOne($id);
        $promotion_id=$promotion->promotion_id;
        $this->findModel($id)->delete();

        return $this->redirect(['/discount/promotion/update', 'id' =>$promotion_id]);
    }

    /**
     * Finds the PromotionDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PromotionDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromotionDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm($id = null)
    {

        $model = $id === null ? new PromotionDetail() : PromotionDetail::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionSearchPromotionDetail($type = null, $promotion_detail_name = null)
    {
        $results = $result = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = PromotionDetail::find()
            ->select('id as id, promotion_detail_name as text ')
            ->andFilterWhere(['like', 'promotion_detail_name', $promotion_detail_name])
            ->andFilterWhere(['type'=>$type])
            ->limit(20)
            ->asArray()
            ->all();
        foreach ($data as $key => $value){
            $result['id'] = $value['id'];
            $result['text'] = '('.$value['id'].')'.$value['text'];
            $results[] = $result;
            $result = [];
        }

        $out['results'] = $results;
        return $out;
    }
}
