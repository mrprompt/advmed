<?php
declare(strict_types = 1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Phone Entity
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PhoneEntity
{
    use Traits\Base;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=10)
     * @Assert\NotBlank(message="Number should not be blank")
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\Type("\DateTime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\Type("\DateTime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\UserEntity", inversedBy="phone")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->createdAt = new DateTime;
        $this->updatedAt = new DateTime;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}
