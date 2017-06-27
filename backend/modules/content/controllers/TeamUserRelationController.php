<?php

namespace backend\modules\content\controllers;

use backend\modules\content\models\form\UserForm;
use common\helpers\ArrayHelper;
use common\models\Team;
use common\models\User;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\TeamUserRelation;
use backend\modules\content\models\search\TeamUserRelationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TeamUserRelationController implements the CRUD actions for TeamUserRelation model.
 */
class TeamUserRelationController extends Controller
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
     * Lists all TeamUserRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamUserRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamUserRelation model.
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
     * Creates a new TeamUserRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TeamUserRelation();
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost) {
            if (isset($post['TeamUserRelation']['user_id'])) {
                $user_ids = $post['TeamUserRelation']['user_id'];
                $team_id = $post['TeamUserRelation']['team_id'];
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $relation = [];
                    foreach ($user_ids as $user_id) {
                        $team_user['team_id'] = $team_id;
                        $team_user['user_id'] = $user_id;
                        $relation[] = $team_user;
                        $team_user = [];
                    }

                    $ret = Yii::$app->db->createCommand()->batchInsert(TeamUserRelation::tableName(), ['team_id', 'user_id'], $relation)->execute();

                    if ($ret === false) {
                        throw new \Exception('生成团队会员关系数据失败！');
                    }
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('create', ['model' => $model]);
    }


    /**
     * Updates an existing TeamUserRelation model.
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
     * Deletes an existing TeamUserRelation model.
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
     * Finds the TeamUserRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeamUserRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TeamUserRelation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionValidateForm ($id = null) {

        $model = $id === null ? new TeamUserRelation() : TeamUserRelation::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionSearchTeam($name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Team::find()
            ->select('id as id, team_name as text')
            ->andFilterWhere(['like', 'team_name', $name])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }


    /*
     * $user_ids 已经有分组的不能再有分组
     */

    public function actionSearchUser($name=null)
    {
       $team_user_ids = TeamUserRelation::find()->select('user_id')->asArray()->all();
        $user_ids = ArrayHelper::getColumn($team_user_ids,'user_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = User::find()
            ->where(['not in','uid',$user_ids])
            ->select('uid as id, username as text')
            ->andFilterWhere(['like', 'username', $name])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }

}
