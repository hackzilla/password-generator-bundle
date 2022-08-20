<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hackzilla_password_generator');

        if (!method_exists($treeBuilder, 'getRootNode')) {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder->root('hackzilla_password_generator');
        }

        return $treeBuilder;
    }
}
