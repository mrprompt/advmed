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
        'daily' => 3.33, 
        'week' => 5.00,
        'month' => 10.00
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
     * @ORM\Column(name="period", type="string", length=11)
     * @Assert\Choice(
     *     choices = { "daily", "week", "month" },
     *     message = "Choose a valid period."
     * )
     */
    private $period;

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
    public function getId(): int
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
    public function getName():string
    {
        return $this->name;
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
}
