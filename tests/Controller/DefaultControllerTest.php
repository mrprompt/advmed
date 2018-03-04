<?php
namespace App\Tests\Controller;

use App\Tests\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Default Controller Test Case
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Bootstrap
     */
    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->client = static::createClient();
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->client = null;
    }
    
    /**
     * @test
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
