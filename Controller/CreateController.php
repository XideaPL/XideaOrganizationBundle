<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Xidea\Base\Model\FactoryInterface as ModelFactoryInterface;
use Xidea\Organization\ManagerInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractController,
    Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\OrganizationBundle\OrganizationEvents,
    Xidea\Bundle\OrganizationBundle\Event\GetResponseEvent,
    Xidea\Bundle\OrganizationBundle\Event\FilterResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class CreateController extends AbstractController
{
    /*
     * @var ModelFactoryInterface
     */
    protected $factory;
    
    /*
     * @var ManagerInterface
     */
    protected $manager;

    /*
     * @var ProductFormHandlerInterface
     */
    protected $formHandler;

    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param DirectorInterface $factory
     * @param ManagerInterface $manager
     * @param FormHandlerInterface $formHandler
     */
    public function __construct(ConfigurationInterface $configuration, ModelFactoryInterface $factory, ManagerInterface $manager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration);

        $this->factory = $factory;
        $this->manager = $manager;
        $this->formHandler = $formHandler;
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $model = $this->factory->create();

        $event = $this->dispatch(OrganizationEvents::PRE_CREATE, $event = new GetResponseEvent($model, $request));
        if ($event->getResponse() !== null) {
            return $event->getResponse();
        }

        $form = $this->createForm($model);
        if ($this->formHandler->handle($form, $request)) {
            if ($this->manager->save($model)) {
                $event = $this->dispatch(OrganizationEvents::CREATE_SUCCESS, $event = new GetResponseEvent($model, $request));

                if (null === $response = $event->getResponse()) {
                    $response = $this->redirectToRoute('xidea_organization_show', array(
                        'id' => $model->getId()
                    ));
                }

                $event = $this->dispatch(OrganizationEvents::CREATE_COMPLETED, $event = new FilterResponseEvent($model, $request, $response));
                
                return $event->getResponse();
            }
        }

        return $this->render('organization_create', array(
            'form' => $form->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function createFormAction(Request $request)
    {
        $form = $this->createForm();

        return $this->render('organization_form', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * 
     * @param mixed $model
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createForm($model = null)
    {
        $form = $this->formHandler->createForm();
        if (null !== $model) {
            $form->setData($model);
        }

        return $form;
    }
}
