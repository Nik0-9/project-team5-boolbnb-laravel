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
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartments = Apartment::where('user_id', auth()->user()->id)->get();
        
        return view('admin.apartments.index', compact('apartments'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();

        return view('admin.apartments.create', compact('services'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        
        
        $validated = $request->validated();
        $validated['slug'] = Apartment::generateSlug($validated['name']);
        $validated['user_id'] = Auth::id();

        if($request->hasFile('cover_image')){
            $name = $validated['slug'];
            $img_path = Storage::putFileAs('apartment_image', $request->cover_image, $name.'.jpg'); 
            $validated['cover_image'] = $img_path;
        }else{
            $validated['cover_image'] = 'default.jpg';
        }
        
         $searchedAddress=$validated['address'] ;

        $client = new Client([
            'verify' => false,
        ]);
        //chiamata API
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
        if($request->has('services')){
            $newApartment->services()->attach($request->input('services'));
        }
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

        if($apartment->user_id !== Auth::id()){
            abort(404, 'Pagina non trovata');
        }  

        $services = Service::all();
        return view('admin.apartments.edit', compact('apartment', 'services'));
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
        }else{
            $validated['slug'] = $apartment->slug;
        }

        if($request->hasFile('cover_image')){
            if($apartment->cover_image && $apartment->cover_image !== 'default.jpg'){
                Storage::delete($apartment->cover_image);
            }
            $name = $validated['slug'];
            $img_path = Storage::putFileAs('apartment_image', $request->cover_image, $name.'.jpg'); 
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
        if($request->has('services')){
            $apartment->services()->sync($request->services);
        }else{
            $apartment->services()->sync([]);
        }
        $apartment->update($validated);
        return redirect()->route('admin.apartments.show', $apartment->slug)->with('success', 'Appartamento aggiornato con successo.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        if($apartment->user_id !== Auth::id()){
            abort(404, 'Pagina non trovata');
        }
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('success', 'Appartamento eliminato con successo.');
    }

}