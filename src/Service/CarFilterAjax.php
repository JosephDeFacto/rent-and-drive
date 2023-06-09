<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Response\CarResponseTransformerDataTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CarFilterAjax
{
    private CarRepository $carRepository;
    private CarResponseTransformerDataTransformer $transformer;

    public function __construct(CarRepository $carRepository, CarResponseTransformerDataTransformer $transformer)
    {
        $this->carRepository = $carRepository;
        $this->transformer = $transformer;
    }


    public function filterCars(Request $request, array $criteria): JsonResponse
    {

        if ($request->isXmlHttpRequest()) {
            $cars = $this->carRepository->findBy($criteria);
        }

        $response = [];
        if (isset($cars)) {
            foreach ($cars as $car) {
                $response[] = $this->transformer->responseData($car);
            }
        }

        if ($response) {
            return new JsonResponse($response, 200);
        }

        return new JsonResponse(['message' => 'Car currently does not exists', 404]);
    }

}