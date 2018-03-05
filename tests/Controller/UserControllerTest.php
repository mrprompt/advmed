<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * User Controller Test Case
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserControllerTest extends WebTestCase
{
    use Traits\Base;
    
    /**
     * @test
     * @covers \App\Controller\UserController::index
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/user/');
        $content = $this->client->getResponse()->getContent();
        $json = json_decode($content, true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(is_array($json));
    }

    public function validUsers()
    {
        $user1 = [
            'name' => 'foo',
            'email' => 'foo@foo.bar',
            'password' => '123123123',
            'phone' => '0000000000',
            'street' => 'fooo',
            'number' => '000',
            'neighborhood' => 'foo bar bar'
        ];

        return [
            [
                $user1
            ]
        ];
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::add
     */
    public function addWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('POST', '/user/', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertNotEmpty($result['id']);
        $this->assertNotEmpty($result['createdAt']);
        $this->assertNotEmpty($result['updatedAt']);
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::add
     * @depends addWithValidRequestReturnResponseWithId
     */
    public function addWithRepeatEmailThrowsException($data)
    {
        $crawler = $this->client->request('POST', '/user/', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::update
     */
    public function updateWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('PUT', '/user/1', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::update
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateWithUnknownUserDispatchError($data)
    {
        $this->client->request('PUT', '/user/0', $data);
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::delete
     */
    public function deleteWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('DELETE', '/user/1', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::delete
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteWithUnknownUserDispatchError($data)
    {
        $this->client->request('DELETE', '/user/0', $data);
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::details
     */
    public function detailsWithValidRequestReturnResponseWithId($data)
    {
        $crawler = $this->client->request('GET', '/user/1', $data);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @dataProvider validUsers
     * @covers \App\Controller\UserController::details
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function detailsWithUnknownUserDispatchError($data)
    {
        $this->client->request('GET', '/user/0', $data);
    }
}
