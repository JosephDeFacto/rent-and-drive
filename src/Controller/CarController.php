<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * @Route("/cars", name="app_cars")
     */
    public function index(Request $request): Response
    {

        $cars = $this->carRepository->findAll();

        return $this->render('car/index.html.twig', ['cars' => $cars]);
    }

    /**
     * @Route("/show/{id<\d+>}", name="car_show", methods={"GET"})
     */
    public function show(Car $car): Response
    {
        $car = $this->carRepository->find($car);

        return $this->render('car/show.html.twig', ['carInfo' => $car]);
    }
}
