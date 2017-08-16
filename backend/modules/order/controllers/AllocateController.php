<?php

namespace backend\modules\order\controllers;

use backend\modules\order\models\form\AllocateForm;
use common\helpers\ArrayHelper;
use common\models\Team;
use common\models\TeamUserRelation;
use common\models\User;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\OrderInfo;
use backend\modules\order\models\search\AllocateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AllocateController implements the CRUD actions for OrderInfo model.
 */
class AllocateController extends Controller
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
     * Lists all OrderInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderInfo model.
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
     * Creates a new OrderInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderInfo model.
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
     * Deletes an existing OrderInfo model.
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
     * Finds the OrderInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * 批量分派
     */
    public function actionBatchAllocate()
    {
        $model = new AllocateForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids = unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = OrderInfo::updateAll(['team_id' => $model->team_name, 'active_user_id' => $model->user_name,'active_status' => '1'], ['id' => $ids]);
                if ($res===false) {
                    throw new \Exception('操作批量分派步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('batch-allocate', ['model' => $model]);
    }

/*
 * 查找小组和确认人关系表
 * 这个地方暂时想不到联表查询出数据 返回
 */
    public function actionSearchTeam($name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $team_names = TeamUserRelation::find()->select('team_id')->distinct()->asArray()->all();
        $team_arr = ArrayHelper::getColumn($team_names,'team_id');
        $data = Team::find()
            ->where(['in','id',$team_arr])
            ->select('id as id, team_name as text')
            ->andFilterWhere(['like', 'team_name', $name])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }

/*
 * 去查询小组和成员的关系表数据
 * $team_id
 */
    public function actionSearchUser($user_name=null,$team_id)
    {
        $team_user_ids = TeamUserRelation::find()->select('user_id')->where(['=','team_id',$team_id])->asArray()->all();
        $user_ids = ArrayHelper::getColumn($team_user_ids,'user_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = User::find()
            ->where(['in','uid',$user_ids])
            ->select('uid as id, username as text')
            ->andFilterWhere(['like', 'username', $user_name])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }

    public function actionBatchAllocateValidateForm () {

        $model = new AllocateForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }


}
