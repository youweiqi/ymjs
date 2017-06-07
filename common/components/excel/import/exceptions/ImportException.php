<?php

namespace common\components\excel\import\exceptions;

use yii\base\Exception;

class ImportException extends Exception
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Import Exception';
    }
}
