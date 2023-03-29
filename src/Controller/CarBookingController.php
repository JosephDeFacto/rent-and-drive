<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Form\CarBookingType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarBookingController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    private CarRepository $carRepository;

    public function __construct(EntityManagerInterface $entityManager, CarRepository $carRepository)
    {
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
    }
    /**
     * @Route("/car/booking/{id<\d+>}", name="app_car_booking", methods={"GET", "POST"})
     */
    public function index(Request $request, Car $car): Response
    {
        $booking = new Booking();

        $form = $this->createForm(CarBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setCar($this->carRepository->find($car));
            $booking->setPickUpDate($form->get('pickUpDate')->getData());
            $booking->setReturnDate($form->get('returnDate')->getData());
            $booking->setDriverAge($form->get('driverAge')->getData());
            $booking->setDriverLicenseNumber($form->get('driverLicenseNumber')->getData());

            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            $this->addFlash('success', 'Car successfully booked!');

            return $this->redirectToRoute('app_cars');
        }

        return $this->render('car_booking/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
