@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrati') }}</div>

                <div class="card-body">
                    <form id="register-form" method="POST" action="{{ route('register') }}"
                        onsubmit="validateEmail(event)">
                        @csrf

                        <div class="mb-4 row">
                            <div class="mb-3">I campi con * sono obbligatori</div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo mail') }} *</label>
                                <div class="col-md-6">
                                    <input type="email" id="email" name="email" class="form-control"
                                        pattern="^[a-z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$" required>
                                    <div id="emailError" class="text-danger d-none" role="alert">
                                        <strong>Indirizzo email non valido: <br>esempio@email.com</strong>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    *</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}
                                    *</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                    <span id="password-match-error" class="invalid-feedback" role="alert"
                                        style="display: none;">
                                        <strong>Le password non corrispondono.</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" pattern="[a-zA-Z\s]+" title="Solo lettere sono ammesse"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" pattern="[a-zA-Z\s]+"
                                        title="Solo lettere sono ammesse"
                                        class="form-control @error('surname') is-invalid @enderror" name="surname"
                                        value="{{ old('surname') }}" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }}</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}">

                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<script>
    function validateEmail(event) {
        event.preventDefault(); // Previene l'invio del modulo

        const emailInput = document.getElementById('email');
        const emailValue = emailInput.value;
        const emailPattern = /^[a-z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
        const emailError = document.getElementById("emailError");

        if (!emailPattern.test(emailValue)) {
            emailInput.classList.remove('error');
            emailError.classList.remove('d-none');
        } else {
            emailInput.classList.remove('error');
            // Se l'email è valida, puoi inviare il modulo
            document.getElementById('register-form').submit();
        }
    }
</script>