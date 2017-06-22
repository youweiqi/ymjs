<?php

namespace backend\modules\tgtools\controllers;

use backend\modules\tgtools\models\form\BrandTgCreateForm;
use Yii;
use common\models\TgLink;
use backend\modules\tgtools\models\search\TgLinkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\tgtools\models\form\GoodsTgCreateForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * TgLinkController implements the CRUD actions for TgLink model.
 */
class TgLinkController extends Controller
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
     * Lists all TgLink models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TgLinkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TgLink model.
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
     * Creates a new TgLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGoodsTgCreate()
    {
        $model = new TgLink();
        $model->setScenario('tg_goods');
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('goods-tg', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new TgLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGoodsTgUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('tg_goods');
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('goods-tg', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new TgLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBrandTgCreate()
    {
        $model = new TgLink();
        $model->setScenario('tg_brand');

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('brand-tg', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new TgLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBrandTgUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('tg_brand');

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('brand-tg', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Creates a new TgLink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGoodsCreate()
    {
        $model = new TgLink();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing TgLink model.
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
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TgLink model.
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
     * Finds the TgLink model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TgLink the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TgLink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGoodsTgValidateForm ($id = null) {

        $model = $id === null ? new GoodsTgCreateForm() : TgChannel::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
