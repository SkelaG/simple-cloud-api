<?php

namespace App\Dto;

use ReflectionClass;

abstract class Dto
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($this);
            $property->setAccessible(false);
        }
        return $array;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
