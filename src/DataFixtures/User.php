<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\UserEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User extends Fixture
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

    /**
     * @param $i
     * @param ObjectManager $manager
     * @return UserModel
     */
    private function createUser($i, ObjectManager $manager)
    {
        $data = [
            'id' => $i,
            'name' => 'User ' . $i,
            'email' => 'user' . $i . '@users.net',
            'password' => '123123123',
            'active' => true 
        ];

        $user = new UserEntity();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setActive(true);

        $manager->persist($user);
        $manager->flush();

        $this->addReference('user_' . $i, $user);

        return $user;
    }
}
