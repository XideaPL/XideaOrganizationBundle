<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Xidea\Bundle\BaseBundle\Form\Factory\FormFactoryInterface;
use Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\BaseBundle\Event\FormEvent;
use Xidea\Bundle\OrganizationBundle\OrganizationEvents;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class OrganizationFormHandler implements FormHandlerInterface
{
    /*
     * @var FormFactoryInterface
     */
    protected $formFactory;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /*
     * @var string
     */
    protected $requestMethod = 'POST';
    
    /**
     * Constructs a form handler.
     *
     * @param EngineInterface The engine
     */
    public function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRequestMethod($method)
    {
        $this->requestMethod = $method;
    }
    
    /**
     * {@inheritdoc}
     */
    public function createForm()
    {
        return $this->formFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function handle(FormInterface $form, Request $request)
    {
        if ($request->isMethod($this->requestMethod)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(OrganizationEvents::FORM_VALID, $event);
                
                return true;
            }
        }
        
        return false;
    }
}
