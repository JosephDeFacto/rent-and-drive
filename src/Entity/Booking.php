<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $pickUpDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $returnDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $driverAge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $driverLicenseNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="bookings")
     */
    private $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPickUpDate(): ?\DateTimeInterface
    {
        return $this->pickUpDate;
    }

    public function setPickUpDate(\DateTimeInterface $pickUpDate): self
    {
        $this->pickUpDate = $pickUpDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getDriverAge(): ?int
    {
        return $this->driverAge;
    }

    public function setDriverAge(int $driverAge): self
    {
        $this->driverAge = $driverAge;

        return $this;
    }

    public function getDriverLicenseNumber(): ?int
    {
        return $this->driverLicenseNumber;
    }

    public function setDriverLicenseNumber(?int $driverLicenseNumber): self
    {
        $this->driverLicenseNumber = $driverLicenseNumber;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

}
