@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsorizza il tuo appartamento</h1>

    <form action="{{ route('admin.sponsor.store', $apartment->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="sponsor">Seleziona un pacchetto promozionale</label>
            <select name="sponsor_id" id="sponsor" class="form-control" required>
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}">{{ $sponsor->name }} - {{ $sponsor->price }} € per {{ $sponsor->duration }} ore</option>
                @endforeach
            </select>
        </div>
        <div id="dropin-container"></div>
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
                document.querySelector('input[name="payment_method_nonce"]').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>
@endsection