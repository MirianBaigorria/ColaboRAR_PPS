<?php
defined('YII_DEBUG') or define('YII_DEBUG', true); // Activa modo debug
defined('YII_ENV') or define('YII_ENV', 'prod');    // Entorno de desarrollo

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
