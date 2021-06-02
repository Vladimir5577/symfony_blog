<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

// for validation
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="giver_id" , referencedColumnName="id")
     */
    private User $giver;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="recipient_id" , referencedColumnName="id")
     */
    private User $recipient;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $rate;

    public function __construct(User $giver, User $recipient, int $rate)
    {
        $this->giver = $giver;
        $this->recipient = $recipient;
        $this->rate = $rate;
    }

    // validation
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('rate', new NotBlank());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserGiverId(): User
    {
        return $this->giver;
    }

    public function setUserGiverId(User $giver): self
    {
        $this->giver = $giver;

        return $this;
    }

    public function getUserRecepientId(): User
    {
        return $this->recipient;
    }

    public function setUserRecepientId(User $recipient): self
    {
        $this->$recipient = $recipient;

        return $this;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
