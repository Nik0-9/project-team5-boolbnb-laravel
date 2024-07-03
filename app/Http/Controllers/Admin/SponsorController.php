<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sponsor;
use App\Http\Requests\StoreSponsorRequest;
use App\Http\Requests\UpdateSponsorRequest;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentSponsor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::id())
        ->whereHas('sponsors', function ($query) {
            $query->where('end_date', '>', Carbon::now());
        })
        ->with(['sponsors' => function ($query) {
            $query->where('end_date', '>', Carbon::now());
        }])
        ->get();


        return view('admin.sponsors.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sponsors.create', compact('sponsor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSponsorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
    {
        return redirect()->route('admin.sponsors.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        //
    }
}
