<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Service;

class ApartmentController extends Controller
{
    public function index()
    {
        $currentDate = now();

        $data = Apartment::whereHas('sponsors', function ($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate);
        })->with([
                    'sponsors' => function ($query) use ($currentDate) {
                        $query->where('end_date', '>', $currentDate);
                    }
                ])
            ->with('services', 'images')
            ->withCount('views')
            ->withCount('messages')
            ->get();
        $base = Apartment::whereDoesntHave('sponsors')
            ->with('services', 'images')
            ->withCount('views')
            ->withCount('messages')
            ->get();
            $all = $data->merge($base);
        return response()->json([
            'success' => true,
            'results' => $all
        ]);
    }
    public function getSponsoredApartments()
    {
        $currentDate = now();

        $sponsoredApartments = Apartment::whereHas('sponsors', function ($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate);
        })->with([
                    'sponsors' => function ($query) use ($currentDate) {
                        $query->where('end_date', '>', $currentDate);
                    }
                ])
            ->withCount('views')
            ->withCount('messages')
            ->get();

        return response()->json([
            'success' => true,
            'results' => $sponsoredApartments
        ]);
    }
    public function getBaseApartments()
    {
        $sponsoredApartments = Apartment::whereDoesntHave('sponsors')
            ->withCount('views')
            ->withCount('messages')
            ->get();

        return response()->json([
            'success' => true,
            'results' => $sponsoredApartments
        ]);
    }

    public function search(Request $request)
    {

        $currentDate = now();
        $latitude = $request->latitude;
        $longitude = $request->longitude;


        $radius = 20;

        $baseQuery = Apartment::selectRaw("apartments.*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
            ->having('distance', '<=', $radius)->where('visible', '1')->orderBy('distance', 'asc');

        $apartmentsSponsored = (clone $baseQuery)->whereHas('sponsors', function ($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate);
        })->with([
                    'sponsors' => function ($query) use ($currentDate) {
                        $query->where('end_date', '>', $currentDate);
                    }
                ])
            ->whereHas('sponsors')
            ->withCount('views')
            ->withCount('messages')
            ->get();

        $apartmentsBase = (clone $baseQuery)
            ->whereDoesntHave('sponsors')
            ->withCount('views')
            ->withCount('messages')
            ->get();

        $services = Service::all();

        return response()->json([
            'success' => true,
            'results' => [
                'sponsored' => $apartmentsSponsored,
                'base' => $apartmentsBase,
                'services' => $services
            ]
        ]);
    }

    public function searchAdvanced($address, $latitude, $longitude, $serviceIds, $rooms, $beds, $range)
    {
        // Imposta il raggio di ricerca
        $radius = $range;

        // Base query per cercare appartamenti entro un certo raggio
        $baseQuery = Apartment::selectRaw("apartments.*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
            ->having('distance', '<=', $radius)->where('visible', '1')->orderBy('distance', 'asc');
        ;

        // Filtra per servizi, se forniti
        if ($serviceIds === 'all') {
            $baseQuery->whereHas('services');
        } else {
            $serviceIdsArray = explode(',', $serviceIds);
            foreach ($serviceIdsArray as $serviceId) {
                $baseQuery->whereHas('services', function ($query) use ($serviceId) {
                    $query->where('service_id', $serviceId);
                });
            }
        }

        // Filtra per numero di camere, se specificato
        if ($rooms === 'all') {
            $baseQuery->where('num_rooms', '>', 0);
        } elseif ($rooms == 5) {
            $baseQuery->where('num_rooms', '>=', 5);
        } else {
            $baseQuery->where('num_rooms', '=', $rooms);
        }

        // Filtra per numero di letti, se specificato
        if ($beds === 'all') {
            $baseQuery->where('num_beds', '>', 0);
        } elseif ($beds == 5) {
            $baseQuery->where('num_beds', '>=', 5);
        } else {
            $baseQuery->where('num_beds', '=', $beds);
        }

        $currentDate = now();
        // Separare gli appartamenti sponsorizzati da quelli non sponsorizzati
        $apartmentsSponsored = (clone $baseQuery)->whereHas('sponsors', function ($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate);
        })->with([
                    'sponsors' => function ($query) use ($currentDate) {
                        $query->where('end_date', '>', $currentDate);
                    }
                ])
            ->whereHas('sponsors')
            ->get();

        $apartmentsBase = (clone $baseQuery)
            ->whereDoesntHave('sponsors')
            ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'sponsored' => $apartmentsSponsored,
                'base' => $apartmentsBase,
            ]
        ]);
    }



    public function show($slug)
    {
        $apartment = Apartment::with('images', 'services')

            ->where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
