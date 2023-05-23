<?php

namespace App\Controller;

use App\Handler\CriteriaHandler;
use App\Service\CarFilterAjax;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterApiController extends AbstractController
{
    private CriteriaHandler $criteriaHandler;
    private CarFilterAjax $carFilterAjax;

    public function __construct(CriteriaHandler $criteriaHandler, CarFilterAjax $carFilterAjax)
    {
        $this->criteriaHandler = $criteriaHandler;
        $this->carFilterAjax = $carFilterAjax;
    }
    /**
     * @Route("/filter", name="filter_api")
     */
    public function filter(Request $request): Response
    {
        $params = $this->criteriaHandler->paramsCriteria();

        $criteria = $this->criteriaHandler->handleCriteria($params);

        return $this->carFilterAjax->filterCars($request, $criteria);
    }
}
