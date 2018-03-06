<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\AddressEntity;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Addresss Repository
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AddressRepository extends ServiceEntityRepository
{
    /**
     * Validator
     * 
     * @var ValidatorInterface;
     */
    private $validator;
    
    /**
     * User Repository
     * 
     * @var UserRepository
     */
    private $userRepository;
    
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
        parent::__construct($registry, AddressEntity::class);

        $this->em = $this->getEntityManager();
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * Create Address to user
     * 
     * @param int $uid,
     * @param string $street,
     * @param string $number,
     * @param string $neighborhood
     */
    public function create(
        int $uid,
        string $street,
        string $number,
        string $neighborhood
    ): AddressEntity
    {
        $user = $this->userRepository->find($uid);

        if (!$user) {
            throw new \OutOfRangeException('No user found for id ' . $uid);
        }

        $address = new AddressEntity;
        $address->setStreet($street);
        $address->setNumber($number);
        $address->setNeighborhood($neighborhood);

        $errors = $this->validator->validate($address);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $this->em->persist($address);

        $user->addAddress($address);

        $this->em->persist($user);
        $this->em->flush();

        return $address;
    }

    /**
     * Update Address from user
     * 
     * @param int $uid,
     * @param int $addressId
     * @param string $street,
     * @param string $number,
     * @param string $neighborhood
     */
    public function update(
        int $uid,
        int $addressId,
        string $street,
        string $number,
        string $neighborhood
    ): AddressEntity
    {
        $user = $this->userRepository->find($uid);

        if (!$user) {
            throw new \OutOfRangeException('No user found for id ' . $uid);
        }

        $address = $this->em->getRepository(AddressEntity::class)->find($addressId);

        if (!$address) {
            throw new \OutOfRangeException('No address found for id ' . $addressId);
        }

        $address->setStreet($street);
        $address->setNumber($number);
        $address->setNeighborhood($neighborhood);

        $errors = $this->validator->validate($address);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $this->em->persist($address);
        $this->em->flush();

        return $address;
    }
}
