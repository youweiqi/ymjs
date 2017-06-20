<?php
namespace backend\controllers;

use common\models\OperationLog;
use common\models\QueueTasks;
use Yii;
use common\core\Controller;
use backend\models\Config;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * ---------------------------------------
 * 后台父类控制器 
 * 后台所有控制器都继承自该类
 * @author longfei phphome@qq.com
 * ---------------------------------------
 */
class BaseController extends Controller
{

    /**
     * ---------------------------------------
     * 后台构造函数
     * ---------------------------------------
     */
    public function init()
    {
        /* 判断是否登录 */
        /*if (\Yii::$app->user->getIsGuest()) {
            $this->redirect(Url::toRoute(['/login/login']));
            Yii::$app->end();
        }*/

        /* 解析数据库配置，解析后存放在Yii::$app->params['web']中 */
        Yii::$app->params['web'] = Config::lists();
    }
    
    /**
     * ---------------------------------------
     * 标记当前位置到cookie供后续跳转调用
     * ---------------------------------------
     */
    public function setForward()
    {
        \Yii::$app->getSession()->setFlash('__forward__', $_SERVER['REQUEST_URI']);
    }

    /**
     * ---------------------------------------
     * 获取之前标记的cookie位置
     * @param string $default
     * @return mixed
     * ---------------------------------------
     */
    public function getForward($default='')
    {
        $default = $default ? $default : Url::toRoute([Yii::$app->controller->id.'/index']);
        if( Yii::$app->getSession()->hasFlash('__forward__') ) {
            return Yii::$app->getSession()->getFlash('__forward__');
        } else {
            return $default;
        }
    }

    /**
     * ---------------------------------------
     * 传统分页列表数据集获取方法
     * @param \yii\db\ActiveRecord $model   模型名或模型实例
     * @param array $where   where查询条件
     * @param array|string $order   排序条件
     * @return array|false
     * ---------------------------------------
     */
    public function lists($model, $where=[], $order='')
    {
        $query = $model::find()->where($where);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 10,
        ]);
        $data  = $query->orderBy($order)->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return [$data, $pages];
    }

    /**
     * ---------------------------------------
     * dataProvider列表数据集获取方法
     * @param \yii\db\ActiveRecord $model   模型名或模型实例
     * @param array        $where   where查询条件
     * @param array|string $order   排序条件
     * @return \yii\data\ActiveDataProvider
     * ---------------------------------------
     */
    public function lists1($model, $where=[], $order='')
    {
        $query = $model::find()->where($where)->orderBy($order)->asArray();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * ---------------------------------------
     * 修改数据表一条记录的一条值
     * @param \yii\db\ActiveRecord $model 模型名称
     * @param array  $data 数据
     * @return \yii\db\ActiveRecord|boolean
     * ---------------------------------------
     */
    public function saveRow($model, $data)
    {
        if (empty($data)) {
            return false;
        }
        if ($model->load($data, '') && $model->validate()) {
            /* 添加到数据库中,save()会自动验证rule */
            if ($model->save()) {
                return $model;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * ---------------------------------------
     * 由表主键删除数据表中的多条记录
     * @param \yii\db\ActiveRecord $model 模型名称,供M函数使用的参数
     * @param string  $pk  修改的数据
     * @return boolean
     * ---------------------------------------
     */
    public function delRow($model, $pk='id' )
    {
        $ids = Yii::$app->request->param($pk, 0);
        $ids = implode(',', array_unique((array)$ids));

        if ( empty($ids) ) {
            return false;
        }

        $_where = $pk.' in('.$ids.')';
        if($model::deleteAll($_where)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * ----------------------------------------------
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     * -----------------------------------------------
     */
    protected function error($message='',$jumpUrl='',$ajax=false)
    {
        $this->dispatchJump($message,0,$jumpUrl,$ajax);
    }

    /**
     * ----------------------------------------------
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     * ----------------------------------------------
     */
    protected function success($message='',$jumpUrl='',$ajax=false)
    {
        $this->dispatchJump($message,1,$jumpUrl,$ajax);
    }

    /**
     * ----------------------------------------------
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param int $status 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     * ----------------------------------------------
     */
    private function dispatchJump($message,$status=1,$jumpUrl='',$ajax=false)
    {
        $jumpUrl = !empty($jumpUrl)? (is_array($jumpUrl)?Url::toRoute($jumpUrl):$jumpUrl):'';
        if(true === $ajax || Yii::$app->request->isAjax) {// AJAX提交
            $data           =   is_array($ajax)?$ajax:array();
            $data['info']   =   $message;
            $data['status'] =   $status;
            $data['url']    =   $jumpUrl;
            $this->ajaxReturn($data);
        }
        // 成功操作后默认停留1秒
        $waitSecond = 3;

        if($status) { //发送成功信息
            $message = $message ? $message : '提交成功' ;// 提示信息
            // 默认操作成功自动返回操作前页面
            echo $this->renderFile(Yii::$app->params['action_success'],[
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        }else{
            $message = $message ? $message : '发生错误了' ;// 提示信息
            // 默认发生错误的话自动返回上页
            $jumpUrl = "javascript:history.back(-1);";
            echo $this->renderFile(Yii::$app->params['action_error'], [
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        }
        //Yii::$app->end();
        exit;
    }

    /**
     * ------------------------------------------------
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @return void
     * ------------------------------------------------
     */
    protected function ajaxReturn($data)
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data);
        //Yii::$app->end();
        exit;
    }

    /**
     * 记录业务操作日志.
     * @param  integer $objId    ID
     * @param  integer $objName    标识
     * @param  integer $operateType    操作类型
     * @param  string $description    描述
     */
    protected function writeLog($objId,$objName,$operateType,$description)
    {
        $operatorName = Yii::$app->user->identity->username;
        $ip = ip2long(Yii::$app->request->userIP);
        $route = Url::to();
        $operatorId = Yii::$app->user->id;
        $module = Yii::$app->controller->module->id;
        $createdAt = time();
        $data = [
            'obj_id' => $objId,
            'obj_name' => $objName,
            'module' => $module,
            'operate_type' => $operateType,
            'route' => $route,
            'operator_id' => $operatorId,
            'operator_name' => $operatorName,
            'created_at' => $createdAt,
            'description' => $description,
            'ip' => $ip,
        ];
        Yii::$app->logger->saveLog(new OperationLog(),$data);
    }
    /**
     * 批量记录业务操作日志.
     * @param  array $objIdArr    ID数组
     * @param  array $objNameArr    标识数组
     * @param  integer $operateType    操作类型
     * @param  string $description    描述
     */
    protected function batchWriteLog($objIdArr,$objNameArr,$operateType,$description)
    {
        $operatorName = Yii::$app->user->identity->username;
        $ip = ip2long(Yii::$app->request->userIP);
        $route = Url::to();
        $operatorId = Yii::$app->user->id;
        $module = Yii::$app->controller->module->id;
        $createdAt = time();
        foreach ($objIdArr as $objId)
        {
            $data = [
                'obj_id' => $objId,
                'obj_name' => isset($objNameArr[$objId])?isset($objNameArr[$objId]):'',
                'module' => $module,
                'operate_type' => $operateType,
                'route' => $route,
                'operator_id' => $operatorId,
                'operator_name' => $operatorName,
                'created_at' => $createdAt,
                'description' => $description,
                'ip' => $ip,
            ];
            $dataArr[] = $data;
            unset($data);
        }
        if(!empty($dataArr) && is_array($dataArr)){
            Yii::$app->db->createCommand()
                ->batchInsert(OperationLog::tableName(),
                    [
                        'obj_id',
                        'obj_name',
                        'module',
                        'operate_type',
                        'route',
                        'operator_id',
                        'operator_name',
                        'created_at',
                        'description',
                        'ip',
                    ],$dataArr)
                ->execute();
        }
    }

    /**
     * 查看日志.
     * @param  integer $id    ID
     * @param  string $type    日志类型
     * @return mixed
     */
    public function actionViewLog($id,$type)
    {
        $query = OperationLog::find()
            ->where(['obj_id'=>$id,'operate_type'=>$type])
            ->orderBy(['created_at'=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
            'sort' => false
        ]);
        return $this->renderAjax('//site/view_log', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 将导出任务保存到队列.
     * @param integer $taskType
     * @param array $params
     */
    protected function setQueueTask($taskType,$params)
    {
        $params['export_type'] = $taskType;
        $task = new QueueTasks();
        $task->operater = Yii::$app->user->getId();
        $task->create_time= date("Y-m-d H:i:s");
        $task->task_type = $taskType;
        $task->task_status = 0;
        $task->task_content= json_encode($params);
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $r = $task->save(false);
            if($r === false)
            {
                throw new \Exception('insert db fail');
            }
            //加入队列
            $payload = [
                "task_id" => $task->task_id,
                "task_content" => $params,
            ];
            Yii::$app->amqp->product("wuyou_exchange","export_{$taskType}_queue_wuyou","export_{$taskType}_routing_key_wuyou", json_encode($payload));
            $transaction->commit();
            Yii::$app->session->setFlash('success','创建新任务成功，任务id：'.$task->task_id);
        }catch (\Exception $e) {
            //获取抛出的错误
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', '创建任务失败 请联系管理员:'.$e->getMessage());
        }
    }


}
