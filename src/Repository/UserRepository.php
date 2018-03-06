<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\AddressEntity;
use App\Entity\PhoneEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * User Repository
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserRepository extends ServiceEntityRepository
{
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
     */
    public function __construct(
        RegistryInterface $registry,
        ValidatorInterface $validator
    )
    {
        parent::__construct($registry, UserEntity::class);

        $this->em = $this->getEntityManager();
        $this->validator = $validator;
    }
    
    /**
     * Create user
     * 
     * @param string $name,
     * @param string $email,
     * @param string $password,
     * @param string $phoneNumber,
     * @param string $number,
     * @param string $street,
     * @param string $neighborhood
     * 
     * @return UserEntity
     * 
     * @throws \InvalidArgumentException
     */
    public function create(
        string $name,
        string $email,
        string $password,
        string $phoneNumber,
        string $number,
        string $street,
        string $neighborhood
    ): UserEntity
    {
        try {
            $phone = new PhoneEntity;
            $phone->setNumber($phoneNumber);

            $this->em->persist($phone);

            $address = new AddressEntity;
            $address->setStreet($street);
            $address->setNumber($number);
            $address->setNeighborhood($neighborhood);

            $this->em->persist($address);

            $user = new UserEntity;
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setActive(true);
            $user->addAddress($address);
            $user->addPhone($phone);

            $errors = $this->validator->validate($user);

            if (count($errors) > 0) {
                throw new \InvalidArgumentException((string) $errors);
            }

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        } catch (UniqueConstraintViolationException $ex) {
            throw new \OverflowException("An user with this email is already registered");
        }
    }
    
    /**
     * update user
     * 
     * @param int $id
     * @param string $name,
     * @param string $phoneNumber,
     * @param string $number,
     * @param string $street,
     * @param string $neighborhood
     * 
     * @return UserEntity
     * 
     * @throws \InvalidArgumentException
     */
    public function update(
        int $id, 
        string $name,
        string $phoneNumber,
        string $number,
        string $street,
        string $neighborhood
    ): UserEntity
    {
        $user = $this->em->getRepository(UserEntity::class)->find($id);

        if (!$user) {
            throw new \OutOfRangeException('No user found for id ' . $id);
        }

        $user->setName($name);
        $user->setActive(true);

        $phone = $user->getPhone()->first();

        if ($phone === false) {
            $phone = new PhoneEntity;

            $user->addPhone($phone);
        }
        
        $phone->setNumber($phoneNumber);

        $address = $user->getAddress()->first();

        if ($address === false) {
            $address = new AddressEntity;

            $user->addAddress($address);
        }

        $address->setStreet($street);
        $address->setNumber($number);
        $address->setNeighborhood($neighborhood);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
    
    /**
     * delete user
     * 
     * @param int $id
     * 
     * @throws \OutOfRangeException
     * 
     * @return
     */
    public function delete(int $id): UserEntity
    {
        $user = $this->em->getRepository(UserEntity::class)->find($id);

        if (!$user) {
            throw new \OutOfRangeException('No user found for id ' . $id);
        }

        $user->setActive(false);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
