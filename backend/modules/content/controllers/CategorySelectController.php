<?php

namespace backend\modules\content\controllers;

use backend\libraries\CategoryLib;
use common\models\Category;
use Yii;
use common\models\CategorySelect;
use backend\modules\content\models\search\CategorySelectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CategorySelectController implements the CRUD actions for CategorySelect model.
 */
class CategorySelectController extends Controller
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
     * Lists all CategorySelect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySelectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count = CategorySelect::find()->count();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'count' => $count,
        ]);
    }

    /**
     * Displays a single CategorySelect model.
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
     * Creates a new CategorySelect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategorySelect();

        if ($model->load(Yii::$app->request->post()) ) {
            $img_path = Yii::$app->qiniu->UploadImg($model,'ico_path','categorySelect');
            if($img_path){
                $model->ico_path = $img_path;
            }
            if(empty($model->name)){
                $model->name = CategoryLib::getCategoryName($model->category_id);
            }else{
                $model->name;
            }
            $model->save(false);
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CategorySelect model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $img_path = Yii::$app->qiniu->UploadImg($model,'ico_path','categorySelect');
            if($img_path){
                $model->ico_path = $img_path;
            }else{
                unset($model->ico_path);
            }
            if(empty($model->name)){
                $model->name = CategoryLib::getCategoryName($model->category_id);
            }else{
                $model->name;
            }

            $model->save(false);
            return $this->redirect(Yii::$app->request->getReferrer());

        } else {
            $category_data = CategoryLib::getCategoryData($model->category_id);
            return $this->renderAjax('update', [
                'model' => $model,
                'category_data' => $category_data,
            ]);
        }
    }

    /**
     * Deletes an existing CategorySelect model.
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
     * Finds the CategorySelect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategorySelect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategorySelect::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new CategorySelect() : CategorySelect::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    /**
     * 根据相关信息
     * @param  string $category_name 三级分类名称
     * @return array
     */
    public function actionSearchCategory($category_name=null)
    {
        $results = $result = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Category::find()
            ->select('category.id as id, category.name as category_name')
            ->andFilterWhere(['like', 'category.name', $category_name])
            ->andWhere(['=', 'category.deep', 3])
            ->andWhere(['=', 'category.status', 1])
            ->limit(20)
            ->asArray()
            ->all();
        foreach ($data as $key => $value){
            $result['id'] = $value['id'];
            $result['text'] = $value['category_name'];
            $results[] = $result;
            $result = [];
        }
        $out['results'] = $results;
        return $out;
    }
}
