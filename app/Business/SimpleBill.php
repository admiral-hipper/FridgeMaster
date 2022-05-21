<?php
namespace App\Business;

use App\Interfaces\Billing\BillInterface;
use App\Models\Locations;
use App\Services\Interfaces\CalculationInterface;
use App\Services\SimpleCalculation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;

class SimpleBill implements BillInterface{
    private CalculationInterface $calculation;
    private EloquentBuilder $location;
    private array $resource;
    public function __construct(array $request)
    {  
       $this->resource=$request;
       $this->location=Locations::where('slug','=',$request['location_slug']);
       $this->calculation=new SimpleCalculation($request,$this->spareBlocks()->count());
    }
    public function information():Collection{  
        $result=collect([
            "price"=>$this->calculation->price(),
            "term"=>$this->calculation->rent_days(),
            "blocks_count"=>$this->calculation->blocks(),
            "blocks"=>$this->spareBlocks()->take($this->calculation->blocks())->get(),
            "location"=>$this->location->get()[0],
        ]);
        return $result;
    }
    protected function spareBlocks(){
        if(!count($this->location->get()))
        throw new HttpResponseException(response()->json(["message"=>"This location doesn't exist"],404));
        return $this->location->get()[0]->blocks()
        ->temperature($this->resource['temperature'])->term($this->resource['start_rent'], $this->resource['end_rent']);
    }
}
