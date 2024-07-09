<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'sponsor_id' => 'required|exists:sponsors,id',

            'duration' => 'required|integer',

            'price' => 'required|numeric',

        ];
    }
}