<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\OrganizationBundle\Tests\Controller\Organization;

use Xidea\Bundle\OrganizationBundle\Tests\Controller\ControllerTestCase;

class ShowControllerTest extends ControllerTestCase
{
    public function testShowAction()
    {
        //$client = $this->logIn();
        $client = $this->createClient();
        $organization = $client->getContainer()->get('xidea_organization.organization.loader')->loadOneBy(array('name'=>'Acme'));
        
        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('xidea_organization_show', array('id'=>$organization->getId())));

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Acme")')->count()
        );
    }
}

