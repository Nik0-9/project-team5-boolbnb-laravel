<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Sponsor;
use App\Models\Apartment;
use App\Http\Requests\StoreSponsorRequest;
use App\Http\Requests\UpdateSponsorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SponsorController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::id();
        $apartments = Apartment::where('user_id', $user_id)->get();
        return view('admin.sponsors.index', compact('apartments'));
    }

    public function create(Apartment $apartment)
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsors.create', compact('apartment', 'sponsors'));
    }

    public function store(StoreSponsorRequest $request, Apartment $apartment)
    {
        $validated = $request->validated();

        $sponsor = Sponsor::findOrFail($validated['sponsor_id']);
        $endDate = now()->addHours($sponsor->duration);
        $apartment->sponsors()->attach($sponsor->id, [
            'start_date' => now(), // Data di inizio sponsorizzazione
            'end_date' => $endDate, // Data di fine sponsorizzazione
            'price' => $sponsor->price, // Prezzo della sponsorizzazione
            'name' => $sponsor->name,
        ]);   
        $existingSponsor = $apartment->sponsors()->where('sponsor_id', $sponsor->id)->first();
        if ($existingSponsor) {
            $endDate = $existingSponsor->pivot->end_date->addHours($sponsor->duration);
        } else {
            $endDate = now()->addHours($sponsor->duration);
        }
        return redirect()->route('admin.payment.page', ['apartment' => $apartment->slug, 'sponsor' => $sponsor->id]);
    }

    public function show(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::id()) {
            abort(404, 'Pagina non trovata');
        }
        
        $apartment = Apartment::with(['images', 'sponsors' => function($query) {
            $query->wherePivot('end_date', '>', now());
        }])->findOrFail($apartment->id);
        
        return view('admin.apartments.show', compact('apartment'));
    }

    public function edit(Sponsor $sponsor)
    {
        //
    }

    public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
    {
        //
    }

    public function destroy(Sponsor $sponsor)
    {
        //
    }
}