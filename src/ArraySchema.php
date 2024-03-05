<?php

namespace Hexlet\Validator;

/**
 * Class ArraySchema
 *
 * @package Hexlet\Validator
 */
class ArraySchema extends Schema
{
    /**
     * Обязательно массив
     *
     * @return $this
     */
    public function required(): self
    {
        $this->validators['required'] = static function ($value) {
            return is_array($value);
        };

        return $this;
    }

    /**
     * Число элементов массива
     *
     * @param int $size
     *
     * @return $this
     */
    public function sizeof(int $size): self
    {
        $this->validators['sizeof'] = static function ($value) use ($size) {
            return count($value) === $size;
        };

        return $this;
    }

    /**
     * Массив определённой структуры
     *
     * @param array $schemas
     *
     * @return $this
     */
    public function structure(array $schemas): self
    {
        $this->validators['structure'] = static function ($value) use ($schemas) {
            foreach ($schemas as $key => $schema) {
                if (!$schema->isValid($value[$key])) {
                    return false;
                }
            }

            return true;
        };

        return $this;
    }
}
