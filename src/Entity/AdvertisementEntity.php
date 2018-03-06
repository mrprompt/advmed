<?php
declare(strict_types = 1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Advertisement Entity
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 *
 * @ORM\Table(name="advertisements")
 * @ORM\Entity(repositoryClass="App\Repository\AdvertisementRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AdvertisementEntity
{
    use Traits\Base;

    const PERIOD = [
        'daily' => 3.50, 
        'week' => 5.50,
        'month' => 10.01
    ];
    
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
     * @var string
     *
     * @ORM\Column(name="period", type="string", length=11)
     * @Assert\Choice(
     *     choices = { "daily", "week", "month" },
     *     message = "Choose a valid period."
     * )
     */
    private $period;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", options={"default": true})
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
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new DateTime;
        $this->updatedAt = new DateTime;
    }

    /**
     * Get the value of id
     *
     * @return int
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * Get the value of period
     *
     * @return string
     */ 
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * Set the value of period
     *
     * @param string $period
     */ 
    public function setPeriod(string $period)
    {
        if (!array_key_exists($period, self::PERIOD)) {
            throw new \TypeError('Invalid period ' . $period);
        }
        
        $this->period = $period;
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
