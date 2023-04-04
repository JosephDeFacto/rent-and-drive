<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\VehicleType;
use App\Repository\CarRepository;
use App\Validator\Validator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarController extends AbstractController
{
    private CarRepository $carRepository;
    private Validator $validator;


    public function __construct(CarRepository $carRepository, Validator $validator)
    {
        $this->carRepository = $carRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/cars", name="app_cars")
     */
    public function index(Request $request, ManagerRegistry $registry, ValidatorInterface $validator): ?Response
    {
        $vehicleType = $request->get('vehicleType');

        $brand = $request->get('brand');

        $criteria = [];

        if ($vehicleType) {
            $criteria['vehicleType'] = $vehicleType;
        } else if ($brand) {
            $criteria['brand'] = $brand;
        }

        $vehicleTypes = $registry->getRepository(VehicleType::class)->findAll();
        $brands = $registry->getRepository(Brand::class)->findAll();

        if ($request->isXmlHttpRequest()) {

            if ($vehicleType || $brand) {
                $cars = $this->carRepository->findBy($criteria);
            } else {
                $cars = $this->carRepository->findAll();
            }

            $responseData = [];
            if (isset($cars)) {
                foreach ($cars as $car) {
                    $responseData[] = [
                        'id' => $car->getId(),
                        'name' => $car->getName(),
                        'model' => $car->getModel(),
                        'imagePath' => $car->getImagePath(),
                    ];
                }
            }

            return new JsonResponse($responseData);
        } else {

            $allCars = $this->carRepository->findAll();

            if ($vehicleType || $brand) {
                $cars = $this->carRepository->findBy($criteria);
            } else {
                $cars = $allCars;
            }

            return $this->render('car/index.html.twig', [
                'cars' => $cars,
                'types' => $vehicleTypes,
                'brands' => $brands,
            ]);
        }
    }

    /**
     * @Route("/show/{id}", name="car_show", methods={"GET"})
     */
    public function show(Car $car): Response
    {
        $car = $this->carRepository->find($car);

        return $this->render('car/show.html.twig', ['carInfo' => $car]);
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