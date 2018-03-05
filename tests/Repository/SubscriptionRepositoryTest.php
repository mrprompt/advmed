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
     * @expectedException \Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $result = $this->obj->create(new SubscriptionEntity());
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::create
     */
    public function createMustBeReturnSubscriptionEntity()
    {
        $subscription = new SubscriptionEntity();
        $subscription->setTitle('foo');
        $subscription->setDescription('foo');
        $subscription->setPrice(10.00);
        $subscription->setActive(true);
        $subscription->setValidity(new DateTime);
        
        $result = $this->obj->create($subscription);

        $this->assertInstanceOf(SubscriptionEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\SubscriptionRepository::__construct
     * @covers \App\Repository\SubscriptionRepository::update
     */
    public function updateMustBeReturnSubscriptionEntity()
    {
        $subscription = new SubscriptionEntity();
        $subscription->setTitle('foo');
        $subscription->setDescription('foo foo foo');
        $subscription->setActive(true);
        $subscription->setValidity(new DateTime);

        $result = $this->obj->update(1, $subscription);

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
        $subscription = new SubscriptionEntity();

        $result = $this->obj->update(0, $subscription);

        $this->assertInstanceOf(SubscriptionEntity::class, $result);
    }
}
