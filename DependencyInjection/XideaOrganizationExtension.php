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
        $loader->load('controller.yml');
        $loader->load('form.yml');

        $this->loadOrganizationSection($config['organization'], $container, $loader);
        
        $this->loadTemplateSection($config, $container, $loader);
    }
    
    protected function loadOrganizationSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_organization.organization.code', $config['code']);
        $container->setParameter('xidea_organization.organization.class', $config['class']);
        $container->setAlias('xidea_organization.organization.configuration', $config['configuration']);
        $container->setAlias('xidea_organization.organization.factory', $config['factory']);
        $container->setAlias('xidea_organization.organization.manager', $config['manager']);
        $container->setAlias('xidea_organization.organization.loader', $config['loader']);
        
        if (!empty($config['form'])) {
            $this->loadOrganizationFormSection($config['form'], $container, $loader);
        }
    }
    
    protected function loadOrganizationFormSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setAlias('xidea_organization.organization.form.factory', $config['organization']['factory']);
        $container->setAlias('xidea_organization.organization.form.handler', $config['organization']['handler']);
        
        $container->setParameter('xidea_organization.organization.form.type', $config['organization']['type']);
        $container->setParameter('xidea_organization.organization.form.name', $config['organization']['name']);
        $container->setParameter('xidea_organization.organization.form.validation_groups', $config['organization']['validation_groups']);
    }
    
    protected function getConfigurationDirectory()
    {
        return __DIR__.'/../Resources/config';
    }
    
    protected function getDefaultTemplates()
    {
        return [
            'organization_main' => ['path' => '@XideaOrganization/main'],
            'organization_list' => ['path' => '@XideaOrganization/Organization/List/list'],
            'organization_show' => ['path' => '@XideaOrganization/Organization/Show/show'],
            'organization_create' => ['path' => '@XideaOrganization/Organization/Create/create'],
            'organization_form' => ['path' => '@XideaOrganization/Organization/Form/form'],
            'organization_form_fields' => ['path' => '@XideaOrganization/Organization/Form/fields']
        ];
    }
}