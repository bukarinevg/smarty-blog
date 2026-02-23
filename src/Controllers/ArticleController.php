<?php
declare(strict_types=1);

namespace app\controllers;

use app\repositories\ArticleRepository;
use app\source\attribute\http\RouteAttribute;

class ArticleController extends AbstractAppController
{
    #[RouteAttribute(method: 'GET', param: 'int')]
    public function actionShow(string $id): string
    {
        $id = (int)$id;
        $repository = new ArticleRepository($this->getPdo());
        $article = $repository->findById($id);

        if ($article === null) {
            return $this->renderNotFound();
        }
        $repository->incrementViews($id);;
        $similarArticles = $repository->findSimilarArticles($id, 3);

        $smarty = $this->createSmarty();
        $smarty->assign('pageTitle', $article['title']);
        $smarty->assign('article', [
            'id' => $id,
            'title' => $article['title'],
            'description' => $article['description'],
            'content' => $article['content'],
            'image' => $article['image'],
            'views_count' => $article['views_count'],
            'published_at' => $article['published_at'],
            'category_names' => $article['category_names'],
        ]);
        $smarty->assign('similarArticles', $similarArticles);

        return $smarty->fetch('article.tpl');
    }
}

