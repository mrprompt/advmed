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
     * @expectedException \Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(new PhoneEntity());
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::create
     */
    public function createMustBeReturnPhoneEntity()
    {
        $phone = new PhoneEntity();
        $phone->setNumber('000000');
        
        $result = $this->obj->create($phone);

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::update
     */
    public function updateMustBeReturnPhoneEntity()
    {
        $phone = new PhoneEntity();
        $phone->setNumber('000000');

        $result = $this->obj->update(1, $phone);

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\PhoneRepository::__construct
     * @covers \App\Repository\PhoneRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithAbsentThrowsException()
    {
        $phone = new PhoneEntity();
        $phone->setNumber('000000');

        $result = $this->obj->update(0, $phone);

        $this->assertInstanceOf(PhoneEntity::class, $result);
    }
}
