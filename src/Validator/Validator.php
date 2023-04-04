<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private array $constraints = [];
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    public function addConstraints(string $field, array $constraints): void
    {
        $this->constraints[$field] = $constraints;
    }

    public function validateParams(array $data = []): array
    {
        $collection = new Assert\Collection($this->constraints);
        $violations = $this->validator->validate($data, $collection);

        $errors = [];


        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }

}