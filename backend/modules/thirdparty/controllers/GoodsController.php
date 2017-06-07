<?php

namespace backend\modules\thirdparty\controllers;

use backend\libraries\ThirdPartyLib;
use common\components\Common;
use common\libraries\ThirdPartyDataProvider;
use Yii;
use common\models\Goods;
use yii\data\BaseDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
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
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $provider = new ThirdPartyDataProvider([
            'key' => 'goodsId',
        ]

        );
        return $this->render('index', [
            'dataProvider' => $provider,

        ]);
    }

    /**
     * Displays a single Goods model.
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
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
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
     * Deletes an existing Goods model.
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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //批量插入贡云商品

    public function actionAddApiGoods()
    {
        $post = Yii::$app->request->post();
        $ids=$post['ids'];
        if (isset($ids)) {
            $goods = Goods::find()->select('api_goods_id')->where(['<>','api_goods_id','0'])->asArray()->all();
            $good_ids = [];
            foreach ($goods as $good) {
                $good_ids[] = $good['api_goods_id'];
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $goods_diff = array_diff($ids, $good_ids);
                if (!empty($goods_diff) && is_array($goods_diff)) {
                    $rows = ThirdPartyLib::getGoods($goods_diff);
                    $rows_data = ThirdPartyLib::ChangeGoods($rows);
                    $re = Yii::$app->db->createCommand()->batchInsert(Goods::tableName(), ['api_goods_id','brand_id','suggested_price','lowest_price','talent_limit', 'threshold', 'ascription', 'talent_display', 'discount', 'score_rate', 'self_support', 'channel', 'goods_code', 'name', 'label_name', 'unit', 'remark','wx_small_imgpath'], $rows_data)->execute();
                    if ($re=='') {
                        throw new \Exception('操作插入第三方商品的步骤失败！');
                    }
                }

                $goods_some = array_intersect($ids, $good_ids);
                if (!empty($goods_some) && is_array($goods_some)) {
                    $rows = ThirdPartyLib::getGoods($goods_some);
                    $rows_datas = ThirdPartyLib::ChangeGoods($rows);

                    foreach ($rows_datas as $rows_data)
                    {
                        Goods::updateAll($rows_data, ['api_goods_id' =>$rows_data['api_goods_id']]);
                    }

                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
                 return $this->redirect(['/goods/goods-api/index']);
        }
         return $this->redirect(['/goods/goods-api/index']);
    }

    public function actionGetGoodsHtml()
    {
        $goods_id = Yii::$app->request->post('goods_id');
        //下面是调接口的数据
    }
}


















