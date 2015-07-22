<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Controller\Organization;

use Symfony\Component\HttpFoundation\Request;
use Xidea\Component\Organization\Loader\OrganizationLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractListController;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ListController extends AbstractListController
{
    /*
     * @var OrganizationLoaderInterface
     */
    protected $loader;

    public function __construct(ConfigurationInterface $configuration, OrganizationLoaderInterface $loader)
    {
        parent::__construct($configuration);
        
        $this->loader = $loader;
        $this->listTemplate = 'organization_list';
    }
    
    protected function loadModels(Request $request)
    {
        return $this->loader->loadByPage(
            $request->query->get($this->configuration->getPaginationParameterName(), 1),
            $this->configuration->getPaginationLimit()
        );
    }
    
    protected function onPreList($models, Request $request)
    {
        return;
    }
}
