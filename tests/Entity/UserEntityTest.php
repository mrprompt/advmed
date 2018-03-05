<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\UserEntity;
use App\Entity\AddressEntity;
use App\Entity\PhoneEntity;
use Doctrine\Common\Collections\ArrayCollection;
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
        $obj->active = true;

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

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getAddress
     */
    public function getAddressMustBeReturnArrayCollection()
    {
        $result = $this->user->getAddress();

        $this->assertInstanceOf(ArrayCollection::class, $result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::addAddress
     */
    public function addAddressMustBeReturn()
    {
        $address = new AddressEntity;
        $result = $this->user->addAddress($address);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getPhone
     */
    public function getPhoneMustBeReturnArrayCollection()
    {
        $result = $this->user->getPhone();

        $this->assertInstanceOf(ArrayCollection::class, $result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::addPhone
     */
    public function addPhoneMustBeReturn()
    {
        $phone = new PhoneEntity;
        $result = $this->user->addPhone($phone);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::setActive
     */
    public function setActiveReturnEmpty($obj)
    {
        $result = $this->user->setActive($obj->active);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\UserEntity::__construct
     * @covers       \App\Entity\UserEntity::getActive
     */
    public function getActiveReturnValue($obj)
    {
        $this->modifyAttribute($this->user, 'active', $obj->active);

        $this->assertEquals($this->user->getActive(), $obj->active);
    }
}
