<?php

namespace Hexlet\Validator;

/**
 * Class Validator
 *
 * @package Hexlet\Validator
 */
class Validator
{
    /**
     * @var array
     */
    private $customValidators = [];

    /**
     * @return ArraySchema
     */
    public function array(): ArraySchema
    {
        return new ArraySchema($this->getCustomValidators('array'));
    }

    /**
     * @return NumberSchema
     */
    public function number(): NumberSchema
    {
        return new NumberSchema($this->getCustomValidators('number'));
    }

    /**
     * @return StringSchema
     */
    public function string(): StringSchema
    {
        return new StringSchema($this->getCustomValidators('string'));
    }

    /**
     * Добавить кастомный валидатор
     *
     * @param string $type
     * @param string $name
     * @param callable $fn
     *
     * @return $this
     */
    public function addValidator(string $type, string $name, callable $fn): self
    {
        $this->customValidators[$type][$name] = $fn;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private function getCustomValidators(string $type): array
    {
        return $this->customValidators[$type] ?? [];
    }
}
