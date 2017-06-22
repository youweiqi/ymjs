<?php

namespace backend\modules\warehouse\controllers;

use backend\libraries\FreightTemplateLib;
use backend\modules\warehouse\models\form\ProvinceForm;
use common\models\FreightTemplateDetail;
use Yii;
use common\models\FreightTemplate;
use backend\modules\warehouse\models\search\FreightTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FreightTemplateController implements the CRUD actions for FreightTemplate model.
 */
class FreightTemplateController extends Controller
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
     * Lists all FreightTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FreightTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FreightTemplate model.
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
     * Creates a new FreightTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FreightTemplate();
        $province_form = new ProvinceForm();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->default_freight = intval(strval($model->default_freight * 100));
            if($model->save(false)){
                $province_form->load($post);
                $provinces = FreightTemplateLib::getProvinceInfo();
                foreach ($provinces as $key=>$province)
                {
                    $detail['freight_template_id'] = $model->id;
                    $detail['province'] = $province;
                    $detail['freight'] = (empty($province_form->$key) && $province_form->$key!=='0') ? $model->default_freight: intval(strval($province_form->$key * 100));;
                    $detail['area_code'] = $key;
                    $details [] = $detail;
                    unset($detail);
                }
                if(!empty($details)){
                    Yii::$app->db->createCommand()->batchInsert( FreightTemplateDetail::tableName(), ['freight_template_id','province','freight','area_code'], $details)->execute();
                }
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('create', [
            'model' => $model,
            'province_form' => $province_form,
        ]);
    }

    /**
     * Updates an existing FreightTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $province_form = new ProvinceForm();
        $post = Yii::$app->request->post();
        //增加下判断 看提交上来的地区 数据库里面是否存在;
        if(!empty($post)) {
            $freights = FreightTemplateDetail::find()->select('area_code')->where(['=', 'freight_template_id', $id])->asArray()->all();
            $freight_arr = [];
            foreach ($freights as $freight) {
                $freight_arr[] = $freight['area_code'];
            }

            $freight_diffs = array_diff(array_keys($post['ProvinceForm']), $freight_arr);

            $freight_data = [];
            foreach ($freight_diffs as $freight_diff) {
                $freight_value['area_code'] = $freight_diff;
                $freight_value['freight'] = $post['FreightTemplate']['default_freight'];
                $freight_value['freight_template_id'] = $id;
                $freight_data[] = $freight_value;
                $freight_value = [];
            }
            Yii::$app->db->createCommand()->batchInsert(FreightTemplateDetail::tableName(), ['area_code', 'freight', 'freight_template_id'], $freight_data)->execute();
        }
        $freight_template_details = FreightTemplateDetail::find()->where(['=', 'freight_template_id',$id])->asArray()->all();

        if(!empty($freight_template_details) && is_array($freight_template_details)){
            foreach ($freight_template_details as $freight_template_detail)
            {
                $province_form[$freight_template_detail['area_code']] = $freight_template_detail['freight']/100;
            }
        }
        if ($model->load($post) && $model->validate()) {
            $model->default_freight = intval(strval($model->default_freight * 100));
            if($model->save(false)){
                $province_form->load($post);
                $provinces = FreightTemplateLib::getProvinceInfo();
                foreach ($provinces as $key=>$province)
                {
                    $freight = (empty($province_form->$key) && $province_form->$key!=='0') ? $model->default_freight :  intval(strval($province_form->$key * 100));;
                    FreightTemplateDetail::updateAll(['freight' => $freight], ['and',['=','freight_template_id',$id],['=','area_code',$key]]);
                }
            }
            return $this->redirect(Yii::$app->request->getReferrer());

        }
        $model->default_freight = $model->default_freight/100;
        return $this->renderAjax('update', [
            'model' => $model,
            'province_form' => $province_form,
        ]);
        }


    /**
     * Deletes an existing FreightTemplate model.
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
     * Finds the FreightTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FreightTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FreightTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidateForm ($id = null)
    {
        $model = $id === null ? new FreightTemplate() : FreightTemplate::findOne($id);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
