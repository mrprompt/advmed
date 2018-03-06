<?php
namespace App\Tests\Repository;

use App\Entity\PhoneEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class PhoneRepositoryTest extends KernelTestCase
{
    /**
     * @var PhoneEntity
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
        $this->obj = $this->em->getRepository(PhoneEntity::class);
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
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::create
     * @expectedException \TypeError
     */
    public function createWithNullThrowsError()
    {
        $result = $this->obj->create(1, null);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::create
     * @expectedException \InvalidArgumentException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(1, '');
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::create
     */
    public function createMustBeReturnPhoneEntity()
    {
        $result = $this->obj->create(1, '000000000');

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::update
     */
    public function updateMustBeReturnPhoneEntity()
    {
        $result = $this->obj->update(1, 1, '0000000');

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithUnkownUserThrowsException()
    {
        $result = $this->obj->update(0, 1, '999999999');

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithUnkownPhoneThrowsException()
    {
        $result = $this->obj->update(1, 0, '999999999');

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }
}
