<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreViewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assicurati di personalizzare l'autorizzazione secondo le tue logiche di accesso
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'apartment_id' => 'required|exists:apartments,id', // L'ID dell'appartamento deve esistere nella tabella apartments
        ];
    }
}