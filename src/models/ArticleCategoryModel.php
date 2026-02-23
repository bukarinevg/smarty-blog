<?php
declare(strict_types=1);

namespace app\models;

use app\source\attribute\model\FieldAttribute;
use app\source\model\AbstractModel;

class ArticleCategoryModel extends AbstractModel
{
    public string $table = 'article_category';

    #[FieldAttribute]
    public int $article_id;

    #[FieldAttribute]
    public int $category_id;
}

