<?php
declare(strict_types=1);

namespace app\models;

use app\source\attribute\model\FieldAttribute;
use app\source\model\AbstractModel;

class ArticleModel extends AbstractModel
{
    public string $table = 'article';

    #[FieldAttribute]
    public int $id;
    #[FieldAttribute]
    public string $image;
    #[FieldAttribute]
    public string $title;
    #[FieldAttribute]
    public string $description;
    #[FieldAttribute]
    public string $content;
    #[FieldAttribute]
    public int $views_count;
    #[FieldAttribute]
    public int $published_at;
    public ?string $category_names = null;
}

