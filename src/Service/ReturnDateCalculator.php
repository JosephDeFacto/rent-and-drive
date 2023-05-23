<?php

namespace App\Service;

class ReturnDateCalculator
{
    public function calculateReturnDate(\DateTimeInterface $pickUpDate, int $bookingDuration): \DateTimeInterface
    {
        $returnDate = clone $pickUpDate;
        $returnDate->add(new \DateInterval('P' . $bookingDuration . 'M'));

        return $returnDate;
    }
}