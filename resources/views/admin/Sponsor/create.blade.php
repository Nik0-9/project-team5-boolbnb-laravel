@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsorizza il tuo appartamento</h1>
    
    <form action="{{ route('sponsor.store', $apartment->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="sponsor_id">Scegli un pacchetto di sponsorizzazione</label>
            <select name="sponsor_id" id="sponsor_id" class="form-control">
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}">{{ $sponsor->name }} - €{{ $sponsor->price }} per {{ $sponsor->duration }} ore</option>
                @endforeach
            </select>
        </div>

        <div id="dropin-container"></div>
        
        <input type="hidden" name="payment_method_nonce" id="payment_method_nonce">
        
        <button type="submit" class="btn btn-primary">Sponsorizza</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://js.braintreegateway.com/web/dropin/1.33.0/js/dropin.min.js"></script>
<script>
    var form = document.querySelector('form');
    var client_token = "{{ Braintree\ClientToken::generate() }}";

    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container'
    }, function (createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                }
                document.querySelector('#payment_method_nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>
@endsection