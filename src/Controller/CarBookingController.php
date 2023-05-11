<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Package;
use App\Form\CarBookingType;
use App\Repository\CarRepository;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarBookingController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    private CarRepository $carRepository;

    private PackageRepository $packageRepository;

    public function __construct(EntityManagerInterface $entityManager, CarRepository $carRepository, PackageRepository $packageRepository)
    {
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
        $this->packageRepository = $packageRepository;
    }
    /**
     * @Route("/car/booking/{id<\d+>}", name="app_car_booking", methods={"GET", "POST"})
     */
    public function index(Request $request, Car $car): Response
    {
        $package = $request->query->get('package');

        $months = $request->query->get('months', []);

        $bookingDuration = 0;
        if (isset($months)) {
            foreach ($months as $month) {
                if ($month !== "") {
                    $bookingDuration += (int)$month;
                }
            }
        }

        if (!$package) {
            $this->addFlash('warning', 'Please select package');
            return $this->redirectToRoute('car_show', ['id' => $car->getId()]);
        }
        $selectedPackage = $this->packageRepository->find($package);

        $booking = new Booking();

        $form = $this->createForm(CarBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $booking->setUser($this->getUser());
            $booking->setCar($this->carRepository->find($car));
            $booking->setPickUpDate($form->get('pickUpDate')->getData());
            //$booking->setReturnDate($form->get('returnDate')->getData());

            $returnDate = clone $booking->getPickUpDate();
            $returnDate->add(new \DateInterval('P' . $bookingDuration . 'M'));

            $booking->setReturnDate($returnDate);

            $booking->setDriverAge($form->get('driverAge')->getData());
            $booking->setDriverLicenseNumber($form->get('driverLicenseNumber')->getData());
            $booking->setPackage($selectedPackage);
            $booking->setBookingDuration($bookingDuration);
            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            $this->addFlash('success', 'Car successfully booked!');
            return $this->redirectToRoute('app_cars');
        }

        return $this->render('car_booking/index.html.twig', [
            'form' => $form->createView(),
            'carAttributes' => $car->getCarAttributes(),
            'selectedPackage' => $selectedPackage,
            'bookingDuration' => $bookingDuration,
        ]);
    }

}
