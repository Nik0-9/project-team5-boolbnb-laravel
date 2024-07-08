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
    public function search(string $address, string $latitude, string $longitude, ?int $serviceId = null)
{
    // Convert latitude and longitude from degrees to radians
    $lat = deg2rad($latitude);
    $lon = deg2rad($longitude);

    // Radius in km (20 km)
    $radius = 20;

    $baseQuery = Apartment::select('apartments.*')
        ->whereRaw("6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))) <= $radius");

    // Modify baseQuery based on whether serviceId is provided
    if ($serviceId !== null) {
        $apartmentsSponsored = (clone $baseQuery)
            ->whereHas('sponsors')
            ->whereHas('services', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->get();

        $apartmentsBase = (clone $baseQuery)
            ->whereDoesntHave('sponsors')
            ->whereHas('services', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->get();
    } else {
        $apartmentsSponsored = (clone $baseQuery)
            ->whereHas('sponsors')
            ->get();

        $apartmentsBase = (clone $baseQuery)
            ->whereDoesntHave('sponsors')
            ->get();
    }

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