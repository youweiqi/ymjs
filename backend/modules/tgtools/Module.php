<?php

namespace backend\modules\tgtools;

/**
 * fqtools module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'tg-channel';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\tgtools\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
