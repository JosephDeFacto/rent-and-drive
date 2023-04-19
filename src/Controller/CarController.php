<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use App\Repository\PackageRepository;
use App\Repository\VehicleTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{

    private CarRepository $carRepository;
    private VehicleTypeRepository $vehicleTypeRepository;
    private BrandRepository $brandRepository;
    private PackageRepository $packageRepository;



    public function __construct(CarRepository $carRepository, BrandRepository $brandRepository, VehicleTypeRepository $vehicleTypeRepository, PackageRepository $packageRepository)
    {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->packageRepository = $packageRepository;
    }

    /**
     * @Route("/cars", name="app_cars")
     */
    public function index(): Response
    {
        $cars = $this->carRepository->findAll();

        $vehicleTypes = $this->vehicleTypeRepository->findAll();

        $brands = $this->brandRepository->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'types' => $vehicleTypes,
            'brands' => $brands,
        ]);
    }

    /**
     * @Route("/show/{id}", name="car_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $car = $this->carRepository->find($id);

        $packages = $this->packageRepository->findAll();

        return $this->render('car/show.html.twig', ['carInfo' => $car, 'packages' => $packages]);
    }

    /**
     * @Route("/cars/clear-filters/", name="clear_filter")
     */
    public function clearFilters(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $url = $this->generateUrl('app_cars');
        return $this->redirect($url);
    }
}