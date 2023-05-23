<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingProcessor
{
    private EntityManagerInterface $entityManager;
    private CarRepository $carRepository;
    private PackageRepository $packageRepository;
    private ReturnDateCalculator $dateCalculator;

    public function __construct(EntityManagerInterface $entityManager, CarRepository $carRepository, ReturnDateCalculator $dateCalculator, PackageRepository $packageRepository)
    {
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
        $this->dateCalculator = $dateCalculator;
        $this->packageRepository = $packageRepository;
    }
    public function processBooking($booking, $carId, $bookingDuration, $selectedPackage, $user)
    {
        $booking->setUser($user);
        $booking->setCar($this->carRepository->find($carId));
        $booking->setPickUpDate($booking->getPickUpDate());

        $returnDate = $this->dateCalculator->calculateReturnDate($booking->getPickUpDate(), $bookingDuration);
        $booking->setReturnDate($returnDate);

        $booking->setDriverAge($booking->getDriverAge());
        $booking->setDriverLicenseNumber($booking->getDriverLicenseNumber());
        $booking->setPackage($selectedPackage);
        $booking->setBookingDuration($bookingDuration);
        $booking->setTotalPrice($this->calculateTotalPrice($selectedPackage, $bookingDuration));

        $this->entityManager->persist($booking);
        $this->entityManager->flush();
    }

    public function calculateTotalPrice($selectedPackage, $bookingDuration)
    {
        $package = $this->packageRepository->find($selectedPackage);
        return $package->getPrice() * $bookingDuration;
    }
}