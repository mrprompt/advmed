<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\PhoneEntity;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

/**
 * Phone test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class PhoneEntityTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * The phone entity
     * 
     * @var PhoneEntity
     */
    private $phone;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->phone = new PhoneEntity;
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->phone = null;
        
        parent::tearDown();
    }

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->number = '111A';
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
     * @covers       \App\Entity\PhoneEntity::__construct
     * @covers       \App\Entity\PhoneEntity::getId
     */
    public function getIdReturnValue($obj)
    {
        $this->modifyAttribute($this->phone, 'id', $obj->id);

        $this->assertEquals($this->phone->getId(), $obj->id);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\PhoneEntity::__construct
     * @covers       \App\Entity\PhoneEntity::setNumber
     */
    public function setNumberReturnEmpty($obj)
    {
        $result = $this->phone->setNumber($obj->number);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\PhoneEntity::__construct
     * @covers       \App\Entity\PhoneEntity::getNumber
     */
    public function getNumberReturnValue($obj)
    {
        $this->modifyAttribute($this->phone, 'number', $obj->number);

        $this->assertEquals($this->phone->getNumber(), $obj->number);
    }
}
