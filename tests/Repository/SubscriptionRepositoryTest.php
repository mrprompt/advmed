<?php
namespace App\Tests\Repository;

use DateTime;
use App\Entity\SubscriptionEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SubscriptionRepositoryTest extends KernelTestCase
{
    /**
     * @var SubscriptionEntity
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
        $this->obj = $this->em->getRepository(SubscriptionEntity::class);
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
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::create
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
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::create
     */
    public function createMustBeReturnSubscriptionEntity()
    {
        $result = $this->obj->create(
            1,
            'foo',
            'foo bar',
            'daily'
        );

        $this->assertInstanceOf(SubscriptionEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::update
     */
    public function updateMustBeReturnSubscriptionEntity()
    {
        $result = $this->obj->update(1, 'foo', 'foo bar bar');

        $this->assertInstanceOf(SubscriptionEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithAbsentThrowsException()
    {
        $this->obj->update(0, 'foo', 'foo bar bar');
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::update
     * @expectedException \InvalidArgumentException
     */
    public function updateWithEmptyValuesThrowsException()
    {
        $this->obj->update(1, '', '');
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::delete
     */
    public function deleteMustBeReturnSubscriptionEntity()
    {
        $result = $this->obj->delete(1);

        $this->assertInstanceOf(SubscriptionEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::delete
     * @expectedException \OutOfRangeException
     */
    public function deleteWithAbsentThrowsException()
    {
        $this->obj->delete(0);
    }
}
