<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Controller\Organization;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Xidea\Component\Base\Factory\ModelFactoryInterface;
use Xidea\Component\Organization\Manager\OrganizationManagerInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractCreateController,
    Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\OrganizationBundle\OrganizationEvents,
    Xidea\Bundle\OrganizationBundle\Event\GetOrganizationResponseEvent,
    Xidea\Bundle\OrganizationBundle\Event\FilterOrganizationResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class CreateController extends AbstractCreateController
{
    /*
     * @var ModelFactoryInterface
     */

    protected $organizationFactory;

    /*
     * @var OrganizationManagerInterface
     */
    protected $organizationManager;

    public function __construct(ConfigurationInterface $configuration, ModelFactoryInterface $organizationFactory, OrganizationManagerInterface $modelManager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration, $modelManager, $formHandler);

        $this->organizationFactory = $organizationFactory;
    }

    protected function createModel()
    {
        return $this->organizationFactory->create();
    }

    protected function onPreCreate($model, Request $request)
    {
        $this->dispatch(OrganizationEvents::PRE_CREATE, $event = new GetOrganizationResponseEvent($model, $request));

        return $event->getResponse();
    }

    protected function onCreateSuccess($model, Request $request)
    {
        $this->dispatch(OrganizationEvents::CREATE_SUCCESS, $event = new GetOrganizationResponseEvent($model, $request));

        if (null === $response = $event->getResponse()) {
            $response = $this->redirectToRoute('xidea_organization_show', array(
                'id' => $model->getId()
            ));
        }

        return $response;
    }

    protected function onCreateCompleted($model, Request $request, Response $response)
    {
        $this->dispatch(OrganizationEvents::CREATE_COMPLETED, new FilterOrganizationResponseEvent($model, $request, $response));
    }
}