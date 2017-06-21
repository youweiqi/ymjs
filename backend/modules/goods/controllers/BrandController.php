<?php

namespace backend\modules\goods\controllers;

use backend\libraries\CategoryBrandLib;
use common\components\QiNiu;
use Yii;
use common\models\Brand;
use backend\modules\goods\models\search\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $parent_ids = $model->parent_ids;//总分类
            unset($model->parent_ids);
            $logo_ret = QiNiu::qiNiuUploadByModel($model, 'logo_path', 'brand');
            $back_ret = QiNiu::qiNiuUploadByModel($model, 'background_image_path', 'brand');
            if (isset($logo_ret['key'])) {
                $model->logo_path = $logo_ret['key'];
            }
            if (isset($back_ret['key'])) {
                $model->background_image_path = $back_ret['key'];
            }
            if ($model->save(false)) {
                //保存品牌关联分类
                CategoryBrandLib::saveCategoryBrand($parent_ids, $model->id);
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
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
        $category_brand_data=CategoryBrandLib::getCategoryBrandData($id);//获取品牌下的分类名称
        $category_brand_ids=CategoryBrandLib::getCategoryBrandIdArr($id);//根据品牌ID去查询所有该品牌下的分类信息
        if ($model->load(Yii::$app->request->post())) {
            $parent_ids = $model->parent_ids;//总分类
            unset($model->parent_ids);
            $logo_ret = QiNiu::qiNiuUploadByModel($model,'logo_path','brand');
            $back_ret = QiNiu::qiNiuUploadByModel($model,'background_image_path','brand');
            if(isset($logo_ret['key'])){
                $model->logo_path = $logo_ret['key'];
            }else{
                unset($model->logo_path);
            }
            if(isset($back_ret['key'])){
                $model->background_image_path = $back_ret['key'];
            }else{
                unset($model->background_image_path);
            }

            if($model->save(false)){
                CategoryBrandLib::updateBrandCategory($parent_ids,$model->id);
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $model->parent_ids = $category_brand_ids;
        return $this->renderAjax('update', [
            'model' => $model,
            'category_brand_data' => $category_brand_data,
        ]);
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

        return $this->redirect(Yii::$app->request->getReferrer());
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

    public function actionSearchBrand($brand_name=null)
    {
        $results = $result = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Brand::find()
            ->select('brand.id as id, brand.name_cn as name_cn,brand.name_en as name_en')
            ->orFilterWhere(['like', 'brand.name_cn', $brand_name])
            ->orFilterWhere(['like', 'brand.name_en', $brand_name])
            ->limit(20)
            ->asArray()
            ->all();
        foreach ($data as $key => $value){
            $result['id'] = $value['id'];
            $result['text'] = $value['name_cn'].'('.$value['name_en'].')';
            $results[] = $result;
            $result = [];
        }
        $out['results'] = $results;
        return $out;
    }

    public function actionAsyncImage ()
    {
        // 商品ID
        $id = Yii::$app->request->post('brand_id');
        $attribute = Yii::$app->request->post('attribute');
        // $p1 $p2是我们处理完图片之后需要返回的信息，其参数意义可参考上面的讲解
        $preview = $preview_config = [];
        // 如果没有商品图或者商品id非真，返回空
        if (empty($_FILES['Brand']['name']) || empty($_FILES['Brand']['name']['logo_path'])) {
            echo '{}';
            return;
        }
        QiNiu::qiNiuUploadByWidget($_FILES['Brand']['tmp_name']['logo_path'], 'test');
        // 循环多张商品banner图进行上传和上传后的处理
        for ($i = 0; $i < count($_FILES['Banner']['name']['banner']); $i++) {
            // 上传之后的商品图是可以进行删除操作的，我们为每一个商品成功的商品图指定删除操作的地址
            $url = '/banner/delete';
            // 调用图片接口上传后返回的图片地址，注意是可访问到的图片地址哦
            $imageUrl = '';
            // 保存商品banner图信息
            $model = new Banner;
            $model->goods_id = $id;
            $model->banner_url = $imageUrl;
            $key = 0;
            if ($model->save(false)) {
                $key = $model->id;
            }
            // 这是一些额外的其他信息，如果你需要的话
            // $pathinfo = pathinfo($imageUrl);
            // $caption = $pathinfo['basename'];
            // $size = $_FILES['Banner']['size']['banner_url'][$i];
            $p1[$i] = $imageUrl;
            $p2[$i] = ['url' => $url, 'key' => $key];
        }
        // 返回上传成功后的商品图信息
        echo json_encode([
            'initialPreview' => $p1,
            'initialPreviewConfig' => $p2,
            'append' => true,
        ]);
        return;
    }

    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new Brand() : Brand::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

}
