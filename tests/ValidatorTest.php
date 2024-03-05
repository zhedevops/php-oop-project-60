<?php

namespace Php\Validator\Tests;

use Php\Validator\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 *
 * @package Php\Validator\Tests
 */
class ValidatorTest extends TestCase
{
    use Test;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * setUp Validator
     */
    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    /**
     * Тест строк
     */
    public function testString(): void
    {
        $schema = $this->validator->stringValidator();

        $this->assertTrue($schema->isValid(''));

        $schema->required();
        $this->assertTrue($schema->isValid('No description, website, or topics provided.'));
        $this->assertTrue($schema->isValid('oop'));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));

        $schema->minLength(5);

        $this->assertTrue($schema->isValid('No description, website, or topics provided.'));
        $this->assertFalse($schema->isValid('oop'));

        $this->assertTrue($schema->contains('website')->isValid('No description, website, or topics provided.'));
        $this->assertFalse($schema->contains('oop')->isValid('No description, website, or topics provided.'));
    }

    /**
     * Тест чисел
     */
    public function testNumbers(): void
    {
        $schema = $this->validator->numberValidator();

        $this->assertEquals(true, $schema->isValid(null));

        $schema->required();

        $this->assertEquals(false, $schema->isValid(null));
        $this->assertEquals(true, $schema->isValid(7));

        $schema->range(-1, 1);

        $this->assertEquals(false, $schema->isValid(-2));
        $this->assertEquals(true, $schema->isValid(-1));

        $schema->positive();

        $this->assertEquals(false, $schema->isValid(-1));
        $this->assertEquals(true, $schema->isValid(1));
        $this->assertEquals(false, $schema->isValid(0));
    }

    /**
     * Тест массивов
     */
    public function testArray(): void
    {
        $schema = $this->validator->arrayValidator();

        $this->assertEquals(true, $schema->isValid(null));

        $schema = $schema->required();

        $this->assertEquals(true, $schema->isValid([]));
        $this->assertEquals(true, $schema->isValid(['oop', 'php']));

        $schema->sizeof(3);

        $this->assertEquals(false, $schema->isValid(['oop']));
        $this->assertEquals(true, $schema->isValid(['oop', 'php', 'study']));
    }

    /**
     * Тест структуры массивов
     */
    public function testStructure(): void
    {
        $schema = $this->validator->arrayValidator();

        $schema->structure([
            'name' => $this->validator->stringValidator()->required(),
            'age' => $this->validator->numberValidator()->positive()
        ]);

        $this->assertEquals(true, $schema->isValid(['name' => 'Sasha', 'age' => 5]));
        $this->assertEquals(true, $schema->isValid(['name' => 'Vova', 'age' => null]));
        $this->assertEquals(false, $schema->isValid(['name' => '', 'age' => null]));
        $this->assertEquals(false, $schema->isValid(['name' => 'Lena', 'age' => -5]));
    }

    /**
     * Тест добавления валидатора
     */
    public function testAddValidator(): void
    {
        $fn = function ($value, $start) {
            return $this->stringBeginsWith($value, $start);
        };

        $this->validator->addValidator('string', 'startWith', $fn);

        $schema = $this->validator->stringValidator()->test('startWith', 'O');
        $this->assertEquals(false, $schema->isValid('Php oop is best practice'));
        $this->assertEquals(true, $schema->isValid('Oops..'));

        $fn = static function ($value, $min) {
            return $value >= $min;
        };
        $this->validator->addValidator('number', 'min', $fn);

        $schema = $this->validator->numberValidator()->test('min', 10);
        $this->assertEquals(false, $schema->isValid(9));
        $this->assertEquals(true, $schema->isValid(11));
    }
}
