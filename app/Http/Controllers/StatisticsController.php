<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Recupera gli appartamenti dell'utente
        $apartments = Apartment::where('user_id', $user->id)->get();

        // Inizializza i dati per i grafici
        $currentMonth = Carbon::now()->format('Y-m');
        $dailyViews = [];
        $totalViewsPerApartment = [];

        foreach ($apartments as $apartment) {
            $views = $apartment->views()
                ->where('view', 'like', "$currentMonth%")
                ->orderBy('view', 'asc')
                ->get();

            $totalViewsPerApartment[$apartment->id] = $views->count();

            foreach ($views as $view) {
                $date = Carbon::parse($view->view)->format('Y-m-d');
                if (!isset($dailyViews[$date])) {
                    $dailyViews[$date] = [];
                }
                if (!isset($dailyViews[$date][$apartment->id])) {
                    $dailyViews[$date][$apartment->id] = 0;
                }
                $dailyViews[$date][$apartment->id]++;
            }
        }

        return view('admin.statistics', compact('apartments', 'dailyViews', 'totalViewsPerApartment', 'currentMonth'));
    }
    
}
