<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Entity;

class OptionsTest extends \PHPUnit_Framework_TestCase
{
    private $_object;

    public function setup()
    {
        $passwordGenerator = new \Hackzilla\PasswordGenerator\Generator\DummyPasswordGenerator();
        $this->_object = new \Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options($passwordGenerator);
    }

    public function quantityProvider()
    {
        return array(
            array(1, 1),
            array(10, 10),
            array(100, 100),
            array('', 0),
            array('test', 0),
        );
    }

    /**
     * @dataProvider quantityProvider
     * @param mixed $quantity
     * @param integer $check
     */
    public function testQuantity($quantity, $check)
    {
        $this->_object->setQuantity($quantity);

        $this->assertEquals($check, $this->_object->getQuantity());
    }

    public function optionProvider()
    {
        return array(
            array('LENGTH', 1),
            array('LenGTh', 10),
            array('length', 100),
        );
    }

    /**
     * @dataProvider optionProvider
     * @param string $key
     * @param mixed $value
     */
    public function testOption($key, $value)
    {
        $this->_object->{$key} = $value;

        $this->assertEquals($value, $this->_object->{$key});
    }

    public function testOptionFailure()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->_object->{'non_existent'};
    }
}
 