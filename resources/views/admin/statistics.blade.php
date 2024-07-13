@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Statistiche degli Appartamenti</h1>

        @foreach($apartments as $apartment)
            <div class="card mb-3">
                <div class="card-header">
                    <h2>{{ $apartment->name }}</h2>
                </div>
                <div class="card-body">
                    <p>Numero di visualizzazioni: {{ $apartment->views->count() }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection