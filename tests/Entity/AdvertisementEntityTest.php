<?php
declare(strict_types = 1);

namespace App\Tests\Entity;

use App\Tests\Entity\Traits\ChangeProtectedAttribute;
use App\Entity\AdvertisementEntity;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

/**
 * Advertisement Entity Test Case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AdvertisementEntityTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * The advertisement entity
     * 
     * @var AdvertisementEntity
     */
    private $advertisement;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->advertisement = new AdvertisementEntity;
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->advertisement = null;
        
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
        $obj->period = 'daily';
        $obj->createdAt = new DateTime;
        $obj->updatedAt = new DateTime;

        $obj2 = clone $obj;
        $obj2->id = 2;
        $obj2->period = 'week';

        $obj3 = clone $obj;
        $obj3->id = 3;
        $obj3->period = 'month';

        return [
            [
                $obj
            ],
            [
                $obj2
            ],
            [
                $obj3
            ],
        ];
    }

    /**
     * @return multitype:multitype:number
     */
    public function invalidObjects()
    {
        $obj = new stdClass();
        $obj->id = null;
        $obj->name  = null;
        $obj->period = '';
        $obj->createdAt = '2018-01-01';
        $obj->updatedAt = '2018-01-01';

        $obj2 = clone $obj;
        $obj2->period = 'fooo';

        return [
            [
                $obj
            ],
            [
                $obj2
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::getId
     */
    public function getIdReturnValue($obj)
    {
        $this->modifyAttribute($this->advertisement, 'id', $obj->id);

        $this->assertEquals($this->advertisement->getId(), $obj->id);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setName
     */
    public function setNameReturnEmpty($obj)
    {
        $result = $this->advertisement->setName($obj->name);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider invalidObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setName
     * @expectedException \TypeError
     */
    public function setNameWithoutStringThrowsException($obj)
    {
        $this->advertisement->setName($obj->name);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::getName
     */
    public function getNameReturnValue($obj)
    {
        $this->modifyAttribute($this->advertisement, 'name', $obj->name);

        $this->assertEquals($this->advertisement->getName(), $obj->name);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setPeriod
     */
    public function setPeriodReturnEmpty($obj)
    {
        $result = $this->advertisement->setPeriod($obj->period);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider invalidObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setPeriod
     * @expectedException \TypeError
     */
    public function setPeriodWithoutStringThrowsException($obj)
    {
        $this->advertisement->setPeriod($obj->period);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::getPeriod
     */
    public function getPeriodReturnValue($obj)
    {
        $this->modifyAttribute($this->advertisement, 'period', $obj->period);

        $this->assertEquals($this->advertisement->getPeriod(), $obj->period);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setCreatedAt
     */
    public function setCreatedAtReturnEmpty($obj)
    {
        $result = $this->advertisement->setCreatedAt($obj->createdAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::getCreatedAt
     */
    public function getCreatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->advertisement, 'createdAt', $obj->createdAt);

        $this->assertEquals($this->advertisement->getCreatedAt(), $obj->createdAt);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::setUpdatedAt
     */
    public function setUpdatedAtReturnEmpty($obj)
    {
        $result = $this->advertisement->setUpdatedAt($obj->updatedAt);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \App\Entity\AdvertisementEntity::__construct
     * @covers       \App\Entity\AdvertisementEntity::getUpdatedAt
     */
    public function getUpdatedAtReturnValue($obj)
    {
        $this->modifyAttribute($this->advertisement, 'updatedAt', $obj->updatedAt);

        $this->assertEquals($this->advertisement->getUpdatedAt(), $obj->updatedAt);
    }
}
