<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterApiController extends AbstractController
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }
    /**
     * @Route("/filter", name="filter_api")
     */
    public function filter(Request $request): Response
    {

        $vehicleType = $request->get('vehicleType');

        $brand = $request->get('brand');

        $criteria = [];

        if ($vehicleType) {
            $criteria['vehicleType'] = $vehicleType;
        } else if ($brand) {
            $criteria['brand'] = $brand;
        }

        $responseData = [];

        if ($request->isXmlHttpRequest()) {
            $cars = $this->carRepository->findBy($criteria);
        }


        if (isset($cars)) {
            foreach ($cars as $car) {
                $responseData[] = [
                    'id' => $car->getId(),
                    'name' => $car->getName(),
                    'model' => $car->getModel(),
                    'imagePath' => $car->getImagePath(),
                    'availability' => $car->getFeature()->getAvailabilityStatus(),
                ];
            }
        }


        return new JsonResponse($responseData);
    }
}
