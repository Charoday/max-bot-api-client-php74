<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

use Charoday\MaxMessengerBot\Exceptions\SerializationException;
use ReflectionClass;
use ReflectionProperty;

/**
 * Base class for all models in the Max Bot API client.
 * Provides common functionality for serialization and deserialization.
 */
abstract class AbstractModel
{
    /**
     * Converts the model to an array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $array = [];
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($value !== null) {
                if (is_object($value) && method_exists($value, 'toArray')) {
                    $array[$property->getName()] = $value->toArray();
                } elseif (is_array($value)) {
                    $array[$property->getName()] = $this->castArray($property->getName(), $value);
                } else {
                    $array[$property->getName()] = $value;
                }
            }
        }
        return $array;
    }

    /**
     * Casts array values to appropriate types.
     * This is a simplified version for PHP 7.4 without attributes.
     *
     * @param string $propertyName
     * @param array $value
     * @return array
     */
    protected function castArray($propertyName, $value)
    {
        // This is a fallback implementation for PHP 7.4
        // In real usage, you might want to define mapping rules per class
        $result = [];
        foreach ($value as $item) {
            if (is_object($item) && method_exists($item, 'toArray')) {
                $result[] = $item->toArray();
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }
}
