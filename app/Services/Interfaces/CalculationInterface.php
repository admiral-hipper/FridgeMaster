<?php

namespace App\Services\Interfaces;

interface CalculationInterface
{
    /**
     * Method for getting count of spare blocks 
     * @return int Returns needed for given volume blocks
     */
    public function blocks();
    /**
     * Method for counting price for renting needed blocks
     * @return float|int Returns price for rent needed blocks for volume
     */
    public function price();
    /**
     * Method for getting number of days between start and end renting
     * @return int Returns days between start and end point of booking
     */
    public function rent_days(): int;
}
