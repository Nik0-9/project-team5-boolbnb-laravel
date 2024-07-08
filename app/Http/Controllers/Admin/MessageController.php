<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Models\Apartment;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

    // Recupera gli appartamenti dell'utente autenticato che hanno almeno un messaggio associato
    $apartments = Apartment::whereHas('messages', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->get();

    // Seleziona l'appartamento specificato nella richiesta (se presente)
    $apartment_id = $request->input('apartment_id');

    // Recupera i messaggi associati agli appartamenti dell'utente autenticato
    $messages = Message::whereHas('apartment', function ($query) use ($user, $apartment_id) {
        $query->where('user_id', $user->id);
        if ($apartment_id) {
            $query->where('id', $apartment_id);
        }
    })->orderBy('created_at', 'desc')->with('apartment')->get();

    return view('admin.messages.index', [
        'messages' => $messages,
        'apartments' => $apartments,
        'selected_apartment_id' => $apartment_id,
    ]);
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
    public function store(StoreMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        $user = Auth::user();

        // Verifica che l'appartamento associato al messaggio appartenga all'utente autenticato
        if ($message->apartment->user_id !== $user->id) {
            abort(404); // Accesso negato
        }

        // Recupera gli appartamenti dell'utente autenticato
        $apartments = Apartment::where('user_id', $user->id)->get();

        // Recupera i messaggi associati agli appartamenti dell'utente autenticato
        $messages = Message::where('apartment_id', $message->apartment_id)->get();

        return view('admin.messages.show', compact('message', 'apartments', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message, Apartment $apartment)
    {
        if ($message->apartment->user_id !== Auth::id()) {
            abort(404, 'Pagina non trovata');
        }
    
        $message->delete();
    
        return redirect()->route('admin.messages.index')->with('success', 'Messaggio eliminato con successo.');
    }
}