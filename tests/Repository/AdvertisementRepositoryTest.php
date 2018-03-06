<?php
namespace App\Tests\Repository;

use App\Entity\AdvertisementEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AdvertisementRepositoryTest extends KernelTestCase
{
    /**
     * @var AdvertisementEntity
     */
    protected $obj;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Bootstrap
     */
    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
        $this->obj = $this->em->getRepository(AdvertisementEntity::class);
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->em->close();

        $this->em = null;
        $this->obj = null;
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::create
     * @expectedException \InvalidArgumentException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(
            0,
            '',
            '',
            ''
        );
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::create
     */
    public function createMustBeReturnAdvertisementEntity()
    {
        $result = $this->obj->create(
            1,
            'foo',
            'foo bar',
            'daily'
        );

        $this->assertInstanceOf(AdvertisementEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::update
     */
    public function updateMustBeReturnAdvertisementEntity()
    {
        $result = $this->obj->update(1, 'foo', 'foo bar bar');

        $this->assertInstanceOf(AdvertisementEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithAbsentThrowsException()
    {
        $this->obj->update(0, 'foo', 'foo bar bar');
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::update
     * @expectedException \InvalidArgumentException
     */
    public function updateWithEmptyValuesThrowsException()
    {
        $this->obj->update(1, '', '');
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::delete
     */
    public function deleteMustBeReturnAdvertisementEntity()
    {
        $result = $this->obj->delete(1);

        $this->assertInstanceOf(AdvertisementEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::delete
     * @expectedException \OutOfRangeException
     */
    public function deleteWithAbsentThrowsException()
    {
        $this->obj->delete(0);
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::reportAll
     */
    public function reportAllMustBeReturnArray()
    {
        $result = $this->obj->reportAll();

        $this->assertTrue(is_array($result));
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::reportByUser
     */
    public function reportByUserWithValidUserReturnArray()
    {
        $result = $this->obj->reportByUser(1);

        $this->assertTrue(is_array($result));
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::reportByUser
     * @expectedException \OutOfRangeException
     */
    public function reportByUserWithAbsentThrowsException()
    {
        $this->obj->reportByUser(0);
    }
}
