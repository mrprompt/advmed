<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\AdvertisementEntity;
use App\Entity\SubscriptionEntity;
use App\Entity\UserEntity;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

/**
 * Subscription test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SubscriptionEntityTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * The subscription entity
     * 
     * @var SubscriptionEntity
     */
    private $subscription;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->subscription = new SubscriptionEntity;
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->subscription = null;
        
        parent::tearDown();
    }

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->title  = 'Teste';
        $obj->description = 'teste teste teste';
        $obj->active = true;
        $obj->createdAt = new DateTime;
        $obj->updatedAt = new DateTime;
        $obj->advertisement = new AdvertisementEntity;
        $obj->user = new UserEntity;
        $obj->price = AdvertisementEntity::PERIOD['month'];
        $obj->validity = new DateTime;

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getId
     */
    public function getIdReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'id', $obj->id);

        $this->assertEquals($this->subscription->getId(), $obj->id);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setTitle
     */
    public function setTitleReturnEmpty($obj)
    {
        $result = $this->subscription->setTitle($obj->title);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getTitle
     */
    public function getTitleReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'title', $obj->title);

        $this->assertEquals($this->subscription->getTitle(), $obj->title);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setDescription
     */
    public function setDescriptionReturnEmpty($obj)
    {
        $result = $this->subscription->setDescription($obj->description);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getDescription
     */
    public function getDescriptionReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'description', $obj->description);

        $this->assertEquals($this->subscription->getDescription(), $obj->description);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setActive
     */
    public function setActiveReturnEmpty($obj)
    {
        $result = $this->subscription->setActive($obj->active);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getActive
     */
    public function getActiveReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'active', $obj->active);

        $this->assertEquals($this->subscription->getActive(), $obj->active);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setCreatedAt
     */
    public function setCreatedAtReturnEmpty($obj)
    {
        $result = $this->subscription->setCreatedAt($obj->createdAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getCreatedAt
     */
    public function getCreatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'createdAt', $obj->createdAt);

        $this->assertEquals($this->subscription->getCreatedAt(), $obj->createdAt);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setUpdatedAt
     */
    public function setUpdatedAtReturnEmpty($obj)
    {
        $result = $this->subscription->setUpdatedAt($obj->updatedAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getUpdatedAt
     */
    public function getUpdatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'updatedAt', $obj->updatedAt);

        $this->assertEquals($this->subscription->getUpdatedAt(), $obj->updatedAt);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getAdvertisement
     */
    public function getAdvertisementMustBeReturnEntity($obj)
    {
        $this->modifyAttribute($this->subscription, 'advertisement', $obj->advertisement);
        
        $result = $this->subscription->getAdvertisement();

        $this->assertInstanceOf(AdvertisementEntity::class, $result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setAdvertisement
     */
    public function setAdvertisementMustBeReturnNull($obj)
    {
        $advertisement = new AdvertisementEntity;
        $result = $this->subscription->setAdvertisement($advertisement);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getUser
     */
    public function getUserMustBeReturnEntity($obj)
    {
        $this->modifyAttribute($this->subscription, 'user', $obj->user);
        
        $result = $this->subscription->getUser();

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setUser
     */
    public function setUserMustBeReturnNull()
    {
        $user = new UserEntity;
        $result = $this->subscription->setUser($user);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getPrice
     */
    public function getPriceMustBeReturnEntity($obj)
    {
        $this->modifyAttribute($this->subscription, 'price', $obj->price);
        
        $result = $this->subscription->getPrice();

        $this->assertEquals($result, $obj->price);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setPrice
     */
    public function setPriceMustBeReturnNull($obj)
    {
        $result = $this->subscription->setPrice($obj->price);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::setValidity
     */
    public function setValidityReturnEmpty($obj)
    {
        $result = $this->subscription->setValidity($obj->validity);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\SubscriptionEntity::__construct
     * @covers       \App\Entity\SubscriptionEntity::getValidity
     */
    public function getValidityReturnValue($obj)
    {
        $this->modifyAttribute($this->subscription, 'validity', $obj->validity);

        $this->assertEquals($this->subscription->getValidity(), $obj->validity);
    }
}
