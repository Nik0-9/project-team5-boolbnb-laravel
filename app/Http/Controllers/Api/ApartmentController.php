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
    public function getBaseApartments()
    {
        $sponsoredApartments = Apartment::whereDoesntHave('sponsors')->get();

        return response()->json([
            'success' => true,
            'results' => $sponsoredApartments
        ]);
    }

    public function search(Request $request)
{
    $latitude = $request->latitude;
    $longitude = $request->longitude;
    $serviceIds = $request->serviceId;

    $radius = 20;

    $baseQuery = Apartment::selectRaw("apartments.*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
        ->having('distance', '<=', $radius);

    if ($serviceIds) {
        $baseQuery->whereHas('services', function ($query) use ($serviceIds) {
            $query->whereIn('service_id', $serviceIds);
        });
    }

    $apartmentsSponsored = (clone $baseQuery)
        ->whereHas('sponsors')
        ->get();
    
    $apartmentsBase = (clone $baseQuery)
        ->whereDoesntHave('sponsors')
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

    public function show($slug)
    {
        $apartment = Apartment::with('images', 'services')->where('slug', $slug)->first();
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
