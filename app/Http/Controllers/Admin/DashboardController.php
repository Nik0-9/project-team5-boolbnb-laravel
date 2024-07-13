<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('user_id', auth()->user()->id)
        ->whereHas('messages')
            ->withCount('messages')
            ->get();

        $totalMessages = Message::whereHas('apartment', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->count();
        return view('admin.dashboard', compact('apartments', 'totalMessages'));
    }

}
