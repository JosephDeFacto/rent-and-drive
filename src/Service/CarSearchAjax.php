<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Response\CarResponseTransformerDataTransformer;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CarSearchAjax
{
    private CarRepository $carRepository;

    private CarResponseTransformerDataTransformer $transformer;

    public function __construct(CarRepository $carRepository, CarResponseTransformerDataTransformer $transformer)
    {
        $this->carRepository = $carRepository;
        $this->transformer = $transformer;
    }

    /**
     * @throws Exception
     */
    public function searchCars(Request $request, $criteria): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $searchedCars = $this->carRepository->search($criteria);
        }

        $response = [];
        if (isset($searchedCars)) {
            foreach ($searchedCars as $car) {
                if (is_array($car)) {
                    $car = $this->carRepository->find($car['id']);
                }

                $response[] = $this->transformer->responseData($car);

            }
        }

        if ($response) {
            return new JsonResponse($response, 200);
        }

        return new JsonResponse(['message' => 'Searching results not found'], 404);
    }
}