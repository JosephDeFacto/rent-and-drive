<?php

namespace App\Response;

use App\Entity\Car;

class CarResponseTransformerDataTransformer implements ResponseDataTransformerInterface
{
    public function responseData($obj): array
    {
        if ($obj instanceof Car) {
            return [
                'id' => $obj->getId(),
                'name' => $obj->getName(),
                'model' => $obj->getModel(),
                'imagePath' => $obj->getImagePath(),
                'availability' => $obj->getFeature()->getAvailabilityStatus(),
            ];
        }

        return [];
    }
}