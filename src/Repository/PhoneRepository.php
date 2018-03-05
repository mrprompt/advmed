<?php
namespace App\Repository;

use App\Entity\PhoneEntity;
use App\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PhoneRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhoneEntity::class);

        $this->em = $this->getEntityManager();
    }
    
    /**
     * Create phone
     */
    public function create(PhoneEntity $phone)
    {
        $this->em->persist($phone);
        $this->em->flush();

        return $phone;
    }
    
    /**
     * update phone
     */
    public function update(int $id, PhoneEntity $phone)
    {
        $search = $this->em->getRepository(PhoneEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No phone found for id ' . $id);
        }

        $search->setNumber($phone->getNumber());
        
        $this->em->flush();

        return $search;
    }
}
