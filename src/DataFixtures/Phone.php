<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\PhoneEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Phone extends Fixture implements DependentFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        while ($i <= 10) {
            $this->createPhone($i, $manager);

            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            User::class,
        );
    }

    /**
     * @param $i
     * @param ObjectManager $manager
     * @return UserModel
     */
    private function createPhone($i, ObjectManager $manager)
    {
        $phone = new PhoneEntity();
        $phone->setNumber(1234567890);

        $manager->persist($phone);

        $user = $this->getReference('user_' . $i);
        $user->addPhone($phone);

        $manager->persist($user);

        $manager->flush();

        $this->addReference('phone_' . $i, $phone);

        return $phone;
    }
}
