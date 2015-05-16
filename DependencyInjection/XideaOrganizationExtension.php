<?php

namespace Xidea\Bundle\OrganizationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaOrganizationExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config, $loader) = $this->setUp($configs, new Configuration($this->getAlias()), $container);

        $loader->load('organization.yml');
        $loader->load('organization_orm.yml');
        $loader->load('organization_controller.yml');
        $loader->load('organization_form.yml');

        $this->loadOrganizationSection($config['organization'], $container, $loader);
    }
    
    protected function loadOrganizationSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_organization.organization.class', $config['class']);
        $container->setAlias('xidea_organization.organization.configuration', $config['configuration']);
        $container->setAlias('xidea_organization.organization.factory', $config['factory']);
        $container->setAlias('xidea_organization.organization.manager', $config['manager']);
        $container->setAlias('xidea_organization.organization.loader', $config['loader']);
        
        if (!empty($config['form'])) {
            $this->loadOrganizationFormSection($config['form'], $container, $loader);
        }
        
        if(isset($config['template'])) {
            $this->loadTemplateSection(sprintf('%s.%s', $this->getAlias(), 'organization'), $config['template'], $container, $loader);
        }
    }
    
    protected function loadOrganizationFormSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setAlias('xidea_organization.organization.form.create.factory', $config['create']['factory']);
        $container->setAlias('xidea_organization.organization.form.create.handler', $config['create']['handler']);
        
        $container->setParameter('xidea_organization.organization.form.create.type', $config['create']['type']);
        $container->setParameter('xidea_organization.organization.form.create.name', $config['create']['name']);
        $container->setParameter('xidea_organization.organization.form.create.validation_groups', $config['create']['validation_groups']);
    }
    
    protected function getConfigurationDirectory()
    {
        return __DIR__.'/../Resources/config';
    }
}