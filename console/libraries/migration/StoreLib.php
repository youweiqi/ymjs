<?php
namespace console\libraries\migration;

use common\models\Store;
use console\models\StoreInfoV2;
use yii\helpers\Console;

class StoreLib
{
    /**
     * 执行.
     */
    public static function run()
    {
        $page = 1;
        $page_size = 100;
        $count = StoreInfoV2::find()->count();
        if($count<=$page_size){
            $stores = StoreInfoV2::find()->asArray()->all();
            if(is_array($stores)){
                self::migration($stores);
            }
        }else{
            do {
                $offset = ($page-1)*$page_size;
                $stores = StoreInfoV2::find()
                    ->offset($offset)->limit($page_size)->asArray()->all();
                if(is_array($stores)){
                    self::migration($stores);
                }
                $page++;
            }while($count > $offset);
        }
    }

    /**
     * 开始数据迁移.
     * @param  array $stores    店铺数据数组
     */
    private static function migration($stores)
    {
        foreach ($stores as $store)
        {
            $store_model = new Store();
            $store_model->store_name = $store['storeName'] ? $store['storeName'] : '';
            $store_model->province = $store['province'] ? $store['province'] : '';
            $store_model->city = $store['city'] ? $store['city'] : '';
            $store_model->area = $store['area'] ? $store['area'] : '';
            $store_model->address = $store['address'] ? $store['address'] : '';
            $store_model->lon = $store['lng'] ? $store['lng'] : '';
            $store_model->lat = $store['lat'] ? $store['lat'] : '';
            $store_model->status = 1;

            if($store_model->save()){
                $message = Console::ansiFormat('原ID为：'.$store['id']."  的数据插入成功，新ID为".$store_model->id."！", [Console::FG_GREEN]);
            }else{
                $message = Console::ansiFormat('原ID为：'.$store['id']."  的数据插入失败！", [Console::FG_RED]);
            }
            echo $message."\n";
            unset($store_model);
        }
    }
}