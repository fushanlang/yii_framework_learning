<?php
include(dirname(__FILE__).'/../config.php');
// include Yii bootstrap file
include(YII.'/framework/yii.php');

$config=dirname(__FILE__).'/protected/config/main.php';

// create a Web application instance and run
Yii::createWebApplication($config)->run();