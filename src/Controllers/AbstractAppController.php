<?php
declare(strict_types=1);

namespace app\controllers;

use app\source\controller\AbstractController;
use Smarty\Smarty;

abstract class AbstractAppController extends AbstractController
{
    protected function createSmarty(): Smarty
    {
        $config = $this->app->getConfig();
        $smartyConfig = $config['components']['smarty'];
        $smarty = new Smarty();
        $smarty->setTemplateDir($smartyConfig['template_dir']);
        $smarty->setCompileDir($smartyConfig['compile_dir']);
        $smarty->setCacheDir($smartyConfig['cache_dir']);
        $smarty->assign('currentYear', (int)date('Y'));

        return $smarty;
    }

    protected function renderNotFound(): string
    {
        http_response_code(404);
        $smarty = $this->createSmarty();
        $smarty->assign('pageTitle', '404');
        return $smarty->fetch('errors/404.tpl');
    }
}

