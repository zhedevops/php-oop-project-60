<?php

namespace Php\Validator\Tests;

/**
 * Trait Test
 */
trait Test
{
    /**
     * Строка начинается со значения
     *
     * @param $value
     * @param $start
     * @return bool
     */
    public function stringBeginsWith($value, $start): bool
    {
        return mb_strpos($value, $start) === 0;
    }
}
