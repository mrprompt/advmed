<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\SubscriptionEntity;
use App\Entity\UserEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Subscription extends Fixture implements DependentFixtureInterface
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
            $this->createUser($i, $manager);

            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            Advertisement::class,
        );
    }

    /**
     * @param $i
     * @param ObjectManager $manager
     * @return UserModel
     */
    private function createUser($i, ObjectManager $manager)
    {
        $user = $this->getReference('user_' . $i);

        $subscription = new SubscriptionEntity();
        $subscription->setTitle('Foo');
        $subscription->setDescription('Foo Bar Bar');
        $subscription->setPrice(5.00);
        $subscription->setActive(true);
        $subscription->setValidity(new DateTime());
        $subscription->setAdvertisement($this->getReference('advertisement_' . $i));

        $manager->persist($subscription);
        
        $user->addSubscription($subscription);

        $manager->persist($user);
        
        $manager->flush();

        return $subscription;
    }
}
