<?php

declare(strict_types=1);

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Entity;

class OptionsTest extends \PHPUnit\Framework\TestCase
{
    private $_object;

    public function setup(): void
    {
        $passwordGenerator = new \Hackzilla\PasswordGenerator\Generator\DummyPasswordGenerator();
        $this->_object = new \Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options($passwordGenerator);
    }

    public function quantityProvider()
    {
        return [
            [1, 1],
            [10, 10],
            [100, 100],
            ['', 0],
            ['test', 0],
        ];
    }

    /**
     * @dataProvider quantityProvider
     *
     * @param mixed $quantity
     * @param int   $check
     */
    public function testQuantity($quantity, $check): void
    {
        $this->_object->setQuantity($quantity);

        $this->assertSame($check, $this->_object->getQuantity());
    }

    public function optionProvider()
    {
        return [
            ['LENGTH', 1],
            ['LenGTh', 10],
            ['length', 100],
        ];
    }

    /**
     * @dataProvider optionProvider
     *
     * @param string $key
     * @param mixed  $value
     */
    public function testOption($key, $value): void
    {
        $this->_object->{$key} = $value;

        $this->assertSame($value, $this->_object->{$key});
    }

    public function testOptionFailure(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->_object->{'non_existent'};
    }
}
