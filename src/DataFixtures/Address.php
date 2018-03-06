<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\AddressEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Address extends Fixture implements DependentFixtureInterface
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
            $this->createAddress($i, $manager);

            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            Phone::class,
        );
    }

    /**
     * @param $i
     * @param ObjectManager $manager
     * @return UserModel
     */
    private function createAddress($i, ObjectManager $manager)
    {
        $address = new AddressEntity();
        $address->setStreet('Street name');
        $address->setNumber('1A');
        $address->setNeighborhood('Neighborhood name');

        $manager->persist($address);

        $user = $this->getReference('user_' . $i);
        $user->addAddress($address);

        $manager->persist($user);

        $manager->flush();

        $this->addReference('address_' . $i, $address);

        return $address;
    }
}
