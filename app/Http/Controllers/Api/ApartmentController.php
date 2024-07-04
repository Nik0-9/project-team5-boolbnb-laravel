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
    public function search($address, $lat, $lon)
    {
        // Converti lat e lon da gradi a radianti
        $lat = deg2rad($lat);
        $lon = deg2rad($lon);

        // Raggio in km (20 km)
        $radius = 20;

        // Raggio in metri (20 km convertito in metri)
        $radiusMeters = $radius * 1000;

        // Query per trovare gli appartamenti entro il raggio specificato
        $apartments = Apartment::select('*')
            ->whereRaw("6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lon) - radians($lon)) + sin(radians($lat)) * sin(radians(lat))) <= $radius")
            ->get();

        // Esempio di output
        return response()->json(['apartments' => $apartments]);
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