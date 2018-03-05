<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Default Controller Test Case
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class DefaultControllerTest extends WebTestCase
{
    use Traits\Base;
    
    /**
     * @test
     */
    public function testIndex()
    {
        $message = '"OK in ' . date('Y-m-d H:i') . '"';
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($message, $this->client->getResponse()->getContent());
    }
}
