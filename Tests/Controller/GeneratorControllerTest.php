<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests\Controller;

use Hackzilla\Bundle\PasswordGeneratorBundle\Exception\UnknownGeneratorException;
use Hackzilla\Bundle\PasswordGeneratorBundle\Tests\TestKernel;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\DummyPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\HumanPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\HybridPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Twig\Environment;

class GeneratorControllerTest extends KernelTestCase
{
    private $_object;

    public function setup(): void
    {
        self::bootKernel();

        if (version_compare(TestKernel::VERSION, '5.0', '>=')) {
            $container = static::getContainer();
        } else {
            $container = static::$kernel->getContainer();
        }

        $this->_object = new \Hackzilla\Bundle\PasswordGeneratorBundle\Controller\GeneratorController(
            new HumanPasswordGenerator(),
            new HybridPasswordGenerator(),
            new ComputerPasswordGenerator(),
            new RequirementPasswordGenerator(),
            new DummyPasswordGenerator(),
            $container->get('form.factory'),
            $container->get('twig'),
        );
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

    public function testGetPasswordGeneratorException(): void
    {
        $container = $this->createMock(ContainerInterface::class);

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
    public function testGetMode($mode, $check): void
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
    public function testGetModeNull($mode, $check): void
    {
        $request = new \Symfony\Component\HttpFoundation\Request(['mode' => $mode]);

        $returnValue = $this->invokeMethod($this->_object, 'getMode', [$request, null]);

        $this->assertSame($check, $returnValue);
    }
}
