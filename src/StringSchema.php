<?php

namespace Php\Validator;

/**
 * Class StringSchema
 *
 * @package Php\Validator
 */
class StringSchema extends Schema
{
    /**
     * Требуется непустая строка
     *
     * @return $this
     */
    public function required(): self
    {
        $this->validators['required'] = static function ($value) {
            return is_string($value) && $value !== '';
        };

        return $this;
    }

    /**
     * Содержится ли подстрока в строке
     *
     * @param $substring
     *
     * @return $this
     */
    public function contains($substring): self
    {
        $this->validators['contains'] = static function ($value) use ($substring) {
            return mb_strpos($value, $substring) !== false;
        };

        return $this;
    }

    /**
     * Строка равна или больше минимального количества символов
     *
     * @param int $minLength
     *
     * @return $this
     */
    public function minLength(int $minLength): self
    {
        $this->validators['minLength'] = static function ($value) use ($minLength) {
            return mb_strlen($value) >= $minLength;
        };

        return $this;
    }
}
