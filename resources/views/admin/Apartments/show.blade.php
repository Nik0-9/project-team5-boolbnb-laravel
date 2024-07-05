@extends('layouts.app')

@section('content') 
<div class="card m-4 border-0">
    <h1 class="d-inline">Dettagli Appartamento</h1>
    <div class="d-flex justify-content-end">
        <a href="{{route('admin.apartments.edit', $apartment->slug)}}" class="btn btn-success ">Modifica</a>
    </div>
    <p><strong>Nome:</strong> {{ $apartment->name }}</p>
    <img class="w-50" src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{ $apartment->name }}">
    <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
    <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
    <p><strong>Nome Immagine:</strong> {{ $apartment->cover_image }}</p>

    <p><strong>Latitudine:</strong> {{ $apartment->latitude }}</p>
    <p><strong>Longitudine:</strong> {{ $apartment->longitude }}</p>
    @if($apartment->services)
        <div class="d-flex">
            @foreach($apartment->services as $service)
                <div class="d-flex flex-column mx-2">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="service-show" src="{{ asset($service->icon) }}" alt="{{ $service->name }}">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="text-center">{{ $service->name }}</p>
                    </div>
                </div>

            @endforeach
        </div>
    @endif
    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary w-25 mb-4">Torna alla Lista</a>
</div>
@endsection