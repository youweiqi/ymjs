<?php

namespace backend\modules\discount\controllers;

use backend\modules\discount\models\form\RedeemCodeForm;
use common\components\Common;
use common\models\Promotion;
use Yii;
use common\models\RedeemCode;
use backend\modules\discount\models\search\RedeemCodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RedeemCodeController implements the CRUD actions for RedeemCode model.
 */
class RedeemCodeController extends Controller
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
     * Lists all RedeemCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RedeemCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RedeemCode model.
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
     * Creates a new RedeemCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RedeemCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RedeemCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $promotion = Promotion::findOne($model->promotion_id);
        $promotion_data= [$promotion->id=>$promotion->name];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'promotion_data' => $promotion_data,
        ]);
    }

    /**
     * Deletes an existing RedeemCode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->getReferrer());

    }

    /**
     * Finds the RedeemCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RedeemCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RedeemCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionValidateForm($id = null)
    {

        $model = $id === null ? new RedeemCode() : RedeemCode::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }


    public function actionSearchPromotion ($name=null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data =Promotion::find()
            ->select('promotion.id as id, promotion.name as text')
            ->andFilterWhere(['like', 'promotion.name', $name])
            ->andFilterWhere(['=','status','1'])
            ->limit(5)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }
    public function actionBatchCreate()
    {
        $a = 1;
        $model = new RedeemCodeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $creater = Yii::$app->user->identity->username;
            $usable_times = $model->usable_times;
            $promotion_id = $model->promotion_id;
            $start_date = $model->start_date;
            $end_date = $model->end_date;
            $remark=$model->remark;

            for($i=0;$i<$model->create_quantity;$i++){
                $redeem_code_model= new RedeemCode();
                $redeem_code_model->redeem_code = 'L'.Common::getUid();
                $redeem_code_model->promotion_id = $promotion_id;
                $redeem_code_model->used_times = 0;
                $redeem_code_model->usable_times = $usable_times;
                $redeem_code_model->creater = $creater;
                $redeem_code_model->remark = $remark;
                $redeem_code_model->start_date = $start_date;
                $redeem_code_model->end_date = $end_date;
                $redeem_code_model->status = 1;
                if(!$redeem_code_model->save(false)){
                    $i = $i-1;
                }
            }
            return $this->redirect(Yii::$app->request->getReferrer());

        }else{
            return $this->render('batch-create', [
                'model' => $model,
            ]);
        }

    }

}
