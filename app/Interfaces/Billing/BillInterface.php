<?php
namespace App\Interfaces\Billing;
use Illuminate\Support\Collection;

interface BillInterface{
    public function information():Collection;
}
?>