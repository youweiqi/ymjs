<?php
namespace backend\libraries;

use common\components\Common;
use common\models\Goods;
use common\models\Inventory;
use common\widgets\excel\Excel;

class InventoryLib
{
    /**
     * 导入的错误信息.
     */
     public static $error_msg=[];
     public static $status=true;

    public static function updateInventoryState($store_id,$state)
    {
        $inventory_model = new Inventory;
        $update_time = date("Y-m-d H:i:s");
        $inventory_model::updateAll(['update_time'=>$update_time,'state'=>$state],['store_id'=>$store_id]);
    }
    /**
     * 通过货品ID获取该货品在各个店铺的库存情况.
     * @param  integer $product_id
     * @return mixed
     */
    public static function getStoreInventoryHtml($product_id)
    {
        $inventories = Inventory::find()
            ->joinWith(['store'])
            ->select('inventory.*,store.store_name')
            ->where('inventory.product_id=:pid',[':pid'=>$product_id])
            ->asArray()
            ->all();
        $store_inventory_html = '<div class="division">
                                <h4>库存详情</h4>
                                <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>店铺ID</th>
                                            <th>店铺名称</th>
                                            <th>货品ID</th>
                                            <th>实际售价</th>
                                            <th>库存数</th>
                                        </tr>
                                    </thead><tbody>';
        foreach ($inventories as $inventory){
            $store_inventory_html .= '<tr>';
            $store_inventory_html .= '<td>'.$inventory['store_id'].'</td>';
            $store_inventory_html .= '<td>'.$inventory['store_name'].'</td>';
            $store_inventory_html .= '<td>'.$inventory['product_id'].'</td>';
            $store_inventory_html .= '<td>'.$inventory['sale_price']/100 .'</td>';
            $store_inventory_html .= '<td>'.$inventory['inventory_num'].'</td>';
            $store_inventory_html .= '</tr>';
            ;
        }
        $store_inventory_html .= '</tbody></table>
                            </div>';
        return $store_inventory_html;
    }
    /**
     * 获取商品的异业价格比率.

     * @return mixed
     */
    public static function getCooperateRate()
    {
        $cooperate_rate = 5;
        return $cooperate_rate;
    }

    public static function processImportInventory($import_file)
    {
        $data = self::getImportData($import_file->tempName);
        $pre_data = self::preProcessImport($data);
        //数据预处理完成并且正常，进行数据保存
        if($pre_data['status']){
            foreach ($pre_data['data'] as $value)
            {
                $id = $value['id'];
                unset($value['id']);
                Inventory::updateAll($value,['=','id',$id]);
            }
        }
        unset($pre_data['data']);
        return $pre_data;
    }

    private static function getImportData($file_name)
    {
        $data = Excel::widget([
            'mode' => 'import',
            'fileName' => $file_name,
            'setFirstRecordAsKeys' => true,
            'setIndexSheetByName' => true,
            'getOnlySheet' => 'inventory',
            'ioTitle' => self::ioTitle(),
        ]);
        return $data;
    }
    /**
     * 导入数据的预处理.
     * @param  array $data
     * @return mixed
     */
    private static function preProcessImport($data)
    {
        $res_data = [];
        $count = count($data);
        if($count>1000){
            if(self::$status) self::$status=false;
            self::$error_msg[]='导入数据过多，请控制在1000行以内';
        }
        $exist_inventory_id_arr = self::getInventoryIdArr();
        $data = self::ioFormat($data);
        foreach ($data as $key=>$value)
        {
            if(!in_array($value['id'], $exist_inventory_id_arr)){
                if(self::$status) self::$status=false;
                self::$error_msg[]='第'.($key+2).'行，该供应商没有该库存！';
            }else{
                if($value['sale_price']>=1){
                    $temp_data ['id'] = $value['id'];
                    $temp_data ['inventory_num'] = $value['inventory_num'];
                    $temp_data ['sale_price'] = $value['sale_price'];
                    $res_data[] = $temp_data;
                    unset($temp_data);
                }else{
                    if(self::$status) self::$status=false;
                    self::$error_msg[]='第'.($key+2).'行，销售价必须大于等于0.01！';
                }

            }
        }

        $pre_data['data'] = $res_data;
        $pre_data['status'] = self::$status;
        $pre_data['error_msg'] = self::$error_msg;

        return $pre_data;
    }
    public static function getInventoryIdArr()
    {
        $inventory_id_arr = [];
        $inventories = Inventory::find()
            ->select('inventory.id')
            ->asArray()
            ->all();
        foreach ($inventories as $inventory)
        {
            $inventory_id_arr[] = $inventory['id'];
        }
        return $inventory_id_arr;
    }
    /**
     * 将原始数据进行格式化处理
     * @param  array $data
     * @return mixed
     */
    private static function ioFormat($data)
    {
        $format = self::ioTitle('format');
        foreach ($data as $key=>$value)
        {
            foreach ($value as $k=>$v){
                $data[$key][$k] = self::formatter($v, $format[$k]);
            }
        }
        return $data;
    }

    /**
     * 数据格式器.
     * @param   $data
     * @param  string $type
     * @return mixed
     */
    private static function formatter($data,$type)
    {
        switch ($type)
        {
            case 'string':
                $data = trim($data);
                break;
            case 'money':
                $data = intval(strval($data * 100));
                break;
            case 'int':
                $data = intval(strval($data));
                break;
            case 'datetime':
                $data = \Yii::$app->formatter->asDatetime($data,'Y-M-d H:i:s');
                break;
            case 'bool':
                $data = trim($data)==='是'?1:0;
                break;
            default :
                $data = trim($data);
                break;
        }
        return $data;
    }
    public static function isRequired($title)
    {
        $required = self::ioTitle('required');

    }

    /**
     * 导入和导出Title.
     * @param  string $type
     * @return mixed
     */
    public static function ioTitle($type='title')
    {

        $title = [
            'id' => 'ID(勿动)',
            'product_bn' => '货号',
            'spec_name' => '规格',
            'store_name' =>'店铺名称',
            'goods_name' =>'商品名称',
            'inventory_num' => '库存',
            //'goods_sale' => '商品吊牌价(元)',
            'sale_price' => '实际销售价(元)',
        ];
        $format = [
            'id' => 'int',
            'product_bn' => 'string',
            'store_name'=>'string',
            'inventory_num' => 'int',
            'sale_price' => 'money',
            //'goods_sale' => 'money',
            'spec_name' => 'string',
            'goods_name' => 'string'
        ];
        $required = [
            'id',
            'spec_name',
            'goods_name',
            'product_bn',
            'store_name',
            'inventory_num',
            'sale_price',
            //'goods_sale',


        ];
        if('required'===$type){
            return $required;
        }elseif('format'===$type){
            return $format;
        }else{
            return $title;
        }
    }

    /**
     * 获取库存表里面有库存的最高利润
     */

    public static function getLowPrice($id)
    {
        $inventorys=Inventory::find()->select('goods_id,sale_price,cooperate_price')->where(['and',['=','goods_id',$id],['>','inventory_num','0']])->asArray()->all();
        $inventory_data=[];
        foreach ($inventorys as $inventory)
        {
            $inventory_data[]=$inventory['sale_price']-$inventory['cooperate_price'];
        }
        //获取最大值
        $pos=array_search(max($inventory_data),$inventory_data);
        return $inventory_data[$pos];
    }
    /**
     * 获取商品里面的good_id的吊牌价
     */

    public static function getGoodsSuggestedPrice($id)
    {
        $goods=Goods::findOne($id);
        if(!empty($goods)){
           return $suggested_price=$goods->suggested_price/100;
        }
        return $id;
    }
}