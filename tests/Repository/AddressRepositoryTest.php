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
     * @expectedException \Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(new AddressEntity());
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::create
     */
    public function createMustBeReturnAddressEntity()
    {
        $address = new AddressEntity();
        $address->setStreet(uniqid());
        $address->setNumber(uniqid());
        $address->setNeighborhood(uniqid());
        
        $result = $this->obj->create($address);

        $this->assertInstanceOf(AddressEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AddressRepository::__construct
     * @covers \App\Repository\AddressRepository::update
     */
    public function updateMustBeReturnAddressEntity()
    {
        $address = new AddressEntity();
        $address->setStreet(uniqid());
        $address->setNumber(uniqid());
        $address->setNeighborhood(uniqid());

        $result = $this->obj->update(1, $address);

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
        $address = new AddressEntity();
        $address->setStreet(uniqid());
        $address->setNumber(uniqid());
        $address->setNeighborhood(uniqid());

        $result = $this->obj->update(0, $address);

        $this->assertInstanceOf(AddressEntity::class, $result);
    }
}
