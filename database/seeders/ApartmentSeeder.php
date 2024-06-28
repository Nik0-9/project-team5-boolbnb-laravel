<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = config('arrayApartments.apartments');
        foreach ($apartments as $apartment) {
            $newApartment = new Apartment();
            $newApartment->name = $apartment['name'];
            $newApartment->slug = Apartment::generateSlug($apartment['name']);
            $newApartment->cover_image = $apartment['cover_image'];
            $newApartment->address = $apartment['address'];
            $newApartment->description = $apartment['description'];
            $newApartment->square_meters = $apartment['square_meters'];
            $newApartment->num_bathrooms = $apartment['num_bathrooms'];
            $newApartment->num_beds = $apartment['num_beds'];
            $newApartment->num_rooms = $apartment['num_rooms'];
            $newApartment->latitude = $apartment['latitude'];
            $newApartment->longitude = $apartment['longitude'];
            $newApartment->visible = $apartment['visible'];
            $newApartment->save(); 
        }
    }
}
