<?php

namespace backend\modules\goods\controllers;

use backend\libraries\CategoryLib;
use common\components\QiNiu;
use Yii;
use common\models\Category;
use backend\modules\goods\models\search\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) ) {
            $ret = QiNiu::qiNiuUploadByModel($model,'ico_path','category');
            if(isset($ret['key'])){
                $model->ico_path = $ret['key'];
            }
            $model->deep = 2;
            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent_category = $this->findModel($model->parent_id);
        $category_data= [$parent_category->id=>$parent_category->name];
        if ($model->load(Yii::$app->request->post()) ) {
            $ret = QiNiu::qiNiuUploadByModel($model,'ico_path','category');
            if(isset($ret['key'])){
                $model->ico_path = $ret['key'];
            }else{
                unset($model->ico_path);
            }
                $model->deep = 2;
            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'category_data' => $category_data,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateChildCategory($id)
    {
        $model = new Category();
        $model->parent_id = $id;
        $parent_category = Category::findOne($id);
        $parent_category_data = [$parent_category->id=>$parent_category->name];
        if ($model->load(Yii::$app->request->post()) ) {
            $ret = QiNiu::qiNiuUploadByModel($model,'ico_path','category');
            if(isset($ret['key'])){
                $model->ico_path = $ret['key'];
            }
            $model->deep = 3;
            $model->status = 1;
            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        return $this->renderAjax('create_child_category', [
            'model' => $model,
            'parent_category_data' => $parent_category_data,
        ]);
    }


    public function actionUpdateChildCategory($id)
    {
        $model = $this->findModel($id);
        $parent_category = $this->findModel($model->parent_id);
        $parent_category_data= [$parent_category->id=>$parent_category->name];
        if ($model->load(Yii::$app->request->post()) ) {
            $ret = QiNiu::qiNiuUploadByModel($model,'ico_path','category');
            if(isset($ret['key'])){
                $model->ico_path = $ret['key'];
            }else{
                unset($model->ico_path);
            }
            $model->deep = 3;
            $model->status = 1;
            if($model->save(false)){
                return $this->redirect(Yii::$app->request->getReferrer());

            }
        }
        return $this->renderAjax('update_child_category', [
            'model' => $model,
            'parent_category_data' => $parent_category_data,
        ]);
    }



    public function actionSearchCategory ($name=null,$parent_id=0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Category::find()
            ->select('category.id as id, category.name as text')
            ->andFilterWhere(['like', 'category.name', $name])
            ->andFilterWhere(['=', 'category.parent_id', $parent_id])
            ->limit(10)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }
    public function actionGetChildCategories($category_id=null)
    {
        $post = Yii::$app->getRequest()->post();
        $category_id = $category_id ? $category_id : (isset($post['category_id'])?$post['category_id']:null);
        if(empty($category_id)) return [];
        $categories = CategoryLib::getChildCategories($category_id);
        $option = '';
        if ($categories) {
            foreach ($categories as $value) {
                $option .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
            }
        } else {
            $option .= '<option value="0">暂未子分类</option>';
        }
        echo $option;
    }
    //查询商品分类
    public function actionsSearchCA($model_name_cn=null){
        $car_brand_arr = $data = [];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $car_brand_data = Category::find()
            ->select('id, name')
            ->asArray()
            ->all();
        foreach ($car_brand_data as $car_brand)
        {
            $car_brand_arr[$car_brand['id']] = $car_brand;
        }
        unset($car_brand_data);
        $car_model_data = Category::find()
            ->select('id, parent_id, model')
            ->andFilterWhere(['like', 'model', $model_name_cn])
            ->andFilterWhere(['<>', 'parent_id', '0'])
            ->limit(10)
            ->asArray()
            ->all();
        foreach ($car_model_data as $car_model)
        {
            $car_model_arr['id'] = $car_model['id'];
            $car_model_arr['text'] = '('.$car_brand_arr[$car_model['car_brand_id']]['brand_name_cn'].')'.$car_model['model'];
            $data[] = $car_model_arr;
            unset($car_model_arr);
        }
        $out['results'] = array_values($data);
        return $out;


    }
    /**
     * 分类表单验证
     * @param  integer $id 分类ID
     * @return mixed
     */
    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new Category() : Category::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    public function actionGetChildCategoryHtml()
    {
        $category_id = Yii::$app->request->post('category_id');
        echo CategoryLib::getChildCategoryHtml($category_id);
    }






}
