<?php
namespace App\Tests\Repository;

use App\Entity\UserEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var UserEntity
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
        $this->obj = $this->em->getRepository(UserEntity::class);
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
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::create
     * @expectedException \InvalidArgumentException
     */
    public function createWithUnpopulatedEntityThrowsException()
    {
        $this->obj->create(
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }

    /**
     * @test
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::create
     */
    public function createMustBeReturnUserEntity()
    {
        $result = $this->obj->create(
            'Foo Bar',
            'foo' . uniqid() . '@bar.bar',
            uniqid(),
            '00000',
            '1A',
            'FooBarBar',
            'FooBarBarBar'
        );

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::update
     */
    public function updateMustBeReturnUserEntity()
    {
        $result = $this->obj->update(
            1,
            'Foo Bar',
            '00000',
            '1A',
            'FooBarBar',
            'FooBarBarBar'
        );

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::update
     * @expectedException \OutOfRangeException
     */
    public function updateWithAbsentThrowsException()
    {
        $this->obj->update(
            0,
            'Foo Bar',
            '00000',
            '1A',
            'FooBarBar',
            'FooBarBarBar'
        );
    }

    /**
     * @test
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::delete
     */
    public function deleteMustBeReturnUserEntity()
    {
        $result = $this->obj->delete(1);

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * @test
     * @covers \App\Repository\UserRepository::__construct
     * @covers \App\Repository\UserRepository::delete
     * @expectedException \OutOfRangeException
     */
    public function deleteWithAbsentThrowsException()
    {
        $user = new UserEntity();
        
        $this->obj->delete(0);
    }
}
