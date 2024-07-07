<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Models\Apartment;
use App\Models\Sponsor;
use Braintree\Gateway;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function create(Apartment $apartment)
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsor.create', compact('apartment', 'sponsors'));
    }

    public function store(StoreSponsorshipRequest $request, Apartment $apartment)
    {
        $sponsor = Sponsor::findOrFail($request->sponsor_id);

        // Inizializzazione del gateway Braintree
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        // Creazione della transazione
        $result = $gateway->transaction()->sale([
            'amount' => $sponsor->price,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        if ($result->success) {
            // Calcolo della data di fine sponsorizzazione
            $endDate = now()->addHours($sponsor->duration);

            // Associazione della sponsorizzazione all'appartamento
            $apartment->sponsors()->attach($sponsor->id, [
                'start_date' => now(),
                'end_date' => $endDate,
                'price' => $sponsor->price,
                'name' => $sponsor->name,
            ]);

            return redirect()->route('admin.apartments.index')->with('success', 'Sponsorizzazione aggiunta con successo.');
        } else {
            return back()->withErrors('Errore nella transazione: ' . $result->message);
        }
    }
}