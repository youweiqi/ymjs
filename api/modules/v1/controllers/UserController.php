<?php

namespace api\modules\v1\controllers;
use api\models\forms\LoginForm;
use common\models\ApiGoods;
use common\models\ApiUsers;
use common\models\Goods;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\IdentityInterface;

class UserController extends ActiveController
{
    /*public $modelClass = 'common\models\ApiUsers';
    public function behaviors() {
        return ArrayHelper::merge (parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                //'tokenParam' => 'token',
                'optional' => [
                    'login',
                    'signup-test'
                ],
            ]
        ] );
    }


    public function actionSignupTest ()
    {
        $user = new ApiUsers();
        $user->generateAuthKey();
        $user->setPassword('123456');
        $user->username = 'youweiqi';
        $user->email = '111@111.com';
        $user->salt = '110';
        $user->status = '1';
        $user->save(false);

        return [
            'code' => 0
        ];
    }




    /**
     * 根据type获取信息(丑陋)
     *  @token
     *  @type
     */
public function actionUserProfile ($token,$type)
{
    // 到这一步，token都认为是有效的了
    $user = ApiUsers::findIdentityByAccessToken($token);
    if($user){
        $data = [];
        // 根据type 获取数据
         if($type==='goods'){
             $data= ApiGoods::find()->asArray()->all();
         }elseif($type ==='users'){
             $data = ApiUsers::find()->select('id,username')->asArray()->all();
         }
        $array = [
            'status' => 'success',
            'code' => '200',
            'message' => '成功',
             $type =>$data
        ];
        return  $array;
    }
}

      public function actionLogin ()
      {
              $model = new LoginForm;
              $model->setAttributes(Yii::$app->request->post());
          if ($user = $model->login()) {
              if ($user instanceof IdentityInterface) {
                  return $user->api_token;
              } else {
                  return $user->errors;
              }
          } else {
              return $model->errors;
          }
      }



}