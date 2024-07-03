<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\ApartmentSponsor;
use App\Models\Sponsor;


class ApartmentSponsorController extends Controller
{
    public function index(Request $request)
    {
        $query = ApartmentSponsor::all();
        $apartments = Apartment::where('user_id', auth()->user()->id)->get();
        $sponsors = Sponsor::all();
        if ($request->has('sponsor_id')){
            $query->where('apartment_id', 'sponsor_id');
        }
        $apartmentSponsor = $query->get();

        return view('admin.apartment_sponsors.index', compact('apartments', 'sponsors','apartmentSponsor'));
    }
}
