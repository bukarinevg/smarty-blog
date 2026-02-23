<?php
declare(strict_types=1);

namespace app\source\controller;

use app\source\App;
use app\source\db\DataBase;
use PDO;
/**
 * This is an abstract class that serves as the base controller for all controllers in the application.
 */
abstract class AbstractController
{
    public function __construct(protected App $app)
    {
    }

    protected function getPdo(): PDO
    {
        $config = $this->app->getConfig();
        return DataBase::getInstance($config['components']['db'])->db;
    }
}

