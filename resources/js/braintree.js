document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');

    fetch('/braintree/token')
        .then(response => response.json())
        .then(data => {
            var client_token = data.clientToken;
            
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
        })
        .catch(error => console.error('Error fetching client token:', error));
});