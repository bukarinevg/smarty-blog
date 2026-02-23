<?php
declare(strict_types=1);

namespace app\controllers;

use app\repositories\CategoryRepository;
use app\source\attribute\http\RouteAttribute;

class CategoryController extends AbstractAppController
{
    #[RouteAttribute(method: 'GET', param: 'int')]
    public function actionShow(string $id): string
    {
        $id = (int)$id;
        $repository = new CategoryRepository($this->getPdo());
        $category = $repository->findById($id);

        if ($category === null) {
            return $this->renderNotFound();
        }

        $sort = $this->app->getRequest()->getUrlParam('sort');
        $sort = in_array($sort, ['date', 'views']) ? $sort : 'date';

        $perPage = 12;
        $page = $this->app->getRequest()->getUrlParam('page');
        $page = empty($page) || !(is_numeric($page)) ? 1 : (int)$page;
        $articles = $repository->findArticlesByCategory($id, $sort, $page, $perPage);
        $totalPages = ceil($repository->countArticlesByCategory($id) / $perPage);

        $smarty = $this->createSmarty();
        $smarty->assign('pageTitle', $category['name']);
        $smarty->assign('category', $category);
        $smarty->assign('articles', $articles);
        $smarty->assign('sort', $sort);
        $smarty->assign('page', $page);
        $smarty->assign('totalPages', $totalPages);

        return $smarty->fetch('category.tpl');
    }
}

