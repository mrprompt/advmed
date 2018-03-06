<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\PhoneEntity;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Phone Repository
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class PhoneRepository extends ServiceEntityRepository
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
        parent::__construct($registry, PhoneEntity::class);

        $this->em = $this->getEntityManager();
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * Create phone to user
     * 
     * @param int $uid
     * @param string $number
     */
    public function create(int $uid, string $number): PhoneEntity
    {
        $user = $this->userRepository->find($uid);

        $phone = new PhoneEntity;
        $phone->setNumber($number);

        $errors = $this->validator->validate($phone);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors);
        }

        $this->em->persist($phone);

        $user->addPhone($phone);

        $this->em->persist($user);
        $this->em->flush();

        return $phone;
    }

    /**
     * Create phone to user
     * 
     * @param int $uid
     * @param int $phoneId
     * @param string $number
     */
    public function update(int $uid, int $phoneId, string $number): PhoneEntity
    {
        $user = $this->userRepository->find($uid);

        if (!$user) {
            throw new \OutOfRangeException('No user found for id ' . $uid);
        }
        
        $phone = $this->em->getRepository(PhoneEntity::class)->find($phoneId);

        if (!$phone) {
            throw new \OutOfRangeException('No phone found for id ' . $phoneId);
        }

        $phone->setNumber($phone);

        $this->em->persist($phone);

        return $phone;
    }
}
