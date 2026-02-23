<?php
require_once 'vendor/autoload.php';
$config = require 'config/config.php';

$app = app\source\App::getInstance($config);
$app->run();
