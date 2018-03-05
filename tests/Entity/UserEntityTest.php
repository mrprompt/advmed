<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\UserEntity;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

/**
 * User test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserEntityTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * The user entity
     * 
     * @var UserEntity
     */
    private $user;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->user = new UserEntity;
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->user = null;
        
        parent::tearDown();
    }

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->name  = 'Teste';
        $obj->email = 'teste@teste.net';
        $obj->password = 'fooo';
        $obj->createdAt = new DateTime;
        $obj->updatedAt = new DateTime;

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getId
     */
    public function getIdReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'id', $obj->id);

        $this->assertEquals($this->user->getId(), $obj->id);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setName
     */
    public function setNameReturnEmpty($obj)
    {
        $result = $this->user->setName($obj->name);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getName
     */
    public function getNameReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'name', $obj->name);

        $this->assertEquals($this->user->getName(), $obj->name);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setEmail
     */
    public function setEmailReturnEmpty($obj)
    {
        $result = $this->user->setEmail($obj->email);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getEmail
     */
    public function getEmailReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'email', $obj->email);

        $this->assertEquals($this->user->getEmail(), $obj->email);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setPassword
     */
    public function setPasswordReturnEmpty($obj)
    {
        $result = $this->user->setPassword($obj->password);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getPassword
     */
    public function getPasswordReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'password', $obj->password);

        $this->assertEquals($this->user->getPassword(), $obj->password);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setCreatedAt
     */
    public function setCreatedAtReturnEmpty($obj)
    {
        $result = $this->user->setCreatedAt($obj->createdAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getCreatedAt
     */
    public function getCreatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'createdAt', $obj->createdAt);

        $this->assertEquals($this->user->getCreatedAt(), $obj->createdAt);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setUpdatedAt
     */
    public function setUpdatedAtReturnEmpty($obj)
    {
        $result = $this->user->setUpdatedAt($obj->updatedAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getUpdatedAt
     */
    public function getUpdatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'updatedAt', $obj->updatedAt);

        $this->assertEquals($this->user->getUpdatedAt(), $obj->updatedAt);
    }
}
