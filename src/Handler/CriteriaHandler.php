<?php

namespace App\Handler;

use App\Request\RequestDataExtractor;

class CriteriaHandler
{
    private RequestDataExtractor $extractor;

    public function __construct(RequestDataExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    public function paramsCriteria(): array
    {
        return [
            'vehicleType' => $this->extractor->getRequestValue('vehicleType'),
            'brand' => $this->extractor->getRequestValue('brand'),
        ];
    }
    public function handleCriteria(array $params): array
    {
        $criteria = [];

        foreach ($params as $key => $value) {
            if ($value) {
                $criteria[$key] = $value;
            }
        }

        return $criteria;
    }
}