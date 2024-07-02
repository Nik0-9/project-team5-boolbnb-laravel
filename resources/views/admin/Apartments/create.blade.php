@extends('layouts.app')

@section('content')
<h1>Crea Nuovo Appartamento</h1>
<form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- NOME -->
    <div class="form-group mb-3">
        <label for="name">Nome descrittivo appartamento</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', isset($apartment) ? $apartment->name : '') }}" required maxlength="200"
            minlength="10">
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
        <label for="address">Indirizzo</label>
        <input type="text" class="form-control" id="address" name="address"
            value="{{ old('address', isset($apartment) ? $apartment->address : '') }}" required maxlength="200"
            minlength="10">
    </div>
    @error('address')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <!-- DESCRIZIONE -->
    <div class="form-group mb-3">
        <label for="description">Descrizione</label>
        <textarea class="form-control" id="description" name="description" rows="5" minlength="20">
        {{ old('description', isset($apartment) ? $apartment->description : '') }} 
    </textarea>
    </div>
    @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <!-- METRI QUADRI -->
    <div class="form-group mb-3">
        <label for="square_meters">Metri Quadrati</label>
        <input type="number" class="form-control" id="square_meters" name="square_meters"
            value="{{ old('square_meters', isset($apartment) ? $apartment->square_meters : '') }}" required
            minlength="20">
    </div>
    @error('square_meters')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <!-- NUMERO BAGNI -->
    <div class="form-group mb-3">
        <label for="num_bathrooms">Numero di Bagni</label>
        <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms"
            value="{{ old('num_bathrooms', isset($apartment) ? $apartment->num_bathrooms : '') }}" required
            minlength="1">
    </div>
    @error('num_bathrooms')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <!-- NUMERO LETTI -->
    <div class="form-group mb-3">
        <label for="num_beds">Numero di Letti</label>
        <input type="number" class="form-control" id="num_beds" name="num_beds"
            value="{{ old('num_beds', isset($apartment) ? $apartment->num_beds : '') }}" required minlength="1">
    </div>
    @error('num_beds')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <!-- NUMERO STANZE -->
    <div class="form-group mb-3">
        <label for="num_rooms">Numero di Stanze</label>
        <input type="number" class="form-control" id="num_rooms" name="num_rooms"
            value="{{ old('num_rooms', isset($apartment) ? $apartment->num_rooms : '') }}" required minlength="1">
    </div>
    @error('num_rooms')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="d-none">
        <input type="number" id="user" name="user_id" value="{{old('user_id', $apartment->user_id ?? '')}}">
    </div>
    <!-- SERVIZI -->
    <div class="form-group mb-3">
        <label for="services">Servizi</label>
        @error('services')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @foreach ($services as $service)
            <div>
                <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                <label for="services[]" class="form-check-label">{{ $service->name }}</label>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary mb-4" id="save">Salva</button>
</form>
@endsection