<?php
declare(strict_types = 1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subscription Entity
 *
 * @ORM\Table(name="subscriptions")
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SubscriptionEntity
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="Title should not be blank")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Description should not be blank")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank(message="Price should not be blank")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\AdvertisementEntity")
     * @ORM\JoinColumn(name="advertisement_id", referencedColumnName="id")
     */
    private $advertisement;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\UserEntity")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active", type="boolean")
     * @Assert\Type("bool")
     */
    private $active;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validity", type="datetime")
     * @Assert\Type("\DateTime")
     */
    private $validity;
    
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set active
     *
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the value of advertisement
     */ 
    public function getAdvertisement()
    {
        return $this->advertisement;
    }

    /**
     * Set the value of advertisement
     *
     * @return  self
     */ 
    public function setAdvertisement($advertisement)
    {
        $this->advertisement = $advertisement;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     *
     * @return  self
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of validity
     *
     * @return  \DateTime
     */ 
    public function getValidity()
    {
        return $this->validity;
    }

    /**
     * Set the value of validity
     *
     * @param  \DateTime  $validity
     *
     * @return  self
     */ 
    public function setValidity(\DateTime $validity)
    {
        $this->validity = $validity;
    }
}
