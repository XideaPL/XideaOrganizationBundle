<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class LoadOrganizationData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $this->loadData();

        $organizationManager = $this->container->get('xidea_organization.organization.manager');
        
        foreach($data as $organization) {
            $organizationManager->save($organization);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
    
    /**
     * Returns a organization factory.
     * 
     * @return \Xidea\Bundle\OrganizationBundle\Model\OrganizationFactory The organization factory
     */
    protected function getOrganizationFactory()
    {
        return $this->container->get('xidea_organization.organization.factory');
    }
    
    /**
     * Returns a data.
     * 
     * @return array The data
     */
    protected function loadData()
    {
        $organizationFactory = $this->getOrganizationFactory();
        
        $organization1 = $organizationFactory->create();
        $organization1->setName('Acme');
        $this->setReference('organization-acme', $organization1);
        
        $organization2 = $organizationFactory->create();
        $organization2->setName('Shield');
        $this->setReference('organization-shield', $organization2);
        
        return array(
            $organization1,
            $organization2
        );
    }
 
}
