<?php

namespace backend\modules\member\controllers;

use common\models\Commision;
use common\models\UserCommission;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\CUser;
use backend\modules\member\models\search\CUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CUserController implements the CRUD actions for CUser model.
 */
class CUserController extends Controller
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
     * Lists all CUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CUser model.
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
     * Creates a new CUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //返回他的上游和总端分销商
       $parent_user_id = $model->parent_user_id;
        $root_user_id = $model->root_user_id;
        if($parent_user_id != '0'){
           $model1 = CUser::findOne($parent_user_id);
            $parent_user_name =[$model1->id => $model1->user_name];
        }else{
            $parent_user_name = ['无'];
        }
        if($root_user_id != '0'){
            $model1 = CUser::findOne($root_user_id);
            $root_user_name =[$model1->id => $model1->user_name];
        }else{
            $root_user_name = ['无'];
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->role_id == 3){
                $model->parent_user_id = '0';
                $model->root_user_id = '0';
                $commision = $model->getUser_commission();
                if(isset($commision->id)){
                    $commision->load(Yii::$app->request->post());
                    $commision->save();
                }else{
                    $commision->user_id = $id;
                    $commision->load(Yii::$app->request->post());
                    $commision->save();
                }
            }else{
                UserCommission::deleteAll(['user_id'=>$id]);
            }
            $model->save();
            return $this->redirect(Yii::$app->request->getReferrer());
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'root_user_name' =>$root_user_name,
                'parent_user_name' =>$parent_user_name
            ]);
        }

    }

    /**
     * Deletes an existing CUser model.
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
     * Finds the CUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm($id = null)
    {
        $model = $id === null ? new CUser() : CUser::findOne($id);
        $model->load(Yii::$app->request->post());
        $model->validate();
        $u_errors = $model->getErrors();

        $c = new UserCommission();
        $c->load(Yii::$app->request->post());
        $c->validate();
        $c_errors = $c->getErrors();
        $errors = array_merge($u_errors,$c_errors);
        Yii::$app->response->format = Response::FORMAT_JSON;
//        return ActiveForm::validate($model);
        return $errors;

    }

    public function actionSearchUser ($name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = CUser::find()
            ->select('id as id, name as text')
            ->andFilterWhere(['like', 'c_user.user_name', $name])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }


}
