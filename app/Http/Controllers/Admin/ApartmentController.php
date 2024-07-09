<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartments = Apartment::where('user_id', auth()->user()->id)->with('images', 'messages')->get();

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $sponsors = Sponsor::all();

        return view('admin.apartments.create', compact('services', 'sponsors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Apartment::generateSlug($validated['name']);
        $validated['user_id'] = Auth::id();

        Log::info('Current Timezone: ' . config('app.timezone'));
        Log::info('Current DateTime: ' . now());
    

        if ($request->hasFile('cover_image')) {
            $name = $validated['slug'];
            $img_path = Storage::putFileAs('apartment_image', $request->cover_image, $name . '.jpg');
            $validated['cover_image'] = $img_path;
        } else {
            $validated['cover_image'] = 'default.jpg';
        }

        $searchedAddress = $validated['address'];
        $client = new Client([
            'verify' => false,
        ]);
        // chiamata API
        $baseUrlApi = "https://api.tomtom.com/search/2/geocode/";

        $response = $client->get($baseUrlApi . $searchedAddress . '.json', [
            'query' => [
                'limit' => 1,
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

        if ($request->has('services')) {
            $newApartment->services()->attach($request->input('services'));
        }

        if ($request->has('sponsors')) {
            foreach ($request->input('sponsors') as $sponsorId) {
                $sponsor = Sponsor::find($sponsorId);
                if ($sponsor) {
                    // Calcola la data di fine basata sulla durata
                    $endDate = now()->addHours($sponsor->duration);

                    // Attacca lo sponsor con i dettagli
                    $newApartment->sponsors()->attach($sponsorId, [
                        'start_date' => now(),
                        'end_date' => $endDate,
                        'price' => $sponsor->price,
                        'name' => $sponsor->name,
                    ]);
                }
            }
        }

        return redirect()->route('admin.apartments.show', $newApartment->slug)->with('success', 'Appartamento creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        if($apartment->user_id !== Auth::id()){
            abort(404, 'Pagina non trovata');
        }

        $apartment = Apartment::with('images', 'sponsors')->findOrFail($apartment->id);
        $activeSponsor = $apartment->sponsors()->wherePivot('end_date', '>', now())->orderBy('price', 'desc')->first();

        return view('admin.apartments.show', compact('apartment', 'activeSponsor'));
    }
    public function uploadImages(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $apartment = Apartment::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $file = Storage::putFileAs('apartment_image/details', $file, $apartment->slug . '-' . $file->getClientOriginalName());

                Image::create([
                    'apartment_id' => $apartment->id,
                    'image' => $file,
                ]);
            }
        }
    
        return redirect()->route('admin.apartments.show', $apartment->slug)
            ->with('success', 'Immagini caricate con successo.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::id()) {
            abort(404, 'Pagina non trovata');
        }

        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.apartments.edit', compact('apartment', 'services', 'sponsors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment, Sponsor $sponsor)
    {
        $validated = $request->validated();
        if ($apartment->name !== $validated['name']) {
            $validated['slug'] = Apartment::generateSlug($validated['name']);
        } else {
            $validated['slug'] = $apartment->slug;
        }

        if ($request->hasFile('cover_image')) {
            if ($apartment->cover_image && $apartment->cover_image !== 'default.jpg') {
                Storage::delete($apartment->cover_image);
            }
            $name = $validated['slug'];
            $img_path = Storage::putFileAs('apartment_image', $request->cover_image, $name . '.jpg');
            $validated['cover_image'] = $img_path;
        }

        $searchedAddress = $validated['address'];
        $client = new Client([
            'verify' => false,
        ]);
        $baseUrlApi = "https://api.tomtom.com/search/2/geocode/";
        $response = $client->get($baseUrlApi . $searchedAddress . '.json', [
            'query' => [
                'limit' => 1,
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

        $apartment->visible = $validated['visible'];

        $apartment->update($validated);

        if ($request->has('services')) {
            $apartment->services()->sync($request->services);
        } else {
            $apartment->services()->sync([]);
        }

        if ($request->has('sponsors')) {
            $apartment->sponsors()->sync([]);
            foreach ($request->input('sponsors') as $sponsorId) {
                $apartment->sponsors()->attach($sponsorId, [
                    'start_date' => now(),
                    'end_date' => now()->addHours($sponsor->duration),
                    'price' => $sponsor->price,
                    'name' => $sponsor->name,
                ]);
            }
        } else {
            $apartment->sponsors()->sync([]);
        }

        return redirect()->route('admin.apartments.show', $apartment->slug)->with('success', 'Appartamento aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::id()) {
            abort(404, 'Pagina non trovata');
        }
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('success', 'Appartamento eliminato con successo.');
    }
}