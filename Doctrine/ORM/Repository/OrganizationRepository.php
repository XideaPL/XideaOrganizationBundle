<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class OrganizationRepository extends EntityRepository implements OrganizationRepositoryInterface
{
    public function findQb()
    {
        $qb = $this->createQueryBuilder('o');
        
        return $qb;
    }
}
