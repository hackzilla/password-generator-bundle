<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Form\Type;

use Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type\OptionType;
use Hackzilla\PasswordGenerator\Model\Option\BooleanOption;
use Hackzilla\PasswordGenerator\Model\Option\IntegerOption;
use Hackzilla\PasswordGenerator\Model\Option\StringOption;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\Form\Test\TypeTestCase;

class OptionTypeTest extends TypeTestCase
{
    public function testAddBooleanType()
    {
        $option = new BooleanOption();
        $option->setValue(true);

        $type = new OptionType();

        $this->invokeMethod(
            $type,
            'addBooleanType',
            [
                $this->formBuilder(),
                'key',
                $option,
            ]
        );
    }

    public function testAddStringType()
    {
        $option = new StringOption();
        $option->setValue("test");

        $type = new OptionType();

        $this->invokeMethod(
            $type,
            'addStringType',
            [
                $this->formBuilder(),
                'key',
                $option,
            ]
        );
    }

    public function testAddIntegerType()
    {
        $option = new IntegerOption();
        $option->setValue(123);

        $type = new OptionType();

        $this->invokeMethod(
            $type,
            'addIntegerType',
            [
                $this->formBuilder(),
                'key',
                $option,
            ]
        );
    }

    private function formBuilder()
    {
        $dispatcher = new EventDispatcher();

        return new FormBuilder('test', null, $dispatcher, $this->factory);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
