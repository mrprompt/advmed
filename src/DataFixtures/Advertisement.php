<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\AdvertisementEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Advertisement extends Fixture implements DependentFixtureInterface
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
            $this->createAdvertisement($i, $manager);

            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            Address::class,
        );
    }

    /**
     * @param $i
     * @param ObjectManager $manager
     * @return UserModel
     */
    private function createAdvertisement($i, ObjectManager $manager)
    {
        $advertisement = new AdvertisementEntity();
        $advertisement->setName('Foo');
        $advertisement->setPeriod(array_rand(AdvertisementEntity::PERIOD));
        $advertisement->setTitle('Foo');
        $advertisement->setDescription('Foo Bar Bar');
        $advertisement->setPrice(AdvertisementEntity::PERIOD[ $advertisement->getPeriod() ]);
        $advertisement->setActive(true);
        $advertisement->setValidity(new DateTime());

        $manager->persist($advertisement);

        $user = $this->getReference('user_' . $i);
        $user->addAdvertisement($advertisement);

        $manager->persist($user);

        $manager->flush();

        $this->addReference('advertisement_' . $i, $advertisement);

        return $advertisement;
    }
}
