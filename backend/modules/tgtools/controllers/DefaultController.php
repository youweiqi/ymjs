<?php

namespace backend\modules\tgtools\controllers;

use yii\web\Controller;

/**
 * Default controller for the `tgtools` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
