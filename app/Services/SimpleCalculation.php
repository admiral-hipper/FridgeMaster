<?php

namespace App\Services;

use App\Models\Locations;
use App\Models\Prices;
use App\Services\Interfaces\CalculationInterface;
use DateTimeInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

class SimpleCalculation implements CalculationInterface
{
    private DateTimeInterface $start_rent, $end_rent;
    private array $resource;

    public function __construct(array $resource, $spare)
    {
        $this->resource = $resource;
        $this->spare = $spare;
    }
    public function price()
    {
        return Prices::all()->last()->price * $this->spare * $this->rent_days();
    }
    public function blocks()
    {
        $needed = ceil($this->resource['volume'] / 2);
        if ($this->spare < $needed)
            throw new HttpResponseException(response()->json([
                "success" => false,
                "enough_blocks" => false,
                "message" => "We don't have enough blocks in this period",
            ], 400));
        return $needed;
    }
    public function rent_days(): int
    {
        $days = date_diff($this->resource['start_rent'], $this->resource['end_rent'])->format("%a");
        if ($days > 24)
            throw new HttpResponseException(response()->json([
                "message" => "You cannot book blocks more than on 24 days",
                "success" => false
            ], 400));
        return $days;
    }
}
