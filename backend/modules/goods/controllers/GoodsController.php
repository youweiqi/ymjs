<?php

namespace backend\modules\goods\controllers;

use backend\controllers\BaseController;
use backend\libraries\ApiGoodsLib;
use backend\libraries\GoodsLib;
use backend\libraries\GoodsServiceLib;
use backend\modules\goods\models\form\GoodsCommissionForm;
use backend\modules\goods\models\form\GoodsForm;
use backend\modules\goods\models\form\UpDownGoodsForm;
use common\helpers\ArrayHelper;
use common\models\Activity;
use common\models\ActivityDetail;
use common\models\Brand;
use common\models\Category;
use common\models\GoodsCommission;
use common\models\GoodsDetail;
use common\models\GoodsMallCommission;
use common\models\GoodsNavigate;
use common\models\GoodsService;
use common\models\GoodsSpecificationImages;
use common\models\Inventory;
use common\models\Product;
use common\models\SerialGoods;
use common\models\StoreCooperateGoods;
use Yii;
use common\models\Goods;
use backend\modules\goods\models\search\GoodsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\modules\goods\models\form\UploadImgForm;
use yii\web\UploadedFile;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends BaseController
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
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        if (Yii::$app->request->get('sub') === 'export') {
            $params = Yii::$app->request->get('GoodsSearch');
            parent::setQueueTask(5, $params);
            return $this->redirect(['/content/queue-tasks/index']);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
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
    public function actionCreate($goods_id=null,$step=1,$tag=0)
    {
        $post = Yii::$app->request->post();
        if(empty($goods_id) && $step==1){
            $model = new Goods(['scenario' => 'one']);
            if ($model->load($post)) {
                $model->service_desc = implode(',', $model->service_ids);
                unset($model->service_ids);
                $model->suggested_price = intval(strval($model->suggested_price * 100));
                if($model->save(false)){
                    return $this->redirect(['create','goods_id'=>$model->id,'step'=>2]);
                }
            }
            return $this->render('create_one', [
                'model' => $model,
            ]);
        }elseif(!empty($goods_id) && $step==2){
            $goods = Goods::findOne($goods_id);
            if($tag){
                GoodsLib::createGoodsTwo($goods_id,$post);
                return $this->redirect(['index']);
            }
            return $this->render('create_two', [
                'goods_id' => $goods_id,
                'brand_id' => $goods->brand_id,
//                'model'=>$model
            ]);

        }elseif (!empty($goods_id) && $step==3){
            return $this->render('create_three', [
            ]);

        }else{
            return $this->render('create_err', [
            ]);

        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$tag=0)
    {
        $model = new GoodsForm();
        $post = Yii::$app->request->post();
        if ($tag) {
            GoodsLib::updateGoods($id,$post);
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $model = GoodsLib::initGoodsForm($id,$model);
        return $this->render('update', [
            'model' => $model,
            'goods_id' => $id,
        ]);

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
        Product::deleteAll(['goods_id'=>$id]);
        Inventory::deleteAll(['goods_id'=>$id]);
        ActivityDetail::deleteAll(['goods_id'=>$id]);
        Activity::deleteAll(['good_id'=>$id]);
        GoodsDetail::deleteAll(['good_id'=>$id]);
        GoodsMallCommission::deleteAll(['good_id'=>$id]);
        GoodsNavigate::deleteAll(['good_id'=>$id]);
        GoodsSpecificationImages::deleteAll(['goods_id'=>$id]);
        SerialGoods::deleteAll(['good_id'=>$id]);
        StoreCooperateGoods::deleteAll(['good_id'=>$id]);


        return $this->redirect(['index']);
    }
    public function actionCreateGoods()
    {
        $post = Yii::$app->request->post();
        $goodsModel = new Goods(['scenario' => 'new_create']);
        if ($goodsModel->load($post)) {
//            $goodsModel->service_desc = implode(',', $goodsModel->service_ids);
//            unset($goodsModel->service_ids);
            $goodsModel->suggested_price = intval(strval($goodsModel->suggested_price * 100));
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $errors = [];
            try {
                //保存商品
                if (!$goodsModel->save(false)) {
                    throw new \Exception('goods save fail');
                }

                foreach ($post['product'] as $p) {
                    $specInfo = explode('|', $p['specInfo']);
                    $product['goods_id'] = $goodsModel->id;
                    $product['spec_info'] = $specInfo[0];
                    $product['spec_desc'] = $this->getProductSpecDesc($goodsModel->spec_desc);
                    $product['spec_name'] = $specInfo[1];
                    $product['bar_code'] = $p['bar_code'];
                    $product['product_bn'] = $p['product_bn'];
                    $product['status'] = $p['status'];
                    $product['image_path'] = $this->getFirstSpecImage($goodsModel->spec_desc, $specInfo[0]);
                    $products[] = $product;
                }
                $result = $connection->createCommand()->batchInsert(Product::tableName(), ['goods_id', 'spec_info', 'spec_desc', 'spec_name', 'bar_code', 'product_bn', 'status','image_path'], $products)->execute();
                if (!$result) {
                    throw new \Exception('save product fail');
                }
                $loopImgs = [];
                $i = 1;
                foreach ($_POST['upload_img'] as $item) {
                    if (!empty($item)) {
                        $loopImgs[] = [
                            'good_id' => $goodsModel->id,
                            'navigate_image' => $item,
                            'order_no' => $i++
                        ];
                    }
                }
                $result = $connection->createCommand()->batchInsert(GoodsNavigate::tableName(), ['good_id', 'navigate_image', 'order_no'], $loopImgs)->execute();
                if (!$result) {
                    throw new \Exception('save goods_navigate fail');
                }
                $i = 1;
                $goodsDetailImgData = [];
                foreach ($post['goodsDetailImg'] as $goodsDetail) {
                    $data = array_filter(explode('|', $goodsDetail));
                    if (count($data) == 3) {
                        $goodsDetailImgData[] = [
                            'image_path' => $data[0],
                            'good_id' => $goodsModel->id,
                            'image_height' => $data[1],
                            'image_width' => $data[2],
                            'order_no' => $i++,
                        ];
                    }
                }
                if(!empty($goodsDetailImgData))
                {
                    $result = $connection->createCommand()->batchInsert(
                        GoodsDetail::tableName(),
                        ['image_path','good_id', 'image_height', 'image_width','order_no'],
                        $goodsDetailImgData
                    )->execute();
                    if(!$result)
                    {
                        throw  new \Exception('save goods detail fail');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', '新建商品失败');
                return $this->redirect(Yii::$app->request->getReferrer());
            }
            Yii::$app->session->setFlash('success', '新建商品成功');
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->render('new_create', [
            'model' => $goodsModel
        ]);
    }

    public function actionUpdateGoods($id)
    {
        $post = Yii::$app->request->post();
        $goodsModel = Goods::findOne($id);
        if ($goodsModel->load($post)) {
//            $goodsModel->service_desc = implode(',', $goodsModel->service_ids);
//            unset($goodsModel->service_ids);
            $goodsModel->suggested_price = intval(strval($goodsModel->suggested_price * 100));
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $errors = [];
            try {
                //保存商品
                if (!$goodsModel->save(false)) {
                    throw new \Exception('goods save fail');
                }

                foreach ($post['product'] as $p) {
                    $specInfo = explode('|', $p['specInfo']);
                    $product['goods_id'] = $goodsModel->id;
                    $product['spec_info'] = $specInfo[0];
                    $product['spec_desc'] = $this->getProductSpecDesc($goodsModel->spec_desc);
                    $product['spec_name'] = $specInfo[1];
                    $product['bar_code'] = $p['bar_code'];
                    $product['product_bn'] = $p['product_bn'];
                    $product['status'] = $p['status'];
                    $product['image_path'] = $this->getFirstSpecImage($goodsModel->spec_desc, $specInfo[0]);
                    $products[] = $product;
                }
                $data = $this->dealProduct($products,$goodsModel->id);
                //需要更新的数据
                foreach ($data['update'] as $datum)
                {
                    /** @var Product $p */
                    $p = $datum['model'];
                    $p->goods_id = $datum['new_data']['goods_id'];
                    $p->spec_info = $datum['new_data']['spec_info'];
                    $p->spec_desc = $datum['new_data']['spec_desc'];
                    $p->spec_name = $datum['new_data']['spec_name'];
                    $p->bar_code = $datum['new_data']['bar_code'];
                    $p->product_bn = $datum['new_data']['product_bn'];
                    $p->status = $datum['new_data']['status'];
                    $p->image_path = $datum['new_data']['image_path'];
                    $p->update_time = date('Y-m-d H:i:s');
                    if(!$p->save(false))
                    {
                        throw  new \Exception('update product fail');
                    }
                }
                //插入新数据
                if(!empty($data['insert']))
                {
                    $result = $connection->createCommand()->batchInsert(Product::tableName(), ['goods_id', 'spec_info', 'spec_desc', 'spec_name', 'bar_code', 'product_bn', 'status', 'image_path'], $data['insert'])->execute();
                    if (!$result) {
                        throw new \Exception('insert new product fail');
                    }
                }

                //处理要删除的货品
                foreach ($data['delete'] as $v)
                {
                    /** @var Product $v */
                    $v->is_del = 1;
                    if(!$v->save(false))
                    {
                        throw new \Exception('delete product fail');
                    }
                }

                GoodsNavigate::deleteAll('good_id = '.$goodsModel->id);
                $loopImgs = [];
                $i = 1;
                foreach ($_POST['upload_img'] as $item) {
                    if (!empty($item)) {
                        $loopImgs[] = [
                            'good_id' => $goodsModel->id,
                            'navigate_image' => $item,
                            'order_no' => $i++
                        ];
                    }
                }
                $result = $connection->createCommand()->batchInsert(GoodsNavigate::tableName(), ['good_id', 'navigate_image', 'order_no'], $loopImgs)->execute();
                if (!$result) {
                    throw new \Exception('save goods_navigate fail');
                }

                $i = 1;
                $goodsDetailImgData = [];
                foreach ($post['goodsDetailImg'] as $goodsDetail) {
                    $data = array_filter(explode('|', $goodsDetail));
                    if (count($data) == 3) {
                        $goodsDetailImgData[] = [
                            'image_path' => $data[0],
                            'good_id' => $goodsModel->id,
                            'image_height' => $data[1],
                            'image_width' => $data[2],
                            'order_no' => $i++,
                        ];
                    }
                }
                GoodsDetail::deleteAll('good_id = '.$goodsModel->id);
                if (!empty($goodsDetailImgData)) {
                    $result = $connection->createCommand()->batchInsert(
                        GoodsDetail::tableName(),
                        ['image_path', 'good_id', 'image_height', 'image_width', 'order_no'],
                        $goodsDetailImgData
                    )->execute();
                    if (!$result) {
                        throw  new \Exception('save goods detail fail');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(Yii::$app->request->getReferrer());
            }
            Yii::$app->session->setFlash('success', '编辑商品成功');
            return $this->redirect(Yii::$app->request->getReferrer());
        }else{
            $data = $this->getGoodsData($goodsModel);
        }

        return $this->render('new_update', [
            'data' => $data
        ]);
    }
    public function getProductSpecDesc($goodsSpecDesc)
    {
        $data = json_decode($goodsSpecDesc,1);
        $result = [];
        foreach ($data as $spec)
        {
            foreach ($spec['value'] as $specDetail)
            {
                $result[] = [
                    'specificationDetailId' => $specDetail['specificationDetailId'],
                    'detailName' => $specDetail['detailName']
                ];
            }
        }
        return json_encode($result);
    }
    public function getGoodsData(Goods $goodsModel)
    {
        $data = [];
        $goodsModel->service_ids = explode(',',$goodsModel->service_desc);
        $goodsModel->suggested_price = $goodsModel->suggested_price/100;

        $data['model'] = $goodsModel;
        //获取规格信息
        $spec = json_decode($goodsModel->spec_desc,1);
        $globalSpecInfo = [];
        $firstSpec = [];//第一个规格的图
        if($spec)
        {
            foreach ($spec as $k => $v)
            {
                $tmp = [
                    'id' => $v['specificationId'],
                    'name' => $v['name'],
                    'values' => []
                ];
                foreach ($v['value'] as $i => $item)
                {
                    $tmp['values'][] = [
                        'id' => $item['specificationDetailId'],
                        'value' => $item['detailName']
                    ];
                    if($k == 0)
                    {
                        $firstSpec[] = [
                            'id' => $item['specificationDetailId'],
                            'value' => $item['detailName']
                        ];
                    }
                }
                $globalSpecInfo[] = $tmp;
            }
        }
        $data['specGlobalInfo'] = $globalSpecInfo;
        $data['goodsDetail'] = GoodsDetail::findAll('good_id = '.$goodsModel->id);
        $data['goodsNavigate'] = GoodsNavigate::findAll('good_id ='.$goodsModel->id);
        $pdatas = Product::find()->where(['is_del' => 0,'goods_id'=>$goodsModel->id])->asArray()->all();
        $data['products'] = [];
        foreach ($pdatas as $v)
        {
            $data['products'][] = [
                'specInfo' => $v['spec_info']."|".$v['spec_name'],
                'bar_code' => $v['bar_code'],
                'product_bn' => $v['product_bn'],
                'status' => $v['status'],
                'image_path' => $v['image_path'],
                'first_spec_value_id' => $this->firstProductSpecId($v['spec_info'],$firstSpec),
            ];
        }
        $brand = Brand::findOne($goodsModel->brand_id);
        $services = GoodsService::find()->andWhere(['in','id',array_filter(explode(',',$goodsModel->service_desc))])->all();
        $goods_services = [];
        $service_names = [];
        foreach ($services as $s)
        {
            $goods_services[$s->id] = $s->name;
            $service_names[] = $s->name;
        }
        $data['goods_navigate'] = GoodsNavigate::find()->where(['good_id'=>$goodsModel->id])->asArray()->all();
        $data['goods_detail'] = GoodsDetail::find()->where(['good_id'=>$goodsModel->id])->asArray()->all();
        $data['product_table'] = $this->renderProductTable($globalSpecInfo,$pdatas);
        $data['spec_tbody'] = $this->renderUploadFileTable($goodsModel->spec_desc);
        $data['brand_data'] = $brand != null ? [$brand->id=>$brand->name_cn]:[];
        $data['model']->service_desc = explode(',',$goodsModel->service_desc);
        $data['goods_services'] = $goods_services;
        return $data;
    }
    //把规格组合的货品表格渲染出来
    public function renderProductTable($globalSpecInfo,$pdatas){
        $ps = [];
        foreach ($pdatas as $p)
        {
            $ps[$p['spec_info']] = $p;
        }
        $ps;
        $tableHeader = '<thead id="spec_table_thead_id"><tr valign="middle">';
        foreach ($globalSpecInfo as $spec)
        {
            $tableHeader .= '<th>' . $spec['name'] . '</th>';
        }
        $tableHeader .= "<th>货号</th><th>条形码</th><th>状态</th></tr></thead>";

        $z = 1;
        $total = 1;
        foreach ($globalSpecInfo as $spec)
        {
            $total *= count($spec['values']);
        }
        $trs = [];
        for($i = 0;$i<$total;$i++)
        {
            array_push($trs,[]);
        }
        for($j = count($globalSpecInfo)-1;$j>=0;$j--)
        {
            $v = count($globalSpecInfo[$j]['values']);
            for($i = 0;$i<$total;$i++)
            {
                $y = floor($i/$z)%$v;
                array_unshift($trs[$i],$globalSpecInfo[$j]['values'][$y]);
            }
            $z *= $v;
        }
        //重点结束
        $tbody = '<tbody id="spec_table_tbody_id">';
        for ($i = 0; $i < count($trs); $i++) //遍历每一行
        {
            $tr = '';
            $specValueIds = [];
            $specValues = [];
            $specInfo = [];
            $firstSpecId = '';
            for ($j = 0; $j < count($trs[$i]); $j++) {
                if($j == 0) {$firstSpecId = $trs[$i][$j]['id'];}
                array_push($specInfo,$trs[$i][$j]);
                array_push($specValueIds,$trs[$i][$j]['id']);
                array_push($specValues,$trs[$i][$j]['value']);
                $tr .= '<td data-id="'.$trs[$i][$j]['id'].'">'.$trs[$i][$j]['value'] . '</td>';
            }
//            usort($specInfo,function($a,$b){return $a['id']-$b['id'];});
            $specValueIds = array_map(function($a){return $a['id'];},$specInfo);
            $specValues = array_map(function($a) {return $a['value'];},$specInfo);
            $tbody .= '<tr>' .$tr .
                '<input name="product['.$i.'][firstSpecInfo]" value="'.$firstSpecId.'" type="hidden">' .
                '<input name="product['.$i.'][specInfo]" value="'.implode(',',$specValueIds).'|'.implode(' ',$specValues).'" type="hidden">' .
                '<td class="product_bn_td"> <input maxlength="20" value="'.$ps[implode(',',$specValueIds)]['product_bn'].'" name="product['.$i.'][product_bn]" class="tbody-form-control _product_bn form-control"  style="max-width:180px;"></td>' .
                '<td class="bar_code_td"> <input maxlength="20" value="'.$ps[implode(',',$specValueIds)]['bar_code'].'" name="product['.$i.'][bar_code]" class="tbody-form-control form-control"  style="max-width:180px;"></td>' .
                '<td class="status_td"> <select name="product['.$i.'][status]"> <option'.($ps[implode(',',$specValueIds)]['status'] == 0?'selected="selected"':'').' value="0">禁用</option> <option '.($ps[implode(',',$specValueIds)]['status'] == 1?'selected="selected"':'').'value="1" selected="selected">启用</option></select></td>' .
                '</tr>';
        }
        $tbody .= '</tbody>';
        $table = '<table id="spec_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">' .$tableHeader . $tbody .'</table>';

        return $table;
    }
    public function renderUploadFileTable($globalSpecInfo)
    {
        $globalSpecInfo = json_decode($globalSpecInfo,1);
        $firstSpec = [];
        for ($i = 0; $i < count($globalSpecInfo); $i++) {
            if (isset($globalSpecInfo[$i])) {
                $firstSpec = $globalSpecInfo[$i];
                break;
            }
        }
        $html = '';
        if (!empty($firstSpec)) {
            for ($j = 0; $j < count($firstSpec['value']); $j++) {
                $html .= '<tr class="">' .
                    '<td style="text-align: right;font-size: 14px;" class="spec_name_input_1_value_text_1">' . $firstSpec['value'][$j]['detailName'] . '</td>' .
                    '<td>' .
                    '<div class="uploading-btn-box-1 uploading-btn-box" style="display: none;">' .
                    '<div class="uploading-btn-default">选择要上传的图片</div>' .
                    '<i class="am-icon-cloud-upload"></i>' .
                    '<input type="file"  name="norms-imgfile" class="uploading-select-btn""><span style="color:red;"></span>' .
                    '<input type="hidden" class="spec_image_hidden_input" data-id="' . $firstSpec['value'][$j]['specificationDetailId'] . '" name="specImage[' . $firstSpec['value'][$j]['specificationDetailId'] . ']" value="' . $firstSpec['value'][$j]['specificationDetailImage'] . '">' .
                    '</div>' .
                    '<div class="uploading-show-warp-img-1 uploading-show-warp-img clearfix" style="display: block">' .
                    '<div class="uploading-show-img uploading-show-img-1">' .
                    '<img src="' . $firstSpec['value'][$j]['specificationDetailImage'] . '" class="spec_norms_imgs" data-id="1">' .
                    '<button type="button" class="spec-remove" style="">×</button>' .
                    '</div>' .
                    '<div class="uploading-show-text uploading-show-text-1">' .
                    '<p class="info-tips"><em class="required">*</em>1、商品规格仅限 1 张图片；</p>' .
                    '<p class="info-tips info-tips-10">2、本地上传图片大小不能超过200KB；</p>' .
                    '<p class="info-tips info-tips-10">3、商品规格图尺寸比例1:1；</p>' .
                    '</div>' .
                    '</div>' .
                    '</td>' .
                    '</tr>';
            }
            //            $('#spec_norms_table_tbody_id').html(html);
            //            $('.spec_table_norms_box').show();
        }
        return $html;
    }
    //根据货品spec_info字段和商品第一规格 获取当前货品的第一规格值的id
    public function firstProductSpecId($specInfo,$firstSpec)
    {
        $s = array_filter(explode(',',$specInfo));
        foreach ($firstSpec as $specValue)
        {
            if(in_array($specValue['id'],$s))
            {
                return $specValue['id'];
            }
        }
        return '';
    }
    public function dealProduct($newData, $goodsId)
    {
        $needDelDatas = [];
        $needUpdateDatas = [];
        $neeInsertDatas = [];
        $products = Product::find()->where(['goods_id'=>$goodsId])->all();
        $flags = [];
        foreach ($products as $p)//找到要删除的货品
        {
            $need_del = true;
            foreach ($newData as $v) {
                if ($p->spec_info == $v['spec_info'])//在新数据找到 存在的
                {
                    $need_del = false;
                    //需要更新
                    array_push($needUpdateDatas, [
                        'model'=>$p,
                        'new_data' => $v,
                    ]);
                }else{
                    if(in_array($v['spec_info'],$flags))
                    {
                        continue;
                    }else{
                        array_push($flags,$v['spec_info']);
                        array_push($neeInsertDatas, $v);
                    }
                }
            }
            if($need_del)
            {
                array_push($needDelDatas,$p);
            }
        }
        return [
            'update' => $needUpdateDatas,
            'insert' => $neeInsertDatas,
            'delete' => $needDelDatas
        ];

    }
    //获取第一个规格的图
    public function getFirstSpecImage($goodsSpecDesc,$prodcutSpecValueIds)
    {
        static  $productSpecImage ;
        if(!isset($productSpecImage))
        {
            $allSpec = json_decode($goodsSpecDesc,1);
            if(isset($allSpec[0]))
            {
                foreach ($allSpec[0]['value'] as $v)
                {
                    $productSpecImage[$v['specificationDetailId']] = $v['specificationDetailImage'];
                }
            }
        }
        $valuesIds = array_filter(explode(',',$prodcutSpecValueIds));
        foreach ($valuesIds as $id)
        {
            if(isset($productSpecImage[$id])){
                return $productSpecImage[$id];
            }
        }
        return '';
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
    public function actionUpDownGoods()
    {
        $model=new UpDownGoodsForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids= unserialize($model->ids);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = Goods::updateAll(['online_time' =>$model->online_time,'offline_time'=>$model->offline_time], ['id' => $ids]);
                if (!$res) {
                    throw new \Exception('操作更新上下架时间的步骤失败！');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('up_down_goods', ['model' => $model]);
    }
    //验证UpDownGoodsForm
    public function actionValidateUpDownGoodsForm ()
    {
        $model=new UpDownGoodsForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionUpdateGoodCommission($goods_id)
    {
        $model = $this->findModel($goods_id);
        $commision =  $model->getGoods_commission();
        if($post = Yii::$app->request->post()){

        if(isset($commision->id)){
            $commision->load(Yii::$app->request->post());
            $commision->save();
            $description = '更新商品分佣';
            $this->writeLog($model->id,$commision->commission,'goods_commission',$description);

        }else{
            $commision->good_id = $goods_id;
            $commision->load(Yii::$app->request->post());
            $commision->save();
            $description = '新增商品分佣';
            $this->writeLog($model->id,$commision->commission,'goods_commission',$description);

        }
            $model->save(false);
            return $this->redirect(Yii::$app->request->getReferrer());
        }else{
            return $this->renderAjax('_form', [
            'model' => $model,
            'goods_id' => $goods_id,
            ]);
            }
    }


    public function actionUpdateGoodsCommission()
    {
        $model=new GoodsCommissionForm();
        $post = Yii::$app->request->post();
        if (isset($post['ids'])) {
            $model->ids = serialize($post['ids']);
        } elseif ($model->load($post)) {
            $ids = unserialize($model->ids);
         $good_ids = GoodsCommission::find()->select('good_id')->asArray()->all();
           $good_id = ArrayHelper::getColumn($good_ids,'good_id');
            $goods_some = array_intersect($ids,$good_id);
            $goods_diff = array_diff($ids,$good_id);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = GoodsCommission::updateAll(['commission' =>$model->commission], ['good_id' => $goods_some]);

                $goods = [];
                foreach ($goods_diff as $v){
                    $good = [];
                    $good['good_id'] = $v;
                    $good['commission'] = $model->commission;
                    $good['role_id'] = 0;
                    $good['indirect_commission'] = 0;
                    $goods[] = $good;

                }
                $res1 = Yii::$app->db->createCommand()->batchInsert(GoodsCommission::tableName(), ['good_id', 'commission', 'role_id', 'indirect_commission'], $goods)->execute();


                if ($res===false && $res1 === false) {
                    throw new \Exception('操作更新分佣的步骤失败！');
                }
                $transaction->commit();
                $description = '批量设置分佣';
                $this->batchWriteLog($ids,[],'goods_commission',$description);
                Yii::$app->session->setFlash('success','批量设置商品分佣成功');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error','批量设置商品分佣失败');
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->renderAjax('goods_commission_form', ['model' => $model]);
    }
    public function actionSearchGood($name=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $data = Goods::find()
            ->select('goods.id as id, goods.name as text')
            ->andFilterWhere(['like', 'goods.name', $name])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = array_values($data);
        return $out;
    }


    public function actionGoodsCommissionValidateForm()
    {
        $model = new GoodsCommissionForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    public function actionGoodCommissionValidateForm($id = null)
    {
        $model = $id === null ? new GoodsCommission() : GoodsCommission::findOne(['good_id'=>$id]);
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
    public function actionUpload()
    {
        $uploadImgForm = new UploadImgForm();
        if ($uploadImgForm->load($_FILES)) {
            $uploadImgForm->img = UploadedFile::getInstance($uploadImgForm, 'img');
        }
        if($uploadImgForm->validate())
        {
            $imgUrl =   $uploadImgForm->save();
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(isset($imgUrl) && $imgUrl){
            $imageInfo = getimagesize($_FILES['UploadImgForm']["tmp_name"]['img']);
            return ['status'=>'succ','imgUrl'=>$imgUrl,'width' => $imageInfo[0],'height' => $imageInfo[1]];
        }else{
            return ['status' => 'fail','errors' => $uploadImgForm->getErrors()];
        }
    }

    public function actionGetGoodDetailHtml()
    {
        $good_id = Yii::$app->request->post('good_id');
        echo ApiGoodsLib::getGoodDetailHtml($good_id);
    }

}
