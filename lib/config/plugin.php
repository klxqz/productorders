<?php

return array(
    'name' => 'Товар в заказах',
    'description' => 'Список заказов, в которых присутствует товар',
    'vendor' => '985310',
    'version' => '1.0.0',
    'img' => 'img/productorders.png',
    'shop_settings' => true,
    'frontend' => true,
    'handlers' => array(
        'backend_product' => 'backendProduct',
    ),
);
//EOF
