@extends('layouts.app')

@section('content')
<h1>Modifica Appartamento</h1>
<div class="mb-3 fs-5"> I campi sono obbligatori *</div>

<form action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" id="modForm"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- NOME -->
        <div class="col-12 col-lg-6">
            <div class="form-group mb-3">
                <label for="name">Nome appartamento *</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $apartment->name) }}" required maxlength="200" minlength="10">
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- INDIRIZZO -->
        <div class="col-12 col-lg-6">
            <div class="form-group mb-3">
                <label for="address">Indirizzo *</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="{{ old('address', isset($apartment) ? $apartment->address : '') }}" required maxlength="200"
                    minlength="10" list="addressSuggestions">
                <datalist id="addressSuggestions"></datalist>
                <div id="addressError" class="alert alert-danger d-none">Per favore seleziona un indirizzo valido dalla lista dei suggerimenti.</div>
            </div>
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- IMMAGINE -->
    <div class="form-group mb-3">
        <label for="cover_image">Immagine di Copertina</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
    </div>
    @error('cover_image')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- DESCRIZIONE -->
    <div class="form-group mb-3">
        <label for="description">Descrizione</label>
        <textarea class="form-control" id="description" name="description" rows="3"
            minlength="20">{{ old('description', $apartment->description) }}</textarea>
    </div>
    @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="row">
        <div class="col-12 col-lg-6">
            <!-- METRI QUADRI -->
            <div class="form-group mb-3">
                <label for="square_meters">Metri Quadrati *</label>
                <input type="number" class="form-control" id="square_meters" name="square_meters"
                    value="{{ old('square_meters', $apartment->square_meters) }}" required min="20">
            </div>
            @error('square_meters')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- NUMERO STANZE -->
        <div class="col-12 col-lg-6">

            <div class="form-group mb-3">
                <label for="num_rooms">Numero di Stanze *</label>
                <input type="number" class="form-control" id="num_rooms" name="num_rooms"
                    value="{{ old('num_rooms', $apartment->num_rooms) }}" required min="1">
            </div>
            @error('num_rooms')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- NUMERO BAGNI -->
        <div class="col-12 col-lg-6">
            <div class="form-group mb-3">
                <label for="num_bathrooms">Numero di Bagni *</label>
                <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms"
                    value="{{ old('num_bathrooms', $apartment->num_bathrooms) }}" required min="1">
            </div>
            @error('num_bathrooms')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- NUMERO LETTI -->
        <div class="col-12 col-lg-6">

            <div class="form-group mb-3">
                <label for="num_beds">Numero di Letti *</label>
                <input type="number" class="form-control" id="num_beds" name="num_beds"
                    value="{{ old('num_beds', $apartment->num_beds) }}" required min="1">
            </div>
            @error('num_beds')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <!-- SERVIZI -->
    <div class="row">
        <div class="form-group mb-3">
            <label for="services">Servizi *</label>
            <div class="mb-3 fw-light"> scegli almeno un servizio</div>

            @error('services')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @foreach ($services as $service)
                <div>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input" {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                    <label for="services[]" class="form-check-label">{{ $service->name }}</label>
                </div>
            @endforeach
        </div>
    <!-- VISIBILIA' -->
        <div class="form-group col-6-col-md-12">
            <label for="visible">L'appartamento è ancora visibile?</label>
            <div class="form-check form-check-inline mb-5 ">
                <input class="form-check-input" type="radio" name="visible" id="visible_yes" value="1" {{ old('visible', $apartment->visible) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="visible_yes">Sì</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visible" id="visible_no" value="0" {{ old('visible', $apartment->visible) == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="visible_no">No</label>
            </div>
        </div>
    </div>

</form>
<div class="position-fixed bottom-0 end-0 p-5" style="z-index: 10;">
    <button type="submit" form="modForm" class="btn btn-admin btn-lg">Aggiorna</button>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('modForm');
        const inputs = document.querySelectorAll('#num_bathrooms, #num_beds, #num_rooms');
        const squareMeters = document.getElementById('square_meters');
        squareMeters.addEventListener('input', function () {
            if (squareMeters.value < 20) {
                squareMeters.classList.add('is-invalid');
            } else {
                squareMeters.classList.remove('is-invalid');
            }
        })


        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (input.value < 1) {
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        });

        form.addEventListener('submit', function (event) {
            let allValid = true;
            inputs.forEach(input => {
                if (input.value < 1) {
                    allValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!allValid) {
                event.preventDefault();
                alert('Per favore, inserisci valori validi per tutti i campi.');
            }
        });
    });

</script>
@endsection