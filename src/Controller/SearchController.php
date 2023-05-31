<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Request\RequestDataExtractor;
use App\Response\CarResponseTransformerDataTransformer;
use App\Service\CarSearchAjax;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private CarRepository $carRepository;
    private CarResponseTransformerDataTransformer $transformer;
    private RequestDataExtractor $extractor;
    private CarSearchAjax $carSearchAjax;

    public function __construct(CarRepository $carRepository, CarResponseTransformerDataTransformer $transformer, RequestDataExtractor $extractor, CarSearchAjax $carSearchAjax)
    {
        $this->carRepository = $carRepository;
        $this->transformer = $transformer;
        $this->extractor = $extractor;
        $this->carSearchAjax = $carSearchAjax;
    }

    /**
     * @Route("/search", name="app_search", methods={"GET"})
     * @throws Exception
     */
    public function search(Request $request): Response
    {
        $searchQuery = $this->extractor->getRequestValue('q');

        return $this->carSearchAjax->searchCars($request, $searchQuery);

    }
}
