<?php
declare(strict_types = 1);

namespace App\Tests\Controller\Traits;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Application Test Suite Load Fixtures
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait Base
{
    /**
     * Class Bootstrap
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $kernel = self::bootKernel();

        $em = $kernel->getContainer()->get('doctrine')->getManager();

        /* @var $metadata array */
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        /* @var $tool SchemaTool */
        $tool = new SchemaTool($em);
        $tool->dropSchema($metadata);
        $tool->createSchema($metadata);

        /* @var $loader Loader */
        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__ . '/../../../src/DataFixtures');

        /* @var $executor ORMExecutor */
        $executor = new ORMExecutor($em);
        $executor->execute($loader->getFixtures(), true);

        parent::setUpBeforeClass();
    }

    /**
     * Bootstrap
     */
    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->client = static::createClient();
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->client = null;
    }
}
