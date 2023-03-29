<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\VehicleType;
use App\Repository\CarRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


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
    public function index(Request $request, ManagerRegistry $registry): ?Response
    {
        $cars = $registry->getRepository(Car::class)->findAll();

        $vehicleTypes = $registry->getRepository(VehicleType::class)->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'types' => $vehicleTypes,
        ]);
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
     * @Route("/cars/filter/", name="car_filter")
     */
    public function filter(Request $request, ManagerRegistry $registry): Response
    {
        $vehicleType = $request->get('vehicle_type_id');


        $cars = $registry->getRepository(Car::class)->findBy(['vehicleType' => $vehicleType]);

        $carArr = [];
        foreach ($cars as $car) {
            $carArr[] = [
                'id' => $car->getId(),
                'name' => $car->getName(),
                'model' => $car->getModel(),
                'imagePath' => $car->getImagePath(),
            ];
        }

        $response = new JsonResponse();
        $response->setData($carArr);

        return $response;
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
