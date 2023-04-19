<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackageRepository::class)
 */
class Package
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=PackageOptions::class, mappedBy="package")
     */
    private $packageOptions;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="package")
     */
    private $bookings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $distance;

    public function __construct()
    {
        $this->packageOptions = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, PackageOptions>
     */
    public function getPackageOptions(): Collection
    {
        return $this->packageOptions;
    }

    public function addPackageOption(PackageOptions $packageOption): self
    {
        if (!$this->packageOptions->contains($packageOption)) {
            $this->packageOptions[] = $packageOption;
            $packageOption->setPackage($this);
        }

        return $this;
    }

    public function removePackageOption(PackageOptions $packageOption): self
    {
        if ($this->packageOptions->removeElement($packageOption)) {
            // set the owning side to null (unless already changed)
            if ($packageOption->getPackage() === $this) {
                $packageOption->setPackage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setPackage($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getPackage() === $this) {
                $booking->setPackage(null);
            }
        }

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(?string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
