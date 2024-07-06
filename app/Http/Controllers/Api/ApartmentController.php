<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        $data = Apartment::with('images', 'services')->get();
        return response()->json([
            'success' => true,
            'results' => $data
        ]);
    }

    public function getSponsoredApartments()
    {
        $sponsoredApartments = Apartment::whereHas('sponsors')->with('sponsors')->get();

        return response()->json([
            'success' => true,
            'results' => $sponsoredApartments
        ]);
    }
    public function search(string $address, string $latitude, string $longitude)
    {
        // Converti lat e lon da gradi a radianti
        $lat = deg2rad($latitude);
        $lon = deg2rad($longitude);

        // Raggio in km (20 km)
        $radius = 20;

        // Raggio in metri (20 km convertito in metri)


        $baseQuery = Apartment::select('apartments.*')
            ->whereRaw("6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))) <= $radius");

        // Clona la query di base per gli appartamenti sponsorizzati
        $apartmentsSponsored = (clone $baseQuery)
            ->whereHas('sponsors')
            ->get();

        // Clona la query di base per gli appartamenti non sponsorizzati
        $apartmentsBase = (clone $baseQuery)
            ->whereDoesntHave('sponsors')
            ->get();

        // Esempio di output
        return response()->json([
            'success' => true,
            'results' => [
                'sponsored' => $apartmentsSponsored,
                'base' => $apartmentsBase
            ]
        ]);
    }

    public function store(Request $request)
    {
        $item = Apartment::create($request->all());
        return response()->json([
            'success' => true,
            'results' => $item
        ], 201);
    }

    public function show($id)
    {
        $apartment = Apartment::with('images', 'services')->findOrFail($id);
        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Apartment::findOrFail($id);
        $item->update($request->all());
        return response()->json([
            'success' => true,
            'results' => $item
        ], 200);
    }

    public function destroy($id)
    {
        Apartment::destroy($id);
        return response()->json(null, 204);
    }
}