<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 10/4/17
 * Time: AM10:33
 */

namespace backend\components;

use yii\db\AfterSaveEvent;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class AdminLog{

    public static function write($event){

        if($event->sender instanceof \common\models\AdminLog||!$event->sender->primaryKey()){
           return;
        }
         $a=$event->name;
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增了表%s %s:%s的%s";
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改了表%s %s:%s的%s";
        } else {
            $description = "%s删除了表%s %s:%s%s";
        }

        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $event->sender->getAttributeLabel($name) . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }
        $userName = Yii::$app->user->identity->username;
        $tableName = $event->sender->tableSchema->name;
        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], $event->sender->getPrimaryKey(), $desc);
        $route = Url::to();
        $routes = explode("/",$route);
        $action = $routes['3'];
        $controller = $routes['2'];
        $userId = Yii::$app->user->id;
        $ip = ip2long(Yii::$app->request->userIP);
        $time=date("Y-m-d H:i:s",time());
        $primary_key = \common\models\AdminLog::getLogPrimaryKey($tableName);
        $primary_value = isset($event->sender->$primary_key) ? $event->sender->$primary_key : '';
        $data = [
            'status'=>'1',
            'querystring' => $route,
            'action'=>$action,
            'controller'=>$controller,
            'remark' => $description,
            'uid' => $userId,
            'title'=>'暂时都叫这个',
            'ip' => $ip,
            'create_time' =>$time
        ];
        $model = new \common\models\AdminLog();
        $model::tableName();
        $model->setAttributes($data);
        $model->save(false);
    }

}