<?php
namespace common\components;

use common\models\AdminLog;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Log
{
    public static function write($event)
    {
        // 排除日志表自身,没有主键的表不记录（没想到怎么记录。。每个表尽量都有主键吧，不一定非是自增id）
        if( $event->sender instanceof AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        self::processAdminLog($event);
    }

    /**
     * 记录后台业务操作日志.
     * @param  object $event
     */
    protected static function processOperationLog($event)
    {
    }

    /**
     * 记录后台总日志.
     * @param  object $event
     */
    protected static function processAdminLog($event)
    {
        // 显示详情有待优化,不过基本功能完整齐全
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
        $userId = Yii::$app->user->uid;
        $ip = ip2long(Yii::$app->request->userIP);
        $module = Yii::$app->controller->module->id;
        $data = [
            'route' => $route,
            'description' => $description,
            'user_id' => $userId,
            'module' => $module,
            'ip' => $ip,
            'created_at' => time()
        ];
        self::saveLog(new AdminLog(),$data);
    }

    /**
     * 保存日志.
     * @param  object $model
     * @param  array $data
     */
    public static function saveLog($model,$data)
    {
        $model->setAttributes($data);
        $model->save();
    }

}