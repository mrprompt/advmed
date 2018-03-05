<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Subsription Controller Test Case
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SubscriptionControllerTest extends WebTestCase
{
    use Traits\Base;

    /**
     * Data Provider
     * 
     * @return array
     */
    public function validSubscriptions()
    {
        $subscription1 = [
            'title' => 'foo',
            'description' => 'foo bar bar',
            'period' => 'week',
            'user' => 1,
        ];

        return [
            [
                $subscription1
            ]
        ];
    }

    /**
     * Data Provider
     * 
     * @return array
     */
    public function invalidSubscriptions()
    {
        $subscription1 = [
            'title' => '',
            'description' => '',
            'period' => '',
            'user' => 0,
        ];

        return [
            [
                $subscription1
            ]
        ];
    }
    
    /**
     * @test
     * @covers \App\Controller\SubscriptionController::index
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/subscription/');
        $content = $this->client->getResponse()->getContent();
        $json = json_decode($content, true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(is_array($json));
    }
    
    /**
     * @test
     * @dataProvider validSubscriptions
     * @covers \App\Controller\SubscriptionController::add
     */
    public function addWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('POST', '/subscription/', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertNotEmpty($result['id']);
        $this->assertNotEmpty($result['title']);
        $this->assertNotEmpty($result['description']);
        $this->assertNotEmpty($result['active']);
        $this->assertNotEmpty($result['advertisement']);
        $this->assertNotEmpty($result['price']);
        $this->assertNotEmpty($result['validity']);
        $this->assertNotEmpty($result['createdAt']);
        $this->assertNotEmpty($result['updatedAt']);
    }
    
    /**
     * @test
     * @dataProvider invalidSubscriptions
     * @covers \App\Controller\SubscriptionController::add
     */
    public function addWithInvalidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('POST', '/subscription/', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validSubscriptions
     * @covers \App\Controller\SubscriptionController::update
     */
    public function updateWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('PUT', '/subscription/1', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validSubscriptions
     * @covers \App\Controller\SubscriptionController::update
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateWithNotFoundReturnError($data)
    {
        $crawler = $this->client->request('PUT', '/subscription/0', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @covers \App\Controller\SubscriptionController::update
     */
    public function updateWithInvalidRequestReturnError()
    {
        $crawler = $this->client->request('PUT', '/subscription/1', []);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @covers \App\Controller\SubscriptionController::delete
     */
    public function deleteWithValidRequestReturnResponseWithId()
    {
        $crawler = $this->client->request('DELETE', '/subscription/1');
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @covers \App\Controller\SubscriptionController::delete
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteWithUnknownSubsriptionDispatchError()
    {
        $this->client->request('DELETE', '/subscription/0');
    }
    
    /**
     * @test
     * @covers \App\Controller\SubscriptionController::details
     */
    public function detailsWithValidRequestReturnResponseWithId()
    {
        $crawler = $this->client->request('GET', '/subscription/1');
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validSubscriptions
     * @covers \App\Controller\SubscriptionController::details
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function detailsWithUnknownSubsriptionDispatchError()
    {
        $this->client->request('GET', '/subscription/0');
    }
}
