<?php
declare(strict_types = 1);

namespace App\Repository;

use DateTime;
use DateInterval;
use App\Entity\AdvertisementEntity;
use App\Entity\SubscriptionEntity;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Subscription Repository
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    /**
     * User Repository
     * 
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Validator
     * 
     * @var ValidatorInterface;
     */
    private $validator;

    /**
     * Constructor
     * 
     * @param RegistryInterface $registry
     * @param ValidatorInterface $validator
     * @param UserRepository $userRepository
     */
    public function __construct(
        RegistryInterface $registry, 
        ValidatorInterface $validator,
        UserRepository $userRepository
    )
    {
        parent::__construct($registry, SubscriptionEntity::class);

        $this->em = $this->getEntityManager();
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * Calculate validity
     * 
     * @param string $period <daily, week, month>
     * 
     * @return DateTime
     * 
     * @codeCoverageIgnore
     */
    private function calculateValidity(string $period): DateTime
    {
        $interval = 'P30D';

        switch ($period) {
            case 'daily':
                $interval = 'P1D';
                break;
            
            case 'week':
                $interval = 'P7D';
                break;
        }
        
        $validity = new DateTime();
        $validity->add(new DateInterval($interval));

        return $validity;
    }

    /**
     * Calculate the price
     * 
     * @param string $period <daily, week, month>
     * 
     * @return float
     * 
     * @codeCoverageIgnore
     */
    private function calculatePrice(string $period): ?float
    {
        $price = !array_key_exists($period, AdvertisementEntity::PERIOD) ? 0: AdvertisementEntity::PERIOD[ $period ];

        return $price;
    }
    
    /**
     * Create subscription
     */
    public function create(
        int $user,
        string $title,
        string $description,
        string $period
    ): SubscriptionEntity
    {
        try {
            $validity = $this->calculateValidity($period);
            $price = $this->calculatePrice($period);

            $advertisement = new AdvertisementEntity;
            $advertisement->setPeriod($period);
            $advertisement->setName($title);

            $subscription = new SubscriptionEntity;
            $subscription->setTitle($title);
            $subscription->setDescription($description);
            $subscription->setPrice($price);
            $subscription->setActive(true);
            $subscription->setValidity($validity);
            $subscription->setAdvertisement($advertisement);

            $userEntity = $this->userRepository->find($user);
            $userEntity->addSubscription($subscription);
            
            $this->userRepository->update($user, $userEntity);

            return $subscription;
        } catch (\TypeError $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        }
    }
    
    /**
     * update subscription
     * 
     * @param int $id
     * @param string $title
     * @param string $description
     * 
     * @return SubscriptionEntity
     * 
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     */
    public function update(int $id, string $title, string $description): SubscriptionEntity
    {
        $search = $this->em->getRepository(SubscriptionEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No subscription found for id ' . $id);
        }

        $search->setTitle($title);
        $search->setDescription($description);
        $search->setActive(true);

        $errors = $this->validator->validate($search);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $this->em->persist($search);
        $this->em->flush();

        return $search;
    }
    
    /**
     * delete subscription
     * 
     * @param int $id
     * 
     * @return SubscriptionEntity
     * 
     * @throws \OutOfRangeException
     */
    public function delete(int $id): SubscriptionEntity
    {
        $search = $this->em->getRepository(SubscriptionEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No subscription found for id ' . $id);
        }

        $search->setActive(false);

        $this->em->persist($search);
        $this->em->flush();

        return $search;
    }

    /**
     * Report
     * 
     * @return array
     */
    public function reportAll(): ?array
    {
        $report = $this
            ->createQueryBuilder('s')
            ->andWhere('s.active = :active')
            ->setParameter('active', true)
            ->select('s, SUM(s.price) as total')
            ->groupBy('s.user')
            ->getQuery()
            ->getResult();

        return $report;
    }

    /**
     * Report by user
     * 
     * @param int $uid
     * 
     * @return array
     * 
     * @throws \OutOfRangeException
     */
    public function reportByUser(int $uid): ?array
    {
        $user = $this->userRepository->find($uid);

        if (!$user) {
            throw new \OutOfRangeException('No user found for subscription');
        }

        $report = $this
            ->createQueryBuilder('s')
            ->andWhere('s.active = :active')
            ->andWhere('s.user = :user')
            ->setParameter('active', true)
            ->setParameter('user', $user)
            ->select('s, SUM(s.price) as total')
            ->getQuery()
            ->getResult();

        return $report;
    }
}
