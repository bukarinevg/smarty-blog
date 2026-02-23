<?php
declare(strict_types=1);

namespace app\source\attribute;


class AttributeHelper
{
    /**
     * @throws \ReflectionException
     */
    static function getFieldsWithAttribute(string $class, string $attribute): array
    {
        $reflector = new \ReflectionClass($class);
        $properties = $reflector->getProperties();
        $fields = [];

        foreach ($properties as $property) {
            $reflector = new \ReflectionProperty($class, $property->getName());
            $attributes = $reflector->getAttributes();

            foreach ($attributes as $propertyAttribute) {
                if ($propertyAttribute->getName() == $attribute) {
                    $fields[] = $property->getName();
                }
            };
        }
        // print_r($fields);  
        return $fields;
    }
}

