<?php

namespace App\Validator;

class BookingValidator
{

    /**
     * @throws \Exception
     */
    public function validatePackage($package)
    {
        if (!$package) {
            throw new \Exception('Please select a package.');
        }
    }

    /**
     * @throws \Exception
     */
    public function validateMonths($months)
    {

        $hasMonth = false;

        foreach ($months as $month) {
            if ($month) {
                $hasMonth = true;
                break;
            }
        }
        if (!$hasMonth) {
            throw new \Exception('Please select number of months.');
        }
    }

    public function getBookingDuration(array $months, $bookingDuration): int
    {
        foreach ($months as $month) {
            if ($month != "") {
                $bookingDuration += (int)$month;
            }
        }

        return $bookingDuration;
    }
}