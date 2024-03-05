<?php

namespace Php\Validator;

/**
 * Class Schema
 * @package Php\Validator
 */
abstract class Schema
{
    /**
     * @var array
     */
    protected $validators = [];
    /**
     * @var array
     */
    protected $customValidators = [];

    /**
     * Schema constructor.
     *
     * @param array $customValidators
     */
    public function __construct(array $customValidators)
    {
        $this->customValidators = $customValidators;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $name
     * @param ...$args
     *
     * @return $this
     */
    public function test(string $name, ...$args): self
    {
        $this->validators[$name] = function ($value) use ($name, $args) {
            $validator = $this->customValidators[$name];

            return $validator($value, ...$args);
        };

        return $this;
    }
}
