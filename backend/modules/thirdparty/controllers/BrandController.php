<?php

namespace backend\modules\thirdparty\controllers;

use common\components\Common;
use common\libraries\ThirdPartyBrandDataProvider;
use Yii;
use common\models\Brand;
use backend\modules\thirdparty\models\search\BrandSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $url = Yii::$app->params['bizBaseUrl'] . Yii::$app->params['bizBrandList'];
        $param = [];
        $result = json_encode($param);
        $data = base64_encode($result);
        $sign = strtoupper(md5($data . Yii::$app->params['bizSecret']));
        $params = ['appKey' => Yii::$app->params['bizAppKey'], 'data' => $data, 'sign' => $sign];
        $content = Common::requestServer($url, $params);
        $result = json_decode($content, true);
        if ($result['code'] == 10000) {
            Yii::$app->session->setFlash('success', $result['message']);
            $provider = new ArrayDataProvider([
                'key' => 'id',
                'totalCount' => count($result['data']) ? count($result['data']) : 0,
                'allModels' => $result['data'],

            ]);
            return $this->render('index', [
                'dataProvider' => $provider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', $result['message']);
            return false;
        }
    }

    /**
     * Displays a single Brand model.
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
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Brand model.
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
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
