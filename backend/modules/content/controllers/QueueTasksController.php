<?php

namespace backend\modules\content\controllers;

use Yii;
use common\models\QueueTasks;
use backend\modules\content\models\search\QueueTasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QueueTasksController implements the CRUD actions for QueueTasks model.
 */
class QueueTasksController extends Controller
{
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
     * Lists all QueueTasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QueueTasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDown($f){
        if(preg_match('/.*\.csv$/', $f))
        {
            $path = Yii::getAlias("@csv_dir_path").$f;
        } else{
            echo "文件不存在"; exit;
        }
        if(!file_exists($path))
        {
            echo "文件不存在"; exit;
        }
        $fp = fopen($path, "r");
        header('Content-Type: text/csv; charset=gb2312');
        header('Content-Disposition: attachment; filename='.$f);
        $output = fopen('php://output', 'w');
        while (($line = fgets($fp)) !== false) {
            fputs($output, $line);
            ob_flush();
        }
        fclose($fp);
    }

}
