@extends('layouts.app')

@section('content') 
<div class="card m-4 border-0">
        <h1 class="d-inline">Dettagli Appartamento</h1>
        <div class="d-flex justify-content-end" >
        <a href="{{route('admin.apartments.edit', $apartment->slug)}}" class="btn btn-success ">Edit</a>
        </div>
        <p><strong>Nome:</strong> {{ $apartment->name }}</p> 
        <img class="w-50 m-auto pb-3" src="{{ $apartment->cover_image }}" alt="{{ $apartment->name }}">
        <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
        <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
        <p><strong>Latitudine:</strong> {{ $apartment->latitude }}</p>
        <p><strong>Longitudine:</strong> {{ $apartment->longitude }}</p>
        <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary mx-2">Torna alla Lista</a>
    </div>
@endsection