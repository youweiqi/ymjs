<?php

namespace common\components\excel\export\exceptions;

use yii\base\Exception;

class ExportException extends Exception
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Export Exception';
    }
}
