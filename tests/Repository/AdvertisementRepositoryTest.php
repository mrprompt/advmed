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

    public function validData()
    {
        $advertisement1 = new AdvertisementEntity;
        $advertisement1->setName('foo');
        $advertisement1->setPeriod('week');
        
        return [
            [
                $advertisement1
            ]
        ];
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::create
     * @dataProvider validData
     */
    public function createWithValidData($data)
    {
        $result = $this->obj->create($data);

        $this->assertTrue(is_object($result));
        $this->assertInstanceOf(AdvertisementEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\AdvertisementRepository::__construct
     * @covers \App\Repository\AdvertisementRepository::create
     * @expectedException \Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $this->obj->create(new AdvertisementEntity());
    }
}
