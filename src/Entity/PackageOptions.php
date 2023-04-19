<?php

namespace App\Entity;

use App\Repository\PackageOptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackageOptionsRepository::class)
 */
class PackageOptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Package::class, inversedBy="packageOptions")
     */
    private $package;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): self
    {
        $this->package = $package;

        return $this;
    }
}
