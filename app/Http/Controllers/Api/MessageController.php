<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Mail\NewContact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        // validazione
        $validator = Validator::make($data, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'body' => 'required',
            'apartment_id' => 'nullable|exists:apartments,id',
        ], [
            'name.required' => "Devi inserire il tuo nome",
            'surname.required' => "Devi inserire il tuo cognome",
            'email.required' => "Devi inserire la tua mail",
            'email.email' => "La mail inserita deve essere una vera mail, quindi contenere '@' e '.com' (o simili)",
            'body.required' => "Devi inserire un messaggio",
        ]);

        // controllo delle validazioni
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error of Validation',
                'errors' => $validator->errors(),
            ], 404);
        }

        // salvo il messaggio nel db
        $newMessage = new Message();
        $newMessage->fill($request->all());
        //controllo l'id dell'appartamento
        if ($request->has('apartment_id')) {
            $newMessage->apartment_id = $request->input('apartment_id');
        }
        $newMessage->save();

        // invio la mail
        Mail::to('boolbnb@gmail.com')->send(new NewContact($newMessage));

        return response()->json([
            'status'=>'success',
            'message'=>'ok',
        ], 200);

    }

    public function index()
    {
        $messages = Message::all();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }
}
