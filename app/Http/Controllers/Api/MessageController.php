<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Apartment;

class MessageController extends Controller
{
    public function sendMessage(Request $request, Apartment $apartment)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'body' => 'required|string',
        ]);
        $message = new Message();
        $message->name = $validatedData['name'];
        $message->surname = $validatedData['surname'];
        $message->email = $validatedData['email'];
        $message->body = $validatedData['body'];
        $message->apartment_id = $apartment->id; // Collega il messaggio all'appartamento
        $message->save();
        return response()->json(['message' => 'Messaggio inviato con successo'], 201);
    }
}
