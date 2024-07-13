<?php

namespace App\Http\Controllers\Admin;

use App\Models\View;
use App\Http\Requests\StoreViewRequest;
use App\Http\Requests\UpdateViewRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;



class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreViewRequest $request, $id)
    {
        try {
            // Salva la visualizzazione dell'appartamento
            View::create([
                'apartment_id' => $id,
                'view' => now(), // Utilizza la colonna 'view' per il timestamp della visualizzazione
                'ip_address' => $request->ip(), // Aggiungi anche l'indirizzo IP se necessario
            ]);

            return response()->json(['message' => 'Visualizzazione tracciata con successo']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Errore durante il tracciamento della visualizzazione'], 500);
        }
    }

    public function getViewsByApartment($id)
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $views = View::where('apartment_id', $id)
            ->where('view', 'like', "$currentMonth%")
            ->orderBy('view', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->view)->format('Y-m-d');
            });

        $viewsData = [];
        foreach ($views as $date => $viewGroup) {
            $viewsData[$date] = $viewGroup->count();
        }

        return response()->json(['views' => $viewsData]);
    }
    /**
     * Display the specified resource.
     */
    public function show(View $view)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(View $view)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViewRequest $request, View $view)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(View $view)
    {
        //
    }
}