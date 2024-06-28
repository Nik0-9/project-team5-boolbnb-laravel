@extends('layouts.app')

@section('content')
    <h1>Dettagli Appartamento</h1>
    <p><strong>Nome:</strong> {{ $apartment->name }}</p>
    <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
    <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary">Torna alla Lista</a>
@endsection