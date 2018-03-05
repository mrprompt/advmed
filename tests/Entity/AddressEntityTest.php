<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\AddressEntity;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

/**
 * Address test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AddressEntityTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * The address entity
     * 
     * @var AddressEntity
     */
    private $address;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->address = new AddressEntity;
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->address = null;
        
        parent::tearDown();
    }

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->street  = 'fooo';
        $obj->number = '111A';
        $obj->neighborhood = 'fooo';
        $obj->city = 'fooo';
        $obj->state = 'fooo';
        $obj->country = 'fooo';
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
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getId
     */
    public function getIdReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'id', $obj->id);

        $this->assertEquals($this->address->getId(), $obj->id);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::setStreet
     */
    public function setStreetReturnEmpty($obj)
    {
        $result = $this->address->setStreet($obj->street);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getStreet
     */
    public function getStreetReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'street', $obj->street);

        $this->assertEquals($this->address->getStreet(), $obj->street);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::setNumber
     */
    public function setNumberReturnEmpty($obj)
    {
        $result = $this->address->setNumber($obj->number);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getNumber
     */
    public function getNumberReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'number', $obj->number);

        $this->assertEquals($this->address->getNumber(), $obj->number);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::setNeighborhood
     */
    public function setNeighborhoodReturnEmpty($obj)
    {
        $result = $this->address->setNeighborhood($obj->neighborhood);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getNeighborhood
     */
    public function getNeighborhoodReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'neighborhood', $obj->neighborhood);

        $this->assertEquals($this->address->getNeighborhood(), $obj->neighborhood);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::setCreatedAt
     */
    public function setCreatedAtReturnEmpty($obj)
    {
        $result = $this->address->setCreatedAt($obj->createdAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getCreatedAt
     */
    public function getCreatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'createdAt', $obj->createdAt);

        $this->assertEquals($this->address->getCreatedAt(), $obj->createdAt);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::setUpdatedAt
     */
    public function setUpdatedAtReturnEmpty($obj)
    {
        $result = $this->address->setUpdatedAt($obj->updatedAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AddressEntity::__construct
     * @covers       \App\Entity\AddressEntity::getUpdatedAt
     */
    public function getUpdatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->address, 'updatedAt', $obj->updatedAt);

        $this->assertEquals($this->address->getUpdatedAt(), $obj->updatedAt);
    }
}
