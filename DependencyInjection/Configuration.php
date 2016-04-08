<?php

namespace Xidea\Bundle\OrganizationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Xidea\Bundle\BaseBundle\DependencyInjection\Helper\ConfigurationHelper;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /*
     * @var string
     */
    protected $alias;
    
    public function __construct($alias)
    {
        $this->alias = $alias;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->getAlias());
        
        $this->addOrganizationSection($rootNode);
        
        $helper = new ConfigurationHelper($this->getAlias());
        $helper->addTemplateSection($rootNode);
        
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
                                        ->scalarNode('type')->defaultValue('Xidea\Bundle\OrganizationBundle\Form\Type\OrganizationType')->end()
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
