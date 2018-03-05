<?php
namespace App\Repository;

use App\Entity\AddressEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AddressEntity::class);

        $this->em = $this->getEntityManager();
    }
    
    /**
     * Create address
     */
    public function create(AddressEntity $address)
    {
        $this->em->persist($address);
        $this->em->flush();

        return $address;
    }
    
    /**
     * update address
     */
    public function update(int $id, AddressEntity $address)
    {
        $search = $this->em->getRepository(AddressEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No address found for id ' . $id);
        }

        $search->setNumber($address->getNumber());
        
        $this->em->flush();

        return $search;
    }
}
