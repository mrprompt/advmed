<?php
declare(strict_types = 1);

namespace App\Repository;

use DateTime;
use DateInterval;
use App\Entity\AdvertisementEntity;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Advertisement Repository
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AdvertisementRepository extends ServiceEntityRepository
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
        parent::__construct($registry, AdvertisementEntity::class);

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
     * Create advertisement
     */
    public function create(
        int $user,
        string $title,
        string $description,
        string $period
    ): AdvertisementEntity
    {
        try {
            $validity = $this->calculateValidity($period);
            $price = $this->calculatePrice($period);

            $advertisement = new AdvertisementEntity;
            $advertisement->setPeriod($period);
            $advertisement->setName($title);
            $advertisement->setTitle($title);
            $advertisement->setDescription($description);
            $advertisement->setPrice($price);
            $advertisement->setActive(true);
            $advertisement->setValidity($validity);

            $this->em->persist($advertisement);

            $userEntity = $this->userRepository->find($user);
            $userEntity->addAdvertisement($advertisement);
            
            $this->em->persist($userEntity);
            $this->em->flush();

            return $advertisement;
        } catch (\TypeError $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        }
    }
    
    /**
     * update advertisement
     * 
     * @param int $id
     * @param string $title
     * @param string $description
     * 
     * @return AdvertisementEntity
     * 
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     */
    public function update(int $id, string $title, string $description): AdvertisementEntity
    {
        $search = $this->em->getRepository(AdvertisementEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No advertisement found for id ' . $id);
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
     * delete advertisement
     * 
     * @param int $id
     * 
     * @return AdvertisementEntity
     * 
     * @throws \OutOfRangeException
     */
    public function delete(int $id): AdvertisementEntity
    {
        $search = $this->em->getRepository(AdvertisementEntity::class)->find($id);

        if (!$search) {
            throw new \OutOfRangeException('No advertisement found for id ' . $id);
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
        $report = $this->findBy([
            'active' => true
        ]);

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
            throw new \OutOfRangeException('No user found for advertisement');
        }

        $report = $user->getAdvertisement()->toArray();

        return $report;
    }
}
