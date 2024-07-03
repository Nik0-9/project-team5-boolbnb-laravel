<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class ApartmentSponsorController extends Controller
{
    public function index(Request $request)
    {
        // Ottieni tutte le associazioni tra appartamenti e sponsor
        $query = Apartment::with('sponsors')->get();
        
        $apartments = Apartment::all();
        $sponsors = Sponsor::all();

        return view('admin.apartment_sponsors.index', compact('query', 'apartments', 'sponsors'));
    }
}
