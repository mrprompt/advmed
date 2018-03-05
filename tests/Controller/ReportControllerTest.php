<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Report Controller Test Case
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class ReportControllerTest extends WebTestCase
{
    use Traits\Base;
    
    /**
     * @test
     * @covers \App\Controller\ReportController::index
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/report/');
        $content = $this->client->getResponse()->getContent();
        $json = json_decode($content, true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(is_array($json));
    }
    
    /**
     * @test
     * @covers \App\Controller\ReportController::details
     */
    public function detailsWithValidRequestReturnResponseWithId()
    {
        $crawler = $this->client->request('GET', '/report/1');
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(is_array($result));
    }
    
    /**
     * @test
     * @covers \App\Controller\ReportController::details
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function detailsWithUnknownReportDispatchError()
    {
        $this->client->request('GET', '/report/0');
    }
}
