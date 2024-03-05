<?php

namespace Php\Validator;

/**
 * Class NumberSchema
 *
 * @package Php\Validator
 */
class NumberSchema extends Schema
{
    /**
     * Обязательное целое число, включая ноль
     *
     * @return $this
     */
    public function required(): self
    {
        $this->validators['required'] = static function ($value) {
            return is_numeric($value);
        };

        return $this;
    }

    /**
     * Положительное число
     *
     * @return $this
     */
    public function positive(): self
    {
        $this->validators['positive'] = static function ($value) {
            return $value === null || $value > 0;
        };

        return $this;
    }

    /**
     * Число в диапазоне
     *
     * @param int $min
     * @param int $max
     *
     * @return $this
     */
    public function range(int $min, int $max): self
    {
        $this->validators['range'] = static function ($value) use ($min, $max) {
            return ($min <= $value) && ($value <= $max);
        };

        return $this;
    }
}
