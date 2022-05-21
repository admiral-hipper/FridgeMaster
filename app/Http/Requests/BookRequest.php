<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "location_slug"=>"required|string",
            "temperature"=>"required|numeric",
            "start_rent"=>"required|date|after:yesterday|before:end_rent",
            "end_rent"=>"required|date",
            "volume"=>"required|numeric|min:0.001"
        ];
    }
    protected function prepareForValidation()
    {
        if(is_string($this->start_rent)&&is_string($this->end_rent))
        $this->merge([
            'start_rent' => Carbon::createFromFormat("d/m/Y",$this->start_rent),
            'end_rent'=>Carbon::createFromFormat("d/m/Y",$this->end_rent)
        ]);
    }
}
