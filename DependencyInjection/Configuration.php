<?php

namespace Xidea\Bundle\OrganizationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public function __construct($alias)
    {
        parent::__construct($alias);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = parent::getConfigTreeBuilder();
        $rootNode = $treeBuilder->root($this->alias);
        
        $this->addOrganizationSection($rootNode);
        $this->addTemplateSection($rootNode);

        return $treeBuilder;
    }
    
    protected function addOrganizationSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('organization')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('code')->defaultValue('xidea_organization')->end()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_organization.organization.factory.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_organization.organization.manager.default')->end()
                        ->scalarNode('loader')->defaultValue('xidea_organization.organization.loader.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->arrayNode('organization')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('factory')->defaultValue('xidea_organization.organization.form.factory.default')->end()
                                        ->scalarNode('handler')->defaultValue('xidea_organization.organization.form.handler.default')->end()
                                        ->scalarNode('type')->defaultValue('xidea_organization')->end()
                                        ->scalarNode('name')->defaultValue('organization')->end()
                                        ->arrayNode('validation_groups')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(array())
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
