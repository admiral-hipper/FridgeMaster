<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            "temperature" => "required_with_all:volume|numeric",
            "start_rent" => "date|after:yesterday|before:end_rent",
            "end_rent" => "date",
            "volume" => "required_with_all:temperaature|numeric"
        ];
    }
    protected function prepareForValidation()
    {
        if (is_string($this->start_rent) && is_string($this->end_rent))
            $this->merge([
                'start_rent' => Carbon::createFromFormat("d/m/Y", $this->start_rent),
                'end_rent' => Carbon::createFromFormat("d/m/Y", $this->end_rent)
            ]);
    }
}
