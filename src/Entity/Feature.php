<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeatureRepository::class)
 */
class Feature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $availabilityStatus;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $availabilityDescription;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $performance;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $transmission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvailabilityStatus(): ?string
    {
        return $this->availabilityStatus;
    }

    public function setAvailabilityStatus(?string $availabilityStatus): self
    {
        $this->availabilityStatus = $availabilityStatus;

        return $this;
    }

    public function getAvailabilityDescription(): ?string
    {
        return $this->availabilityDescription;
    }

    public function setAvailabilityDescription(?string $availabilityDescription): self
    {
        $this->availabilityDescription = $availabilityDescription;

        return $this;
    }

    public function getPerformance(): ?string
    {
        return $this->performance;
    }

    public function setPerformance(?string $performance): self
    {
        $this->performance = $performance;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(?string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }
}
