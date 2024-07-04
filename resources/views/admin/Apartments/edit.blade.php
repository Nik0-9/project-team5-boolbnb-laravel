@extends('layouts.app')

@section('content')
<h1>Modifica Appartamento</h1>
<div class="mb-3 fw-light"> I campi sono obbligatori *</div>

<form action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- NOME -->
    <div class="form-group mb-3">
        <label for="name">Nome descrittivo appartamento *</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $apartment->name) }}" required maxlength="200" minlength="10">
    </div>
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- IMMAGINE -->
    <div class="form-group mb-3">
        <label for="cover_image">Immagine di Copertina</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
    </div>
    @error('cover_image')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- INDIRIZZO -->
    <div class="form-group mb-3">
        <label for="address">Indirizzo *</label>
        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"

            value="{{ old('address', isset($apartment) ? $apartment->address : '') }}" required maxlength="200"
            minlength="10" autocomplete="off">
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <select class="form-select" id="resultsSelect" class="">
        </select>
    </div>

    <input type="hidden" name="latitude" value="{{ old('latitude') }}">
    <input type="hidden" name="longitude" value="{{ old('longitude') }}">

    <!-- DESCRIZIONE -->
    <div class="form-group mb-3">
        <label for="description">Descrizione</label>
        <textarea class="form-control" id="description" name="description" rows="3" minlength="20">{{ old('description', $apartment->description) }}</textarea>
    </div>
    @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- METRI QUADRI -->
    <div class="form-group mb-3">
        <label for="square_meters">Metri Quadrati *</label>
        <input type="number" class="form-control" id="square_meters" name="square_meters"
            value="{{ old('square_meters', $apartment->square_meters) }}" required minlength="20">
    </div>
    @error('square_meters')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- NUMERO BAGNI -->
    <div class="form-group mb-3">
        <label for="num_bathrooms">Numero di Bagni *</label>
        <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms"
            value="{{ old('num_bathrooms', $apartment->num_bathrooms) }}" required minlength="1">
    </div>
    @error('num_bathrooms')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- NUMERO LETTI -->
    <div class="form-group mb-3">
        <label for="num_beds">Numero di Letti *</label>
        <input type="number" class="form-control" id="num_beds" name="num_beds"
            value="{{ old('num_beds', $apartment->num_beds) }}" required minlength="1">
    </div>
    @error('num_beds')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- NUMERO STANZE -->
    <div class="form-group mb-3">
        <label for="num_rooms">Numero di Stanze *</label>
        <input type="number" class="form-control" id="num_rooms" name="num_rooms"
            value="{{ old('num_rooms', $apartment->num_rooms) }}" required minlength="1">
    </div>
    @error('num_rooms')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- SERVIZI -->
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

    <!-- SPONSOR -->
    <div class="form-group mb-3">
        <label for="sponsors">Sponsor</label>
        @error('sponsors')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <select class="form-control" id="sponsors" name="sponsors[]" multiple>
            @foreach($sponsors as $sponsor)
                <option value="{{ $sponsor->id }}" {{ in_array($sponsor->id, $apartment->sponsors->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $sponsor->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="d-none">
        <input type="number" id="user" name="user_id" value="{{ old('user_id', $apartment->user_id) }}">
    </div>

    <button type="submit" class="btn btn-primary mb-4">Aggiorna</button>
</form>
@endsection