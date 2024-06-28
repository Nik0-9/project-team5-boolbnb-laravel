<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return
            [
                'name' => 'required|string|max:200',
                'cover_image' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'description' => 'nullable|string|min:20',
                'square_meters' => 'required|integer|min:20',
                'num_bathrooms' => 'required|integer|min:1',
                'num_beds' => 'required|integer|min:1',
                'num_rooms' => 'required|integer|min:1',
            ];
    }
    public function messages()
    {

        return [
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => 'Il nome non può avere più di :max caratteri',
            'cover_image.required' => 'L\'immagine di copertina è obbligatoria',
            'cover_image.max' => 'L\'immagine di copertina non può avere più di :max caratteri',
            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.max' => 'L\'indirizzo non può avere più di :max caratteri',
            'description.min' => 'La descrizione non può avere meno di :min caratteri',
            'square_meters.required' => 'I metri quadrati sono obbligatori',
            'square_meters.min' => 'I metri quadrati non possono essere minori di :min metri quadrati',
            'num_bathrooms.required' => 'Il numero di bagni sono obbligatori',
            'num_bathrooms.min' => 'Il numero di bagni è minore di :min',
            'num_beds.required' => 'Il numero di letti sono obbligatori',
            'num_beds.min' => 'Il numero di letti è minore di :min',
            'num_rooms.required' => 'Il numero di stanze sono obbligatori',
            'num_rooms.min' => 'Il numero di stanze è minore di :min',
        ];
    }
}
