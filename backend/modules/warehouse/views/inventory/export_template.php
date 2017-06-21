<?php
use backend\libraries\InventoryLib;
use common\widgets\excel\Excel;

Excel::widget([
    'isMultipleSheet' => true,
    'models' =>[
        'inventory' => $model
    ],
    'mode' => 'export',
    'fileName' => '库存模板',
    'columns' => [
        'inventory' => [
            'id',
            [
                'attribute' => 'product_bn',
                'value' => 'product.product_bn'
            ],
            [
                'attribute' => 'spec_name',
                'value' => 'product.spec_name'
            ],
            [
                'attribute' => 'store_name',
                'value' => 'store.store_name'
            ],
            [
                'attribute' => 'goods_name',
                'value' => 'goods.name'
            ],
            [
                'attribute' => 'goods_sale',
                'value' => function ($model) {
                    return $model->goods->suggested_price/100;
                }
            ],
            [
                'attribute' => 'sale_price',
                'value' => function ($model) {
                    return $model->sale_price/100;
                }
            ],
            'inventory_num',
        ]
    ],

    'headers' => [
        'inventory' => InventoryLib::ioTitle()
    ],
]);
?>





