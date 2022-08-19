<?php

declare(strict_types=1);

/*
 * Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)
 * https://stackoverflow.com/a/71775404/157656
 */

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Tests;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PublicService implements CompilerPassInterface
{
    private const SERVICES = [
        'form.factory',
        'serializer',
        'twig',
    ];

    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            $this->checkForService($id, $definition);
        }
        foreach ($container->getAliases() as $id => $definition) {
            $this->checkForService($id, $definition);
        }
    }

    private function checkForService(string $id, $definition)
    {
        foreach (self::SERVICES as $service) {
            if (stripos($id, $service) === 0) {
                $definition->setPublic(true);
            }
        }
    }
}
