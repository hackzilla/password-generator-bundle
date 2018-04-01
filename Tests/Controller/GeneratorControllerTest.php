<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Controller;

use Hackzilla\Bundle\PasswordGeneratorBundle\Exception\UnknownGeneratorException;

class GeneratorControllerTest extends \PHPUnit\Framework\TestCase
{
    private $_object;

    public function setup()
    {
        $this->_object = new \Hackzilla\Bundle\PasswordGeneratorBundle\Controller\GeneratorController();
    }

    public function serviceProvider()
    {
        return [
            ['dummy', 'hackzilla.password_generator.dummy'],
            ['computer', 'hackzilla.password_generator.computer'],
            ['human', 'hackzilla.password_generator.human'],
            ['hybrid', 'hackzilla.password_generator.hybrid'],
        ];
    }

    /**
     * @dataProvider serviceProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetPasswordGenerator($mode, $check)
    {
        $container = $this->createMock('\Symfony\Component\DependencyInjection\ContainerInterface');

        $container
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($service) {
                        return $service;
                    }
                )
            );

        $this->_object->setContainer($container);
        $returnValue = $this->invokeMethod($this->_object, 'getPasswordGenerator', [$mode]);

        $this->assertSame($check, $returnValue);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method
     *
     * @return mixed Method return
     */
    private function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testGetPasswordGeneratorException()
    {
        $container = $this->createMock('\Symfony\Component\DependencyInjection\ContainerInterface');

        $container
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($service) {
                        return $service;
                    }
                )
            );

        $this->_object->setContainer($container);

        $this->expectException(UnknownGeneratorException::class);
        $this->invokeMethod($this->_object, 'getPasswordGenerator', ['non-existent']);
    }

    public function modeProvider()
    {
        return [
            ['dummy', 'dummy'],
            ['computer', 'computer'],
            ['human', 'human'],
            ['hybrid', 'hybrid'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider modeProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetMode($mode, $check)
    {
        $request = new \Symfony\Component\HttpFoundation\Request(['mode' => $mode]);
        $returnValue = $this->invokeMethod($this->_object, 'getMode', [$request, $mode]);

        $this->assertSame($check, $returnValue);
    }

    public function nullModeProvider()
    {
        return [
            ['dummy', 'dummy'],
            ['computer', 'computer'],
            ['human', 'human'],
            ['hybrid', 'hybrid'],
            ['', 'computer'],
        ];
    }

    /**
     * @dataProvider nullModeProvider
     *
     * @param string $mode
     * @param string $check
     */
    public function testGetModeNull($mode, $check)
    {
        $request = new \Symfony\Component\HttpFoundation\Request(['mode' => $mode]);

        $returnValue = $this->invokeMethod($this->_object, 'getMode', [$request, null]);

        $this->assertSame($check, $returnValue);
    }

    /**
     * Copied from PHPUnit_Framework_TestCase for BC with phpunit < 5.4.0
     *
     * {@inheritdoc}
     */
    protected function createMock($originalClassName)
    {
        $builder = $this->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning();

        // For BC purpose. PHPUnit_Framework_MockObject_MockBuilder::disallowMockingUnknownTypes available since Release 3.2.0
        if (true === method_exists($builder, 'disallowMockingUnknownTypes')) {
            $builder->disallowMockingUnknownTypes();
        }

        return $builder->getMock();
    }
}
