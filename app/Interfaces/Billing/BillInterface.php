<?php
namespace App\Interfaces\Billing;
use Illuminate\Support\Collection;

interface BillInterface{
    /**
     * Select and count all information about order
     * @return array
     */
    public function information():Collection;
}
?>