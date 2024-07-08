<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sponsor;
use App\Models\Apartment;
use App\Http\Requests\StoreSponsorRequest;
use App\Http\Requests\UpdateSponsorRequest;
use App\Http\Controllers\Controller;
use Braintree\Gateway as BraintreeGateway;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->middleware('auth');

        $gatewayConfig = config('services.braintree');
        Log::info('Braintree Config:', $gatewayConfig);

        $this->gateway = new BraintreeGateway([
            'environment' => $gatewayConfig['environment'],
            'merchantId' => $gatewayConfig['merchant_id'],
            'publicKey' => $gatewayConfig['public_key'],
            'privateKey' => $gatewayConfig['private_key'],
        ]);

        Log::info('Braintree Gateway:', [
            'environment' => $gatewayConfig['environment'],
            'merchantId' => $gatewayConfig['merchant_id'],
            'publicKey' => $gatewayConfig['public_key'],
            'privateKey' => $gatewayConfig['private_key']
        ]);
    }

    public function index()
    {
        //
    }

    public function create(Apartment $apartment)
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsor.create', compact('apartment', 'sponsors'));
    }

    public function store(StoreSponsorRequest $request, Apartment $apartment)
    {
        $validated = $request->validated();

        $sponsor = Sponsor::findOrFail($validated['sponsor_id']);
        $endDate = now()->addHours($sponsor->duration);

        $nonce = $validated['payment_method_nonce'];
        $result = $this->gateway->transaction()->sale([
            'amount' => $sponsor->price,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $apartment->sponsors()->attach($sponsor->id, [
                'start_date' => now(),
                'end_date' => $endDate,
                'price' => $sponsor->price,
                'name' => $sponsor->name,
            ]);

            return redirect()->route('admin.apartments.show', $apartment->slug)
                             ->with('success', 'Sponsorizzazione aggiunta con successo');
        } else {
            return back()->withErrors('Errore nella transazione: ' . $result->message);
        }
    }

    public function show(Sponsor $sponsor)
    {
        //
    }

    public function edit(Sponsor $sponsor)
    {
        //
    }

    public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
    {
        //
    }

    public function destroy(Sponsor $sponsor)
    {
        //
    }
}