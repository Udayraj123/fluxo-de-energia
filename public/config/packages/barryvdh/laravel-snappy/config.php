<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' => base_path('vendor/bin/wkhtmltox/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => base_path('vendor/bin/wkhtmltoimage-amd64'),
        'timeout' => false,
        'options' => array(),
    ),


);
