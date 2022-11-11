<?php


// comment out the following two lines when deployed to production

$host = parse_url('https://' . $_SERVER['HTTP_HOST']);
define('MAIN_HOST', $host['host']);

$fileDefines = __DIR__ . '/../config/' . MAIN_HOST . '.defines.php';
if (!file_exists($fileDefines)) die('no file defines');
require $fileDefines;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../config/defines.php';
require __DIR__ . '/../lib/funcs.php';

$config = require __DIR__ . '/../config/odmin.php';

(new yii\web\Application($config))->run();
