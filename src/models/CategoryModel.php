<?php
declare(strict_types=1);

namespace app\models;

use app\source\attribute\model\FieldAttribute;
use app\source\model\AbstractModel;

class CategoryModel extends AbstractModel
{
    public string $table = 'category';

    #[FieldAttribute]
    public string $name;
    #[FieldAttribute]
    public string $description;
}

