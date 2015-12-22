<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Controller;

class GeneratorControllerTest extends \PHPUnit_Framework_TestCase
{
    private $_object;

    public function setup()
    {
        $this->_object = new \Hackzilla\Bundle\PasswordGeneratorBundle\Controller\GeneratorController();
    }

    public function serviceProvider()
    {
        return array(
            array('dummy', 'hackzilla.password_generator.dummy'),
            array('computer', 'hackzilla.password_generator.computer'),
            array('human', 'hackzilla.password_generator.human'),
            array('hybrid', 'hackzilla.password_generator.hybrid'),
        );
    }

    /**
     * @dataProvider serviceProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetPasswordGenerator($mode, $check)
    {
        $container = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');

        $container
            ->method('get')
            ->will($this->returnCallback(function ($service) {
                return $service;
            }));

        $this->_object->setContainer($container);
        $returnValue = $this->invokeMethod($this->_object, 'getPasswordGenerator', array($mode));

        $this->assertSame($check, $returnValue);
    }

    public function testGetPasswordGeneratorException()
    {
        $container = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');

        $container
            ->method('get')
            ->will($this->returnCallback(function ($service) {
                return $service;
            }));

        $this->_object->setContainer($container);

        $this->setExpectedException('Hackzilla\Bundle\PasswordGeneratorBundle\Exception\UnknownGeneratorException');
        $this->invokeMethod($this->_object, 'getPasswordGenerator', array('non-existent'));
    }

    public function modeProvider()
    {
        return array(
            array('dummy', 'dummy'),
            array('computer', 'computer'),
            array('human', 'human'),
            array('hybrid', 'hybrid'),
            array('', ''),
        );
    }

    /**
     * @dataProvider modeProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetMode($mode, $check)
    {
        $request = new \Symfony\Component\HttpFoundation\Request(array('mode' => $mode));
        $returnValue = $this->invokeMethod($this->_object, 'getMode', array($request, $mode));

        $this->assertSame($check, $returnValue);
    }

    public function nullModeProvider()
    {
        return array(
            array('dummy', 'dummy'),
            array('computer', 'computer'),
            array('human', 'human'),
            array('hybrid', 'hybrid'),
            array('', 'computer'),
        );
    }

    /**
     * @dataProvider nullModeProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetModeNull($mode, $check)
    {
        $request = new \Symfony\Component\HttpFoundation\Request(array('mode' => $mode));

        $returnValue = $this->invokeMethod($this->_object, 'getMode', array($request, null));

        $this->assertSame($check, $returnValue);
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
