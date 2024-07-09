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
        $nonce = $request->input('payment_method_nonce');

        $apartment = Apartment::findOrFail($request->input('apartment_id'));

        $sponsor = Sponsor::findOrFail($request->input('sponsor_id'));

        $amount = $sponsor->price;

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $currentDateTime = Carbon::now();
            //Conversione sponsor.duration in ore:minuti:secondi
            list($hours, $minutes, $seconds) = explode(':', $sponsor->duration);
            // Aggiungiamo la durata alla data e ora corrente
            $endDateTime = $currentDateTime->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);

            $existingSponsor = $apartment->sponsors()
                ->where('sponsor_id', $sponsor->id)
                ->where('end_date', '>', $currentDateTime)
                ->first();
            //Se lo sponsor esiste, aggiorniamo l'end_date, altrimenti lo aggiungiamo
            if ($existingSponsor) {
                $existingSponsor->pivot->end_date = Carbon::parse($existingSponsor->pivot->end_date)->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);
                $existingSponsor->pivot->save();
            } else {
                //Se lo sponsor non esiste, lo aggiungiamo
                $apartment->sponsors()->attach($sponsor->id, [
                    'start_date' => $currentDateTime,
                    'end_date' => $endDateTime,
                    'price' => $sponsor->price,
                    'name' => $sponsor->name,
                ]);
            }
            return redirect()->route('admin.apartments.show', $apartment->slug)
                             ->with('success', 'Pagamento avvenuto con successo');
        } else {
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