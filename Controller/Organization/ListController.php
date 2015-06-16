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
    protected $organizationLoader;

    public function __construct(ConfigurationInterface $configuration, OrganizationLoaderInterface $organizationLoader)
    {
        parent::__construct($configuration);
        
        $this->organizationLoader = $organizationLoader;
        $this->listTemplate = 'organization_list';
    }
    
    protected function loadModels(Request $request)
    {
        return $this->organizationLoader->loadAll();
    }
    
    protected function onPreList($models, Request $request)
    {
        return;
    }
}
