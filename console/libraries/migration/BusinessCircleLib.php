<?php
namespace console\libraries\migration;

use common\models\BusinessCircle;
use console\models\HotBusinessDistrictV2;
use yii\helpers\Console;

class BusinessCircleLib
{
    /**
     * 执行.
     */
    public static function run()
    {
        $page = 1;
        $page_size = 100;
        $count = HotBusinessDistrictV2::find()->count();
        if($count<=$page_size){
            $hot_business_districts = HotBusinessDistrictV2::find()->asArray()->all();
            if(is_array($hot_business_districts)){
                self::migration($hot_business_districts);
            }
        }else{
            do {
                $offset = ($page-1)*$page_size;
                $hot_business_districts = HotBusinessDistrictV2::find()
                    ->offset($offset)->limit($page_size)->asArray()->all();
                if(is_array($hot_business_districts)){
                    self::migration($hot_business_districts);
                }
                $page++;
            }while($count > $offset);
        }
    }

    /**
     * 开始数据迁移.
     * @param  array $hot_business_districts    商圈数据数组
     */
    private static function migration($hot_business_districts)
    {
        foreach ($hot_business_districts as $hot_business_district)
        {
            $business_circle_model = new BusinessCircle();
            $business_circle_model->circle_name = $hot_business_district['businessDistrictName'];
            $business_circle_model->back_image_path = $hot_business_district['bdBigImgPath'];
            $business_circle_model->province = $hot_business_district['province'];
            $business_circle_model->city = $hot_business_district['city'];
            $business_circle_model->area = $hot_business_district['area'];
            $business_circle_model->lon = $hot_business_district['lng'];
            $business_circle_model->lat = $hot_business_district['lat'];
            $business_circle_model->status = 1;

            if($business_circle_model->save()){
                $message = Console::ansiFormat('原ID为：'.$hot_business_district['id']."  的数据插入成功，新ID为".$business_circle_model->id."！", [Console::FG_GREEN]);
            }else{
                $message = Console::ansiFormat('原ID为：'.$hot_business_district['id']."  的数据插入失败！", [Console::FG_RED]);
            }
            echo $message."\n";
            unset($business_circle_model);
        }
    }
}