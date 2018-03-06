<?php
namespace App\Tests\Repository;

use App\Entity\AddressEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AddressRepositoryTest extends KernelTestCase
{
    /**
     * @var AddressEntity
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
        $this->obj = $this->em->getRepository(AddressEntity::class);
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
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::create
     * @expectedException \OutOfRangeException
     */
    public function createWithUnkdownUserThrowsException()
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
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::create
     * @expectedException \InvalidArgumentException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(
            1,
            '',
            '',
            ''
        );
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::create
     */
    public function createMustBeReturnAddressEntity()
    {
        $result = $this->obj->create(
            1,
            uniqid(),
            uniqid(),
            uniqid()
        );

        $this->assertInstanceOf(AddressEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::update
     */
    public function updateMustBeReturnAddressEntity()
    {
        $result = $this->obj->update(
            1,
            1,
            uniqid(),
            uniqid(),
            uniqid()
        );

        $this->assertInstanceOf(AddressEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithAbsentThrowsException()
    {
        $result = $this->obj->update(
            1,
            0,
            uniqid(),
            uniqid(),
            uniqid()
        );
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithUnkownUserThrowsException()
    {
        $result = $this->obj->update(
            0,
            1,
            uniqid(),
            uniqid(),
            uniqid()
        );
    }
}
