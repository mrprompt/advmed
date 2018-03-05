<?php
namespace App\Repository;

use App\Entity\SubscriptionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SubscriptionRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubscriptionEntity::class);

        $this->em = $this->getEntityManager();
    }
    
    /**
     * Create subscription
     */
    public function create(SubscriptionEntity $subscription)
    {
        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }
    
    /**
     * update subscription
     */
    public function update(int $id, SubscriptionEntity $subscription)
    {
        $search = $this->em->getRepository(SubscriptionEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No subscription found for id ' . $id);
        }

        $search->setTitle($subscription->getTitle());
        $search->setDescription($subscription->getDescription());

        $this->em->flush();

        return $search;
    }
}
