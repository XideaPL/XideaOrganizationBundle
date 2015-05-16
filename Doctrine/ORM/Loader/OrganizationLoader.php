<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Doctrine\ORM\Loader;

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\EntityRepository;

use Xidea\Component\Organization\Loader\OrganizationLoaderInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class OrganizationLoader implements OrganizationLoaderInterface
{
    /*
     * @var EntityRepository
     */
    protected $organizationRepository;
    
    /**
     * Constructs a comment repository.
     *
     * @param string $class The class
     * @param EntityManager The entity manager
     */
    public function __construct(EntityRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load($id)
    {
        return $this->organizationRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function loadAll()
    {
        return $this->organizationRepository->findAll();
    }

    /*
     * {@inheritdoc}
     */
    public function loadBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null)
    {
        return $this->organizationRepository->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    /*
     * {@inheritdoc}
     */
    public function loadOneBy(array $criteria, array $orderBy = array())
    {
        return $this->organizationRepository->findOneBy($criteria, $orderBy);
    }
}
