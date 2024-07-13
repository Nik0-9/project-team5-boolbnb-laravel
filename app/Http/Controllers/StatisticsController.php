<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Recupera gli appartamenti dell'utente con le relative visualizzazioni
        $apartments = Apartment::where('user_id', $user->id)->with('views')->get();

        return view('admin.statistics', compact('apartments'));
    }
}