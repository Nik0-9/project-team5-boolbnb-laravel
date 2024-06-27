<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
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
        $apartment = Apartment::create($validated);

        return redirect()->route('apartments.show', $apartment->id)->with('success', 'Appartamento creato con successo.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        return view('apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validated = $request->validated();
        if ($apartment->name !== $validated['name']) {
            $validated['slug'] = Apartment::generateSlug($validated['name']);
        }
        $apartment->update($validated);

        return redirect()->route('apartments.show', $apartment->id)->with('success', 'Appartamento aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartments.index')->with('success', 'Appartamento eliminato con successo.');
    }
}
