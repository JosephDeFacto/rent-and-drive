<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Form\CarBookingType;
use App\Repository\PackageRepository;
use App\Request\RequestDataExtractor;
use App\Service\BookingProcessor;
use App\Validator\BookingValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarBookingController extends AbstractController
{
    private PackageRepository $packageRepository;
    private RequestDataExtractor $extractor;
    private BookingProcessor $bookingProcessor;

    public function __construct(PackageRepository $packageRepository,
                                RequestDataExtractor $extractor, BookingProcessor $bookingProcessor)
    {
        $this->packageRepository = $packageRepository;
        $this->extractor = $extractor;
        $this->bookingProcessor = $bookingProcessor;}
    /**
     * @Route("/car/booking/{id<\d+>}", name="app_car_booking", methods={"GET", "POST"})
     */
    public function index(Request $request, Car $car, BookingValidator $bookingValidator): Response
    {
        $package = $this->extractor->getRequestValue('package');
        $months = $this->extractor->getRequestMultipleValues('months', []);

        $bookingDuration = $bookingValidator->getBookingDuration($months, 0);

        try {
            $bookingValidator->validatePackage($package);
            $bookingValidator->validateMonths($months);
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());
            return $this->redirectToRoute('car_show', ['id' => $car->getId()]);
        }

        $selectedPackage = $this->packageRepository->find($package);

        $booking = new Booking();

        $form = $this->createForm(CarBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookingProcessor->processBooking($booking, $car->getId(), $bookingDuration, $selectedPackage, $this->getUser());

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
