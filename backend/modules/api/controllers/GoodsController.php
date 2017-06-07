<?php
namespace backend\modules\api\controllers;

use backend\libraries\ApiGoodsLib;
use backend\libraries\GoodsLib;
use backend\modules\api\core\ApiException;
use backend\modules\api\core\Controller;
use Yii;


/**
 * Default controller for the `api` module
 */
class GoodsController extends Controller
{

    public function actionReceive()
    {
        $post = Yii::$app->request->post();
        if(isset($post['data'])) {
            $data = json_decode($post['data'],true);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                 ApiGoodsLib::processApiGoods($data);
            } catch (ApiException $e) {
                $transaction->rollBack();
                throw new ApiException($e->getMessage(), $e->getCode(), $e);
            }
        }else{
            Yii::info($post);
            throw new ApiException(400, '', null);
        }
    }
}
