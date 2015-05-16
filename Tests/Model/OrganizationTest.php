<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Tests\Model;

use Xidea\Bundle\OrganizationBundle\Tests\Fixtures\Model\Organization;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class OrganizationtTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $organization = $this->createOrganization();
        $this->assertNull($organization->getName());
        
        $name = 'Organization 1';
        
        $organization->setName($name);
        $this->assertEquals($name, $organization->getName());
    }
    
    protected function createOrganization()
    {
        return new Organization();
    }
}
