<?php
namespace App\Http\Controllers\Admin;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', auth()->user()->id)->get();
        return view('admin.apartments.index', compact('apartments'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.apartments.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Apartment::generateSlug($validated['name']);
        $validated['user_id'] = Auth::id();
        $fullAddress = trim($validated['street'] . ' ' . $validated['street_number'] . ' ' . $validated['city'] . ' ' . $validated['cap']);
        $validated['address'] = $fullAddress;
        $client = new Client([
            'verify' => false,
        ]);
        $baseUrlApi = "https://api.tomtom.com/search/2/geocode/";
        $formatted = Apartment::addressFormatted($validated['address']);
        $response = $client->get($baseUrlApi . $formatted . '.json', [
            'query' => [
                'key' => env('TOMTOM_KEY'),
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        if (isset($data['results'][0]['position'])) {
            $validated['latitude'] = $data['results'][0]['position']['lat'];
            $validated['longitude'] = $data['results'][0]['position']['lon'];
        } else {
            return back()->withErrors(['address' => 'Indirizzo non valido inserire via, civico e città']);
        }
        $newApartment = Apartment::create($validated);
        return redirect()->route('admin.apartments.show', $newApartment->slug)->with('success', 'Appartamento creato con successo.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validated = $request->validated();
        //$validated['user_id'] = Auth::id();
        if ($apartment->name !== $validated['name']) {
            $validated['slug'] = Apartment::generateSlug($validated['name']);
        }
        $fullAddress = trim($validated['street'] . ' ' . $validated['street_number'] . ' ' . $validated['city'] . ' ' . $validated['cap']);
        $validated['address'] = $fullAddress;
        $client = new Client([
            'verify' => false,
        ]);
        $baseUrlApi = "https://api.tomtom.com/search/2/geocode/";
        $formatted = Apartment::addressFormatted($validated['address']);
        $response = $client->get($baseUrlApi . $formatted . '.json', [
            'query' => [
                'typeahead' => true,
                'key' => env('TOMTOM_KEY'),
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        if (isset($data['results'][0]['position'])) {
            $validated['latitude'] = $data['results'][0]['position']['lat'];
            $validated['longitude'] = $data['results'][0]['position']['lon'];
        } else {
            return back()->withErrors(['address' => 'Indirizzo non valido inserire via, civico e città']);
        }
        $apartment->update($validated);
        return redirect()->route('admin.apartments.show', $apartment->slug)->with('success', 'Appartamento aggiornato con successo.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('success', 'Appartamento eliminato con successo.');
    }
}