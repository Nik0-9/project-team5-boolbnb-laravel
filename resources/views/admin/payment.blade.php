@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pagamento per la sponsorizzazione</h1>
    
    <form id="payment-form" action="{{ route('admin.braintree.checkout') }}" method="POST">
        @csrf
        
        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
        <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
        
        <div class="form-group">
            <label>Appartamento: </label>
            <p>{{ $apartment->name }}</p>
        </div>
        
        <div class="form-group">
            <label>Sponsorizzazione: </label>
            <p>{{ $sponsor->name }} - €{{ $sponsor->price }} per {{ $sponsor->duration }} ore</p>
        </div>
        
        <div id="dropin-container"></div>
        <input type="hidden" name="payment_method_nonce" value="">
        
        <button type="submit" class="btn btn-admin">Paga</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://js.braintreegateway.com/web/dropin/1.33.0/js/dropin.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // console.log("Script caricato correttamente.");
        var form = document.querySelector('#payment-form');

        fetch('{{ route('admin.braintree.token') }}')
            .then(response => response.json())
            .then(data => {
                // console.log('Token fetched:', data);
                var client_token = data.token;
                
                braintree.dropin.create({
                    authorization: client_token,
                    container: '#dropin-container'

                }, function (createErr, instance) {
                    if (createErr) {
                        console.log('Create Error', createErr);
                        return;
                    }
                    console.log('Dropin instance created');
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();

                        instance.requestPaymentMethod(function (err, payload) {
                            if (err) {
                                console.log('Request Payment Method Error', err);
                                return;
                            }
                            // console.log('Nonce received:', payload.nonce);
                            document.querySelector('input[name="payment_method_nonce"]').value = payload.nonce;
                            form.submit();
                        });
                    });
                });
            })
            .catch(error => console.error('Error fetching client token:', error));
    });
</script>
@endsection