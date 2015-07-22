<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Controller\Organization;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xidea\Component\Organization\Loader\OrganizationLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractShowController;
use Xidea\Component\Organization\Model\OrganizationInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ShowController extends AbstractShowController
{
    /*
     * @var OrganizationLoaderInterface
     */
    protected $loader;

    public function __construct(ConfigurationInterface $configuration, OrganizationLoaderInterface $loader)
    {
        parent::__construct($configuration);

        $this->loader = $loader;
        $this->showTemplate = 'organization_show';
    }

    protected function loadModel($id)
    {
        $organization = $this->loader->load($id);

        if (!$organization instanceof OrganizationInterface) {
            throw new NotFoundHttpException('organization.not_found');
        }

        return $organization;
    }

    protected function onPreShow($model, Request $request)
    {
        return;
    }
}
