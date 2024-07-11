<?php

namespace App\Http\Controllers\Admin;

use App\Models\View;
use App\Models\Apartment; // Assicurati di importare il modello Apartment, se non già presente
use App\Http\Requests\StoreViewRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class ViewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreViewRequest $request)
{
    try {
        // Logica di salvataggio dei dati

        return response()->json(['message' => 'Visualizzazione registrata con successo']);
    } catch (QueryException $e) {
        // Gestione degli errori nel salvataggio dei dati nel database
        return response()->json(['message' => 'Errore nel salvataggio dei dati'], 500);
    } catch (\Exception $e) {
        // Gestione generica di altre eccezioni
        return response()->json(['message' => 'Errore interno del server'], 500);
    }
}
public function index()
    {
        // Data di inizio e fine del mese corrente
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Recupera le visualizzazioni per il mese corrente
        $views = View::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                     ->get();

        // Calcola il numero totale di visualizzazioni nel mese corrente
        $totalViews = $views->count();

        // Recupera gli appartamenti con il conteggio delle visualizzazioni nel mese corrente
        $apartments = Apartment::withCount(['views' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }])->get();

        // Passa i dati alla vista
        return view('statistics.index', [
            'totalViews' => $totalViews,
            'apartments' => $apartments
        ]);
    }
}