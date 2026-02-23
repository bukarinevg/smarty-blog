<?php
declare(strict_types=1);

namespace app\controllers;

use app\repositories\CategoryRepository;
use app\source\attribute\http\RouteAttribute;

class IndexController extends AbstractAppController
{
    #[RouteAttribute('GET')]
    public function actionIndex(): string
    {
        $repository = new CategoryRepository($this->getPdo());
        $categories = $repository->findCategoriesWithLatestArticles(3);

        $smarty = $this->createSmarty();
        $smarty->assign('pageTitle', 'Блог');
        $smarty->assign('categories', $categories);

        return $smarty->fetch('home.tpl');
    }
}

