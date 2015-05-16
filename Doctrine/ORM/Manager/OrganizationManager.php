<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Doctrine\ORM\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Xidea\Component\Base\Doctrine\ORM\Manager\ModelManagerInterface;
use Xidea\Component\Organization\Manager\OrganizationManagerInterface,
    Xidea\Component\Organization\Model\OrganizationInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class OrganizationManager implements ModelManagerInterface, OrganizationManagerInterface
{
    /*
     * @var bool
     */
    protected $flushMode;
    
    /*
     * @var EntityManager
     */
    protected $entityManager;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructs a organization manager.
     *
     * @param EntityManager The entity manager
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        
        $this->setFlushMode(true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFlushMode($flushMode = true)
    {
        $this->flushMode = $flushMode;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isFlushMode()
    {
        return $this->flushMode;
    }

    /**
     * {@inheritdoc}
     */
    public function save(OrganizationInterface $organization)
    {
        $this->entityManager->persist($organization);

        if($this->isFlushMode())
            $this->entityManager->flush();

        return $organization->getId();
    }
    
    public function update(OrganizationInterface $organization)
    {  
        $this->entityManager->persist($organization);

        if($this->isFlushMode())
            $this->entityManager->flush();

        return $organization->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OrganizationInterface $organization)
    {
        $this->entityManager->remove($organization);
    }
    
    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->entityManager->clear();
    }
}
