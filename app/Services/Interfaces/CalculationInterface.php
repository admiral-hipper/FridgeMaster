<?php
namespace App\Services\Interfaces;
interface CalculationInterface{
    /**
     * Get needed for given volume blocks
     * @return int
     */
    public function blocks();
    /**
     * Returns price for rent needed blocks for volume
     */
    public function price();
    /**
     * Returns days between start and end point of booking
     * @return int
     */
    public function rent_days():int;
}
