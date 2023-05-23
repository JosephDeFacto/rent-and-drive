<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestDataExtractor
{
    private RequestStack $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function getRequestValue(string $param)
    {
        return $this->request->getCurrentRequest()->get($param);
    }

    public function getRequestMultipleValues($params)
    {
        return $this->request->getCurrentRequest()->get($params);
    }
}