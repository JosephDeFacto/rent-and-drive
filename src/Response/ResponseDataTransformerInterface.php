<?php

namespace App\Response;

interface ResponseDataTransformerInterface
{
    public function responseData($obj): array;
}