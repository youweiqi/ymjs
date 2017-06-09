<?php

namespace backend\modules\finance\controllers;

use backend\libraries\MemberJournalLib;
use backend\modules\finance\models\form\UserJournalForm;
use common\models\CUser;
use Yii;
use common\models\UserJournal;
use backend\modules\finance\models\search\UserJournalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserJournalController implements the CRUD actions for UserJournal model.
 */
class UserJournalController extends Controller
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
     * Lists all UserJournal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserJournalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserJournal model.
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
     * Creates a new UserJournal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserJournal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserJournal model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserJournal model.
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
     * Finds the UserJournal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserJournal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserJournal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm()
    {
        $model = new UserJournal();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionBatchUpdate()
    {

        $model = new UserJournalForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids = unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->status == 4) {
                    $res = UserJournal::updateAll(['status' => 4], ['status' => 3, 'id' => $ids]);
                    if (!$res) {
                        throw new \Exception('操作更新提款成功的步骤失败！');
                    }
                } elseif ($model->status == 5) {
                    $user_ids=UserJournal::find()->select('user_id,money')->where(['and',['in','id',$ids],'status =3'])->asArray()->all();
                    $user_arr=[];
                    foreach ($user_ids as $user_id)
                    {
                        if(isset($user_arr[$user_id['user_id']])){
                            $user_arr[$user_id['user_id']] += $user_id['money'];

                        }else{
                            $user_arr[$user_id['user_id']] = $user_id['money'];
                        }
                    }

                    $key=array_keys($user_arr);
                    //去查询现在当前各个会员的money
                    $members = CUser::find()->where(['in','id',$key])->all();
                    foreach ($members as $member)
                    {
                        $member->money += $user_arr[$member->id];
                        if(!$member->save(false))
                        {
                            throw new \Exception('更新用户金额失败！');
                        }
                    }

                    $memberJournal = MemberJournalLib::createAction($ids);
                    $ret = Yii::$app->db->createCommand()->batchInsert(UserJournal::tableName(), ['money', 'user_id', 'status', 'type', 'promotion_detail_id', 'comment'], $memberJournal)->execute();
                    if (!$ret) {
                        throw new \Exception('操作生成新的流水失败！');
                    }
                    $re = UserJournal::updateAll(['status' => 5], ['status' => 3, 'id' => $ids]);
                    if ($re=== false) {
                        throw new \Exception('操作更新拒绝提款的步骤失败！');
                    }

                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('batch_update', ['model' => $model]);
    }
}
