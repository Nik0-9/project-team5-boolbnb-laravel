<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Braintree\Gateway;
use App\Models\Apartment;
use App\Models\Sponsor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);
    }

    public function token()
    {
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function checkout(Request $request)
    {
        // Log iniziale
        Log::info('Inizio processo di checkout');
        $nonce = $request->input('payment_method_nonce');
        Log::info('Nonce ricevuto: ' . $nonce);

        $apartment = Apartment::findOrFail($request->input('apartment_id'));
        Log::info('Appartamento trovato: ' . $apartment->id);

        $sponsor = Sponsor::findOrFail($request->input('sponsor_id'));
        Log::info('Sponsor trovato: ' . $sponsor->id);

        $amount = $sponsor->price;
        Log::info('Prezzo della sponsorizzazione: ' . $amount);

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        Log::info('Risultato della transazione: ', (array)$result);

        if ($result->success) {
            $currentDateTime = Carbon::now();
            // Convertiamo la durata (di tipo TIME) in ore, minuti e secondi
            list($hours, $minutes, $seconds) = explode(':', $sponsor->duration);
            // Aggiungiamo la durata alla data e ora corrente
            $endDateTime = $currentDateTime->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);
            Log::info('Current DateTime: ' . $currentDateTime);
            Log::info('End DateTime: ' . $endDateTime);

            $existingSponsor = $apartment->sponsors()
                ->where('sponsor_id', $sponsor->id)
                ->where('end_date', '>', $currentDateTime)
                ->first();

            if ($existingSponsor) {
                Log::info('Sponsor esistente trovato, estendendo la durata');
                $existingSponsor->pivot->end_date = Carbon::parse($existingSponsor->pivot->end_date)->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);
                $existingSponsor->pivot->save();
            } else {
                Log::info('Nessuno sponsor esistente trovato, aggiungendo nuovo sponsor');
                $apartment->sponsors()->attach($sponsor->id, [
                    'start_date' => $currentDateTime,
                    'end_date' => $endDateTime,
                    'price' => $sponsor->price,
                    'name' => $sponsor->name,
                ]);
            }

            Log::info('Pagamento avvenuto con successo');
            return redirect()->route('admin.apartments.show', $apartment->slug)
                             ->with('success', 'Pagamento avvenuto con successo');
        } else {
            Log::error('Errore nella transazione: ' . $result->message);
            return redirect()->route('admin.apartments.show', $apartment->slug)
                             ->withErrors('Errore nella transazione: ' . $result->message);
        }
    }

    public function index(Request $request)
    {
        $apartment = Apartment::findOrFail($request->input('apartment_id'));
        $sponsor = Sponsor::findOrFail($request->input('sponsor_id'));

        return view('admin.payment', compact('apartment', 'sponsor'));
    }
}