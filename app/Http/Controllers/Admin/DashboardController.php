<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

class DashboardController extends Controller
{
    public function index(){
        $apartments = Apartment::where('user_id', auth()->user()->id)
        ->withCount('messages')
            ->get();
        return view('admin.dashboard', compact('apartments'));
    }
}
