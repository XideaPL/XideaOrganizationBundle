<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xidea\Organization\LoaderInterface;
use Xidea\Base\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractController;
use Xidea\Organization\OrganizationInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ShowController extends AbstractController
{
    /*
     * @var LoaderInterface
     */
    protected $loader;
    
    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param LoaderInterface $loader
     */
    public function __construct(ConfigurationInterface $configuration, LoaderInterface $loader)
    {
        parent::__construct($configuration);

        $this->loader = $loader;
    }
    
    /**
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function showAction($id, Request $request)
    {
        $model = $this->loadModel($id);
        
        return $this->render('organization_show', array(
            'model' => $model
        ));
    }

    /**
     * @param int $id
     * 
     * @return OrganizationInterface|null
     */
    protected function loadModel($id)
    {
        $organization = $this->loader->load($id);

        if (!$organization instanceof OrganizationInterface) {
            throw new NotFoundHttpException('organization.not_found');
        }

        return $organization;
    }
}
