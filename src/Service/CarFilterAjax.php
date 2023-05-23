<?php

namespace App\Service;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Requests\RequestDataExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CarFilterAjax
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function filterCars(Request $request, array $criteria): JsonResponse
    {

        if ($request->isXmlHttpRequest()) {
            $cars = $this->carRepository->findBy($criteria);
        }

        $response = [];
        if (isset($cars)) {
            foreach ($cars as $car) {
                $response[] = $this->responseData($car);
            }
        }

        return new JsonResponse($response);
    }

    public function responseData(Car $car): array
    {
        return [
            'id' => $car->getId(),
            'name' => $car->getName(),
            'model' => $car->getModel(),
            'imagePath' => $car->getImagePath(),
            'availability' => $car->getFeature()->getAvailabilityStatus(),
        ];
    }
}