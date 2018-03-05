<?php
declare(strict_types = 1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User Entity
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *      fields={"email"},
 *      message="An user with this email is already registered"
 * )
 */
class UserEntity
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Name should not be blank")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email(message="Email is invalid")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank(message="Password should not be blank")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\AddressEntity", mappedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\PhoneEntity", mappedBy="user", cascade={"persist", "remove"})
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\SubscriptionEntity", mappedBy="user", cascade={"persist", "remove"})
     */
    private $subscription;

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
     * constructor
     */
    public function __construct()
    {
        $this->address = new ArrayCollection;
        $this->phone = new ArrayCollection;
        $this->subscription = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add address
     *
     * @return  self
     */ 
    public function addAddress(AddressEntity $address)
    {
        $this->address->add($address);
    }

    /**
     * Get phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add phone
     *
     * @return  self
     */ 
    public function addPhone(PhoneEntity $phone)
    {
        $this->phone->add($phone);
    }

    /**
     * Get subscription
     */ 
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Add subscription
     *
     * @return  self
     */ 
    public function addSubscription(SubscriptionEntity $subscription)
    {
        $this->subscription->add($subscription);
    }
}
