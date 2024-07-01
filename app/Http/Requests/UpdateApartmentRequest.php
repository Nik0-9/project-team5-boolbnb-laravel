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
        return [
            'name' => 'required|string|max:200',
            'cover_image' => 'file|image',
            'street' => 'required|string|max:150|min:5',
            'street_number' => 'required|string|min:1',
            'city' => 'required|string|max:150',
            'cap' => 'required|numeric',
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
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => 'Il nome non può avere più di :max caratteri',
            'cover_image.file' => 'Il file caricato non è una immagine',
            'cover_image.image' => 'Il file caricato non è una immagine',
            'street.required' => 'La via è obbligatoria',
            'street.max' => 'La via non può avere più di :max caratteri',
            'street.min' => 'La via deve avere più di :min caratteri',
            'street_number.required' => 'Il numero civico è obbligatorio',
            'street_number.min' => 'Il numero civico è minore di :min ',
            'city.required' => 'La città è obbligatoria',
            'city.max' => 'La città non può avere più di :max caratteri',
            'cap.required' => 'Il cap è obbligatorio',
            'cap.numeric' => 'Il cap deve essere un valore numerico',
            'description.min' => 'La descrizione non può avere meno di :min caratteri',
            'square_meters.required' => 'I metri quadrati sono obbligatori',
            'square_meters.min' => 'I metri quadrati non possono essere minori di :min metri quadrati',
            'num_bathrooms.required' => 'Il numero di bagni sono obbligatori',
            'num_bathrooms.min' => 'Il numero di bagni non è minore di :min',
            'num_beds.required' => 'Il numero di letti sono obbligatori',
            'num_beds.min' => 'Il numero di letti non può essere minore di :min',
            'num_rooms.required' => 'Il numero di stanze sono obbligatori',
            'num_rooms.min' => 'Il numero di stanze non è minore di :min',
        ];
    }
}