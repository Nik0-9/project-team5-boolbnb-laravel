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
        // Assicurati che la relazione sia definita correttamente nel modello Apartment
        $sponsoredApartments = Apartment::whereHas('sponsors')->with('sponsors')->get();
        
        return response()->json($sponsoredApartments);
    }

    public function store(Request $request)
    {
        $item = Apartment::create($request->all());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        return Apartment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = Apartment::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Apartment::destroy($id);
        return response()->json(null, 204);
    }
}


