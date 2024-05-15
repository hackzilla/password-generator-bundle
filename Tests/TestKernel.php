<?php

declare(strict_types=1);

/*
 * This file is part of HackzillaPasswordGeneratorBundle package.
 *
 * (c) Daniel Platt <github@ofdan.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollectionBuilder;

if (\Symfony\Component\HttpKernel\Kernel::MAJOR_VERSION >= 5) {
    trait ConfigureRoutes
    {
        protected function configureRoutes(RoutingConfigurator $routes): void
        {
            $routes->import(__DIR__.'/routes.yaml', 'yaml');
        }
    }

    trait KernelDirectories
    {
        public function getCacheDir(): string
        {
            return $this->getBaseDir().'cache';
        }

        /**
         * {@inheritdoc}
         */
        public function getLogDir(): string
        {
            return $this->getBaseDir().'log';
        }
    }
} else {
    trait ConfigureRoutes
    {
        /**
         * {@inheritdoc}
         */
        protected function configureRoutes(RouteCollectionBuilder $routes)
        {
            $routes->import(__DIR__.'/routes.yaml', '/', 'yaml');
        }
    }

    trait KernelDirectories
    {
        public function getCacheDir()
        {
            return $this->getBaseDir().'cache';
        }

        /**
         * {@inheritdoc}
         */
        public function getLogDir()
        {
            return $this->getBaseDir().'log';
        }
    }
}

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 * @author Daniel Platt <github@ofdan.co.uk>
 */
final class TestKernel extends Kernel
{
    use ConfigureRoutes, KernelDirectories, MicroKernelTrait {
        ConfigureRoutes::configureRoutes insteadof MicroKernelTrait;
        KernelDirectories::getCacheDir insteadof MicroKernelTrait;
        KernelDirectories::getLogDir insteadof MicroKernelTrait;
    }

    public function __construct()
    {
        parent::__construct('test', true);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles(): array
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
        ];
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new PublicService(), PassConfig::TYPE_OPTIMIZE);
        parent::build($container);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        // FrameworkBundle config
        $frameworkConfig = [
            'secret' => 'MySecretKey',
            'default_locale' => 'en',
            'form' => null,
            'test' => true,
        ];

        if (version_compare(self::VERSION, '5.1', '>=') && version_compare(self::VERSION, '6.0', '<')) {
            $frameworkConfig['router'] = ['utf8' => true];
        }

        $c->loadFromExtension('framework', $frameworkConfig);

        // TwigBundle config
        $twigConfig = [
            'strict_variables' => '%kernel.debug%',
            'exception_controller' => null,
        ];
        // "default_path" configuration is available since version 3.4.
        if (version_compare(self::VERSION, '3.4', '>=')) {
            $twigConfig['default_path'] = __DIR__.'/Resources/views';
        }
        $c->loadFromExtension('twig', $twigConfig);
    }

    private function getBaseDir()
    {
        return sys_get_temp_dir().'/hackzilla-password-generator-bundle/var/';
    }
}
