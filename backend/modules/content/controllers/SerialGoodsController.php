<?php

namespace backend\modules\content\controllers;

use common\models\Goods;
use common\models\Serial;
use Yii;
use common\models\SerialGoods;
use backend\modules\content\models\search\SerialGoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SerialGoodsController implements the CRUD actions for SerialGoods model.
 */
class SerialGoodsController extends Controller
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
     * Lists all SerialGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SerialGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SerialGoods model.
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
     * Creates a new SerialGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SerialGoods();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/content/serial/update','id'=>$model->serial_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SerialGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $goods = Goods::findOne($model->good_id);
        if ($goods) {
            $goods_data = [$goods->id => "({$goods->id})".$goods->name];
        }else{
            $goods_data= [];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/content/serial/update','id'=>$model->serial_id]);
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'goods_data' => $goods_data,
        ]);
    }

    /**
     * Deletes an existing SerialGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $serial_id = $model->serial_id;
        $model->delete();
        return $this->redirect(['/content/serial/update','id'=>$serial_id]);
    }

    /**
     * Finds the SerialGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SerialGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SerialGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null)
    {

        $model = $id === null ? new SerialGoods() : SerialGoods::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    /**
     * 通过商品编号搜索商品信息
     * @param  string $goods_code
     * @param  integer $serial_id
     * @return mixed
     */
    public function actionSearchGoods($serial_id,$goods_name=null)
    {
        $serial = Serial::findOne($serial_id);
        $results = $result = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Goods::find()
            ->select('goods.id as id, goods.goods_code as goods_bn,goods.name as name')
            ->andWhere(['=', 'goods.ascription', $serial->type])
            ->andFilterWhere(['like', 'goods.name', $goods_name])
            ->limit(20)
            ->asArray()
            ->all();
        foreach ($data as $key => $value){
            $result['id'] = $value['id'];
            $result['text'] ="({$value['id']})" . $value['name'];
            $results[] = $result;
            $result = [];
        }
        $out['results'] = $results;
        return $out;
    }

}
