<?php
namespace backend\libraries;

use common\components\Common;
use common\components\QiNiu;
use common\models\Brand;
use common\models\Goods;
use common\models\GoodsDetail;
use common\models\GoodsNavigate;
use common\models\GoodsService;
use common\models\GoodsSpecificationImages;
use common\models\Product;
use common\models\Specification;
use common\models\SpecificationDetail;
use common\models\Store;
use common\models\StoreBrand;
use common\models\StoreSerial;
use common\models\SupplierUsuallyGoods;
use Yii;

class GoodsLib
{
    /**
     * 通过商品ID获取商品轮播图第一张
     * @param  integer $goods_id
     * @param  string $px 图片的显示尺寸
     * @return mixed
     */
    public static function getGoodsImg($goods_id, $px = '30px')
    {
        $goods_navigate = GoodsNavigate::find()->where('good_id=:gid', [':gid' => $goods_id])->asArray()->one();
        return Common::getImage($goods_navigate['navigate_image'], $px);
    }

    /**
     * 获取商品的规格ID数组
     * @param  string $spec_desc 商品规格信息
     * @return mixed
     */
    public static function getGoodSpecIds($spec_desc)
    {
        $good_spec_id_arr = [];
        if (!empty($spec_desc)) {
            $spec_desc_arr = json_decode($spec_desc, true);
            foreach ($spec_desc_arr as $value) {
                $good_spec_id_arr[] = isset($value['specificationId']) ? $value['specificationId'] : '';
            }
        }
        return !empty($good_spec_id_arr) ? $good_spec_id_arr : [0 => '', 1 => ''];
    }

    /**
     * 通过商品的规格信息获取规格对应数组
     * @param  string $spec_desc
     * @return mixed
     */
    public static function getGoodSpecInfo($spec_desc)
    {
        $good_spec_info_arr = ['classify_info' => [], 'spec_info' => []];
        if (!empty($spec_desc)) {
            $spec_desc_arr = json_decode($spec_desc, true);
            if (isset($spec_desc_arr[0]['specificationId'])) {
                $good_spec_info_arr['classify_info'] = [$spec_desc_arr[0]['specificationId'] => $spec_desc_arr[0]['name']];
                $good_spec_info_arr['spec_info'] = [$spec_desc_arr[1]['specificationId'] => $spec_desc_arr[1]['name']];
            }
        }
        return $good_spec_info_arr;
    }

    /**
     * 获取没有使用的属性和默认属性值
     * @param  object $model
     * @return mixed
     */
    public static function setDefaultAttributes($model)
    {
        $not_used_attributes = [
            'lowest_price' => 0,
            'unit' => '',
            'commision_limit' => 0,
            'app_display' => 1,
            'talent_display' => 1,
            'discount' => 0,
        ];
        foreach ($not_used_attributes as $key => $value) {
            $model->$key = $value;
        }
        return $model;
    }

    /**
     *  通过商品服务的ID数组获取服务的相关信息
     * @param  array $goods_service_ids
     * @return mixed
     */
    public static function getServiceDesc($goods_service_ids)
    {
        $service_desc_temp = $service_desc_arr = [];
        if (!empty($goods_service_ids) && is_array($goods_service_ids)) {
            $goods_service_arr = GoodsService::find()->where(['in', 'id', $goods_service_ids])->asArray()->all();
            foreach ($goods_service_arr as $goods_service) {
                $service_desc_temp['goodsServiceId'] = $goods_service['id'];
                $service_desc_temp['goodsServiceName'] = $goods_service['name'];
                $service_desc_temp['goodsServiceImage'] = $goods_service['image'];
                $service_desc_arr[] = $service_desc_temp;
                $service_desc_temp = [];
            }
        }
        //JSON_UNESCAPED_UNICODE参数项表示不将中文转义
        return json_encode($service_desc_arr, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 通过商品的id数组获取预览的商品数据
     * @param  array $goods_id_arr
     * @return mixed
     */
    public static function getSerialGoodsData($goods_id_arr)
    {
        $serial_goods_data = [];
        $goods_arr = Goods::find()->select('goods.id,goods.label_name,goods.suggested_price')->where(['in', 'goods.id', $goods_id_arr])->asArray()->all();
        $goods_navigate_arr = GoodsNavigate::find()->where(['in', 'good_id', $goods_id_arr])->groupBy('good_id')->asArray()->all();
        if (is_array($goods_arr) && !empty($goods_arr)) {
            foreach ($goods_arr as $goods) {
                $serial_goods_data[$goods['id']] = $goods;
            }
        }
        if (is_array($goods_navigate_arr) && !empty($goods_navigate_arr)) {
            foreach ($goods_navigate_arr as $goods_navigate) {
                $serial_goods_data[$goods_navigate['good_id']]['navigate_image'] = $goods_navigate['navigate_image'];
            }
        }
        return $serial_goods_data;
    }

    /**
     * 创建商品第二步的时候处理页面提交过来的数据.
     * @param  integer $goods_id
     * @param  array $post
     */
    public static function createGoodsTwo($goods_id, $post)
    {
        $goods = Goods::findOne($goods_id);
        $spec_id_arr = self::processSpec($post['classifyData'], $post['specData'], $goods->brand_id);
        $spec_detail_data = self::processSpecDetail($spec_id_arr, $post['productData']);
        $goods_spec_data = self::processGoodsSpecImg($goods_id, $spec_detail_data, $post['classifyImgData']);
        $goods_spec_desc = self::getGoodsSpecDesc($spec_id_arr, $goods_spec_data);
        $goods->spec_desc = $goods_spec_desc;
        $goods->save(false);
        self::processGoodsNavigate($goods_id, $post['goodsNavigateImgData']);
        self::processGoodsDetail($goods_id, $post['goodsDetailImgData']);
        ProductLib::processProductData($goods_id, $spec_detail_data['product_data']);
    }

    public static function getGoodsSpecDesc($spec_id_arr, $goods_spec_data)
    {
        $classify_data = Specification::findOne($spec_id_arr['classify_id']);
        $spec_data = Specification::findOne($spec_id_arr['spec_id']);
        $classify_desc = ['name' => $classify_data->name, 'specificationId' => $classify_data->id, 'value' => $goods_spec_data['classify_data']];
        $spec_desc = ['name' => $spec_data->name, 'specificationId' => $spec_data->id, 'value' => $goods_spec_data['spec_data']];
        $goods_spec_desc = json_encode([0 => $classify_desc, 1 => $spec_desc], JSON_UNESCAPED_UNICODE);
        return $goods_spec_desc;
    }

    /**
     * 更新商品处理数据.
     * @param  integer $goods_id
     * @param  array $post
     */
    public static function updateGoods($goods_id, $post)
    {
        $goods = Goods::findOne($goods_id);
        $spec_id_arr = self::processSpec($post['classifyData'], $post['specData'], $goods->brand_id);

        $spec_detail_data = self::processSpecDetail($spec_id_arr, $post['productData']);

        $goods_spec_data = self::updateGoodsSpecImg($goods_id, $spec_detail_data, $post['classifyImgData']);

        $goods_spec_desc = self::getGoodsSpecDesc($spec_id_arr, $goods_spec_data);
        $goods->spec_desc = $goods_spec_desc;
        $goods->save(false);
        self::updateGoodsNavigate($goods_id, $post['goodsNavigateImgData']);
        self::updateGoodsDetail($goods_id, $post['goodsDetailImgData']);
        ProductLib::updateProductData($goods_id, $spec_detail_data['product_data']);
    }


    public static function updateGoodsDetail($goods_id, $goods_detail_data)
    {
        $goods_details = GoodsDetail::find()->where(['=', 'good_id', $goods_id])->asArray()->all();
        GoodsDetailLib::delGoodsDetails($goods_details);
        foreach ($goods_detail_data as $key => $goods_detail) {
            $image_ret = QiNiu::qiNiuDirectUpload($goods_detail, 'goodsNavigateImg');
            if (isset($image_ret['key'])) {
                $size_info = getimagesize($goods_detail);
                $goods_navigate_model = new GoodsDetail();
                $goods_navigate_model->image_path = $image_ret['key'];
                $goods_navigate_model->image_height = $size_info[1];
                $goods_navigate_model->image_width = $size_info[0];
                $goods_navigate_model->good_id = $goods_id;
                $goods_navigate_model->order_no = $key + 1;
                $goods_navigate_model->save();
            }
        }
        return true;
    }


    public static function processGoodsDetail($goods_id, $goods_detail_data)
    {
        foreach ($goods_detail_data as $key => $goods_detail) {
            $image_ret = QiNiu::qiNiuDirectUpload($goods_detail, 'goodsNavigateImg');
            if (isset($image_ret['key'])) {
                $size_info = getimagesize($goods_detail);
                $goods_navigate_model = new GoodsDetail();
                $goods_navigate_model->image_path = $image_ret['key'];
                $goods_navigate_model->image_height = $size_info[1];
                $goods_navigate_model->image_width = $size_info[0];
                $goods_navigate_model->good_id = $goods_id;
                $goods_navigate_model->order_no = $key + 1;
                $goods_navigate_model->save();
            }
        }
        return true;
    }

    public static function updateGoodsNavigate($goods_id, $goods_navigate_img_data)
    {
        $goods_navigate_imgs = GoodsNavigate::find()->where(['=', 'good_id', $goods_id])->asArray()->all();
        GoodsNavigateLib::delGoodsNavigates($goods_navigate_imgs);
        foreach ($goods_navigate_img_data as $key => $goods_navigate_img) {
            $image_ret = QiNiu::qiNiuDirectUpload($goods_navigate_img, 'goodsNavigateImg');
            if (isset($image_ret['key'])) {
                $goods_navigate_model = new GoodsNavigate();
                $goods_navigate_model->navigate_image = $image_ret['key'];
                $goods_navigate_model->good_id = $goods_id;
                $goods_navigate_model->order_no = $key + 1;
                $goods_navigate_model->save();
            }
        }
        return true;
    }

    public static function processGoodsNavigate($goods_id, $goods_navigate_img_data)
    {
        foreach ($goods_navigate_img_data as $key => $goods_navigate_img) {
            $image_ret = QiNiu::qiNiuDirectUpload($goods_navigate_img, 'goodsNavigateImg');
            if (isset($image_ret['key'])) {
                $goods_navigate_model = new GoodsNavigate();
                $goods_navigate_model->navigate_image = $image_ret['key'];
                $goods_navigate_model->good_id = $goods_id;
                $goods_navigate_model->order_no = $key + 1;
                $goods_navigate_model->save();
            }
        }
        return true;
    }

    public static function updateGoodsSpecImg($goods_id, $spec_detail_data, $classify_img_data)
    {
        $goods_spec_imgs = GoodsSpecificationImages::find()->where(['=', 'goods_id', $goods_id])->asArray()->all();
        GoodsSpecificationImagesLib::delGoodsSpecImgs($goods_spec_imgs);
        $goods_spec_data = [];
        foreach ($spec_detail_data['classify_detail_data'] as $key => $value) {
            if (isset($classify_img_data[$key])) {
                $image_ret = QiNiu::qiNiuDirectUpload($classify_img_data[$key], 'goodsSpecImg');
                if (isset($image_ret['key'])) {
                    $goods_spec_model = new GoodsSpecificationImages();
                    $goods_spec_model->image_path = $image_ret['key'];
                    $goods_spec_model->goods_id = $goods_id;
                    $goods_spec_model->specification_detail_id = $value['classify_detail_id'];
                    $goods_spec_model->save();
                    $goods_spec_data['classify_data'][] = [
                        'specificationDetailId' => $goods_spec_model->specification_detail_id,
                        'detailName' => $value['classify_detail_name'],
                        'specificationDetailImage' => $goods_spec_model->image_path,
                    ];
                } else {
                    $goods_spec_data['classify_data'][] = [
                        'specificationDetailId' => $value['classify_detail_id'],
                        'detailName' => $value['classify_detail_name'],
                        'specificationDetailImage' => '',
                    ];
                }
            } else {
                $goods_spec_data['classify_data'][] = [
                    'specificationDetailId' => $value['classify_detail_id'],
                    'detailName' => $value['classify_detail_name'],
                    'specificationDetailImage' => '',
                ];
            }
        }
        foreach ($spec_detail_data['spec_detail_data'] as $key => $value) {
            $goods_spec_data['spec_data'][] = [
                'specificationDetailId' => $value['spec_detail_id'],
                'detailName' => $value['spec_detail_name'],
                'specificationDetailImage' => '',
            ];
        }
        return $goods_spec_data;
    }

    public static function processGoodsSpecImg($goods_id, $spec_detail_data, $classify_img_data)
    {
        $goods_spec_data = [];
        foreach ($spec_detail_data['classify_detail_data'] as $key => $value) {
            if (isset($classify_img_data[$key])) {
                $image_ret = QiNiu::qiNiuDirectUpload($classify_img_data[$key], 'goodsSpecImg');
                if (isset($image_ret['key'])) {
                    $goods_spec_model = new GoodsSpecificationImages();
                    $goods_spec_model->image_path = $image_ret['key'];
                    $goods_spec_model->goods_id = $goods_id;
                    $goods_spec_model->specification_detail_id = $value['classify_detail_id'];
                    $goods_spec_model->save();
                    $goods_spec_data['classify_data'][] = [
                        'specificationDetailId' => $goods_spec_model->specification_detail_id,
                        'detailName' => $value['classify_detail_name'],
                        'specificationDetailImage' => $goods_spec_model->image_path,
                    ];
                } else {
                    $goods_spec_data['classify_data'][] = [
                        'specificationDetailId' => $value['classify_detail_id'],
                        'detailName' => $value['classify_detail_name'],
                        'specificationDetailImage' => '',
                    ];
                }
            } else {
                $goods_spec_data['classify_data'][] = [
                    'specificationDetailId' => $value['classify_detail_id'],
                    'detailName' => $value['classify_detail_name'],
                    'specificationDetailImage' => '',
                ];
            }
        }
        foreach ($spec_detail_data['spec_detail_data'] as $key => $value) {
            $goods_spec_data['spec_data'][] = [
                'specificationDetailId' => $value['spec_detail_id'],
                'detailName' => $value['spec_detail_name'],
                'specificationDetailImage' => '',
            ];
        }
        return $goods_spec_data;
    }

    public static function getStoreIdArr($brand_id)
    {
        $stores = StoreBrand::find()->select('store_id')->where(['=', 'brand_id', $brand_id])->asArray()->all();
        $store_id_arr = [];
        foreach ($stores as $store) {
            $store_id_arr[] = $store['store_id'];

        }
        return $store_id_arr;
    }

    //查询对应门店的信息
    public static function getStoreName($brand_id)
    {
        $store_data = [];
        $stores = StoreBrand::find()->select('store_id')->where(['=', 'brand_id', $brand_id])->asArray()->all();
        $store_id_arr = [];
        foreach ($stores as $store) {
            $store_id_arr[] = $store['store_id'];
        }
        $store_names = Store::find()->select('id,store_name')->where(['in', 'store.id', $store_id_arr])->asArray()->all();

        foreach ($store_names as $store_name) {
            $store_data[$store_name['id']] = $store_name['store_name'];
        }
        return $store_data;
    }

    //更新商品关联门店
    public static function updateGoodsStore($store_ids, $brand_id)
    {
        $old_store_id_arr = self::getStoreName($brand_id);
        $store_id_arr = self::getUpdateStoreIdArr($store_ids, $old_store_id_arr);
        if (!empty($store_id_arr) && is_array($store_id_arr)) {
            StoreSerial::deleteAll(
                ['in', 'store_id', $store_id_arr['del']]);
        }
        if (!empty($store_id_arr) && is_array($store_id_arr['add'])) {
            $store_serial_arr = [];
            foreach ($store_id_arr['add'] as $store_id) {
                $store_serial['store_id'] = $store_id;
                //$store_serial['good_id']=$good_id;
                $store_serial_arr[] = $store_serial;
                $store_serial = [];

            }
            Yii::$app->db->createCommand()->batchInsert(StoreSerial::tableName(), ['store_id', 'serial_id'], $store_serial_arr)->execute();
        } else {
            return false;
        }
        return true;
    }

    //通过新旧ID数组获取需要删除或增加的ID数组
    public static function getUpdateStoreIdArr($new_store_id_arr, $old_store_id_arr)
    {
        $temp_new_store_id_arr = $new_store_id_arr;
        $temp_old_store_id_arr = $old_store_id_arr;
        $store_id_arr = [];
        if (empty($new_store_id_arr)) {
            $store_id_arr['add'] = [];
            $store_id_arr['del'] = $old_store_id_arr;
        } elseif (empty($old_store_id_arr)) {
            $store_id_arr['add'] = $new_store_id_arr;
            $store_id_arr['del'] = [];
        } else {
            foreach ($temp_new_store_id_arr as $key => $new_store_id) {
                if (in_array($new_store_id, $temp_old_store_id_arr)) {
                    unset($new_store_id_arr[$key]);
                }
            }
            foreach ($temp_old_store_id_arr as $key => $old_store_id) {
                if (in_array($old_store_id, $temp_new_store_id_arr)) {
                    unset($old_store_id_arr[$key]);
                }
            }
            $store_id_arr['add'] = $new_store_id_arr;
            $store_id_arr['del'] = $old_store_id_arr;
        }
        return $store_id_arr;
    }

    public static function processSpecDetail($spec_id_arr, $product_data)
    {
        $product_datas = $classify_detail_temp = $spec_detail_temp = $classify_detail_data = $spec_detail_data = $classify_detail_has_temp = $spec_detail_has_temp = [];
        foreach ($product_data as $key => $product) {
            if (empty($product['classifyDetailId'])) {
                if (!in_array($product['classifyDetailName'], $classify_detail_temp)) {
                    $classify_detail_model = new SpecificationDetail();
                    $classify_detail_model->specification_id = $spec_id_arr['classify_id'];
                    $classify_detail_model->detail_name = $product['classifyDetailName'];
                    $classify_detail_model->order_no = 1;
                    $classify_detail_model->save();
                    $classify_detail_temp[$classify_detail_model->id] = $product['classifyDetailName'];
                    $classify_detail_data[] = [
                        'classify_detail_id' => $classify_detail_model->id,
                        'classify_detail_name' => $product['classifyDetailName'],
                    ];
                    $product['classifyDetailId'] = $classify_detail_model->id;
                    unset($classify_detail_model);
                } else {
                    $temp = array_flip($classify_detail_temp);
                    $product['classifyDetailId'] = $temp[$product['classifyDetailName']];
                    unset($temp);
                }
            } else {
                if (!in_array($product['classifyDetailId'], $classify_detail_has_temp)) {
                    $classify_detail_data[] = [
                        'classify_detail_id' => $product['classifyDetailId'],
                        'classify_detail_name' => $product['classifyDetailName']
                    ];
                }
                $classify_detail_has_temp[] = $product['classifyDetailId'];
            }
            if (empty($product['specDetailId'])) {
                if (!in_array($product['specDetailName'], $spec_detail_temp)) {
                    $spec_detail_model = new SpecificationDetail();
                    $spec_detail_model->specification_id = $spec_id_arr['spec_id'];
                    $spec_detail_model->detail_name = $product['specDetailName'];
                    $spec_detail_model->order_no = 1;
                    $spec_detail_model->save();
                    $spec_detail_temp[$spec_detail_model->id] = $product['specDetailName'];
                    $spec_detail_data[] = [
                        'spec_detail_id' => $spec_detail_model->id,
                        'spec_detail_name' => $product['specDetailName']
                    ];
                    $product['specDetailId'] = $spec_detail_model->id;
                    unset($spec_detail_model);
                } else {
                    $temp = array_flip($spec_detail_temp);
                    $product['specDetailId'] = $temp[$product['specDetailName']];
                }
            } else {
                if (!in_array($product['specDetailId'], $spec_detail_has_temp)) {
                    $spec_detail_data[] = [
                        'spec_detail_id' => $product['specDetailId'],
                        'spec_detail_name' => $product['specDetailName']
                    ];
                }
                $spec_detail_has_temp[] = $product['specDetailId'];
            }
            $product_datas[] = $product;
        }
        $result = ['classify_detail_data' => $classify_detail_data, 'spec_detail_data' => $spec_detail_data, 'product_data' => $product_datas];
        return $result;
    }

    public static function processSpec($classify_data, $spec_data, $brand_id)
    {
        $result = ['classify_id' => $classify_data['classifyId'], 'spec_id' => $spec_data['specId']];
        if (empty($classify_data['classifyId'])) {
            $classify_model = new Specification();
            $classify_model->name = $classify_data['classifyName'];
            $classify_model->order_no = 1;
            $classify_model->brand_id = $brand_id;
            $classify_model->save();
            $result['classify_id'] = $classify_model->id;
        }
        if (empty($spec_data['specId'])) {
            $spec_model = new Specification();
            $spec_model->name = $spec_data['specName'];
            $spec_model->order_no = 1;
            $spec_model->brand_id = $brand_id;
            $spec_model->save();
            $result['spec_id'] = $spec_model->id;
        }
        return $result;
    }

    /**
     * 更新商品时，初始化商品数据.
     * @param  integer $goods_id 商品ID
     * @param  object $goods_form 商品更新表单对象
     * @return mixed
    //[['classify_detail_id'=>100,'classify_detail_name'=>'白色','classify_detail_image'=>'baise.png'],[...]]
     * public $classify_details;
     * //[['spec_detail_id'=>200,'spec_detail_name'=>'XL'],[...]]
     * public $spec_details;
     * //[['product_id'=>1,'classify_detail_name'=>'白色','classify_detail_id'=>100,'spec_detail_id'=>200,'spec_detail_name'=>'XL','product_bn'=>'test','bar_code'=>'test','status'=>1],[...]]
     * public $products;
     * //[['goods_navigate_id'=>10,'goods_navigate'=>'base64的数据'],[...]]
     * public $goods_navigates;
     * //[['goods_detail_id'=>10,'goods_detail'=>'base64的数据'],[...]]
     * public $goods_details;
     */
    public static function initGoodsForm($goods_id, $goods_form)
    {
        $goods = Goods::find()->where(['=', 'id', $goods_id])->asArray()->one();

        $spec = json_decode($goods['spec_desc'], true);
        list($classify_data, $spec_data) = $spec;
        $goods_form->goods_id = $goods_id;
        $goods_form->classify_id = $classify_data['specificationId'];
        $goods_form->classify_name = $classify_data['name'];
        $goods_form->spec_id = $spec_data['specificationId'];
        $goods_form->spec_name = $spec_data['name'];
        $goods_form->classify_details = self::getClassifyDetails($classify_data['value']);
        $goods_form->spec_details = self::getSpecDetails($spec_data['value']);
        $goods_form->products = self::getProducts($goods_id);
        $goods_form->goods_navigates = self::getGoodsNavigates($goods_id);
        $goods_form->goods_details = self::getGoodsDetails($goods_id);
        return $goods_form;

    }

    public static function getGoodsDetails($goods_id)
    {
        $goods_details = GoodsDetail::find()->where(['=', 'good_id', $goods_id])->asArray()->orderBy(['order_no' => SORT_ASC])->all();
        $goods_detail_data = [];
        $key = 1;
        foreach ($goods_details as $value) {
            $goods_detail = Common::getImgData($value['image_path']);
            $goods_detail_data[$key] = $goods_detail;
            $key++;
        }
        return $goods_detail_data;
    }

    public static function getGoodsNavigates($goods_id)
    {
        $goods_navigates = GoodsNavigate::find()->where(['=', 'good_id', $goods_id])->asArray()->orderBy(['order_no' => SORT_ASC])->all();
        $goods_navigate_data = [];
        $key = 1;
        foreach ($goods_navigates as $value) {
            $goods_navigate = Common::getImgData($value['navigate_image']);
            $goods_navigate_data[$key] = $goods_navigate;
            $key++;
        }
        return $goods_navigate_data;
    }

    public static function getClassifyDetails($classify_data)
    {
        $classify_data = is_array($classify_data) ? $classify_data : [];
        $classify_details = $classify_detail = [];
        foreach ($classify_data as $key => $value) {
            $classify_detail['classify_detail_id'] = $value['specificationDetailId'];
            $classify_detail['classify_detail_name'] = $value['detailName'];
            $classify_detail['classify_detail_image'] = Common::getImgData($value['specificationDetailImage']);
            $classify_details[$key] = $classify_detail;
        }
        return $classify_details;
    }

    public static function getSpecDetails($spec_data)
    {
        $spec_data = is_array($spec_data) ? $spec_data : [];
        $spec_details = $spec_detail = [];
        foreach ($spec_data as $key => $value) {
            $spec_detail['spec_detail_id'] = $value['specificationDetailId'];
            $spec_detail['spec_detail_name'] = $value['detailName'];
            $spec_details[$key] = $spec_detail;
        }
        return $spec_details;

    }

    public static function getProducts($goods_id)
    {
        $datas = [];
        $products = Product::find()->where(['and', 'is_del=0', ['=', 'goods_id', $goods_id]])->asArray()->all();
        if (is_array($products)) {
            foreach ($products as $product) {
                $data['product_bn'] = isset($product['product_bn']) ? $product['product_bn'] : '';
                $data['bar_code'] = isset($product['bar_code']) ? $product['bar_code'] : '';
                list($classify_detail_data, $spec_detail_data) = json_decode($product['spec_desc'], true);
                $data['classify_detail_id'] = isset($classify_detail_data['specificationDetailId']) ? $classify_detail_data['specificationDetailId'] : '';
                $data['classify_detail_name'] = isset($classify_detail_data['detailName']) ? $classify_detail_data['detailName'] : '';
                $data['spec_detail_id'] = isset($spec_detail_data['specificationDetailId']) ? $spec_detail_data['specificationDetailId'] : '';
                $data['spec_detail_name'] = isset($spec_detail_data['detailName']) ? $spec_detail_data['detailName'] : '';

                $datas[] = $data;
                unset($data);
            }
        }
        return $datas;
    }

    public static function generateGoodsCode($goods_bn, $goods_channel)
    {
        switch ($goods_channel) {
            case 1:
                $prefix = 'D';
                break;
            case 2:
                $prefix = 'M';
                break;
            case 3:
                $prefix = 'H';
                break;
            default:
                $prefix = 'D';
                break;
        }
        return $prefix . $goods_bn;
    }

    public static function getBrands($goods_id)
    {
        $brands_str = '';
        $brand_name_arr = [];
        $brands_arr = Goods::find()->select('goods.brand_id,brand.name_cn,brand.name_en')->joinWith(['brand'])->where('goods.id=:sid', [':sid' => $goods_id])->asArray()->all();
        if (!empty($brands_arr) && is_array($brands_arr)) {
            foreach ($brands_arr as $brand) {
                $brand_name_arr[] = empty($brand['name_cn']) ? $brand['name_en'] : $brand['name_cn'];
            }
            $brands_str = implode(',', $brand_name_arr);
        }
        return $brands_str;

    }

    //显示供应商常用商品这边的品牌

    public static function getGoods($goods_id){
        $brands_str = '';
        $brand_name_arr = [];
        $brands_arr = Goods::find()->select('brand_id,brand.name_cn,brand.name_en')->joinWith(['brand'])->where('goods.id=:sid',[':sid'=>$goods_id])->asArray()->all();
        if (!empty($brands_arr) && is_array($brands_arr)){
            foreach ($brands_arr as $brand){
                $brand_name_arr[] = empty($brand['name_cn'])?$brand['name_en']:$brand['name_cn'];
            }
            $brands_str = implode(',',$brand_name_arr);
        }
        return $brands_str;
    }
}