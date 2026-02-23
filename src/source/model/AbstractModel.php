<?php
declare(strict_types=1);

namespace app\source\model;

use app\source\attribute\AttributeHelper;
use app\source\attribute\model\FieldAttribute;
use app\source\attribute\model\TypeAttribute;

/**
 * This is an abstract class that serves as the base for all models.
 */
abstract class AbstractModel
{
    #[FieldAttribute]
    #[TypeAttribute(type: 'integer')]
    public int|null $created_at;

    #[FieldAttribute]
    #[TypeAttribute(type: 'integer')]
    public int|null $updated_at;

    public array $fields = [];

    /**
     * The fields for model.
     */
    public array $data = [];


    /**
     * Class AbstractModel
     *
     * This class represents an abstract model.
     */
    public function __construct()
    {
        $this->fields = AttributeHelper::getFieldsWithAttribute($this::class, FieldAttribute::class);
    }

    /**
     * Convert the model object to a JSON string.
     *
     * @return string The JSON string.
     */
    public function toJson(array $attributes = []): string
    {
        $data = $this->getDataFromModel($attributes);
        return json_encode($data);
    }

    /**
     * Convert the model object to an array.
     *
     * @return array The array.
     */
    public function toArray(array $attributes = []): array
    {
        $data = $this->getDataFromModel($attributes);
        return $data;
    }

    private function getDataFromModel(array $attributes = []): array
    {

        $data = [];
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $data[$attribute] = $this->{$attribute};
            }
        } else {
            foreach ($this->fields as $property) {
                $data[$property] = $this->{$property};
            }
        }
        if (isset($data['created_at'])) {
            $data['created_at'] = date('H:i:s d-m-Y', $data['created_at']);
        }
        if (isset($data['updated_at'])) {
            $data['updated_at'] = date('H:i:s d-m-Y', $data['updated_at']);
        }
        return $data;
    }
}


