@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mb-4">Dettaglio Messaggio</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Messaggio ricevuto il {{ $message->created_at_formatted }}</h5>
                <div class="mb-3">
                    <strong>Nome:</strong> {{ $message->name }}
                </div>
                <div class="mb-3">
                    <strong>Cognome:</strong> {{ $message->surname }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ $message->email }}
                </div>
                <div class="mb-3">
                    <strong>Testo del messaggio:</strong><br>
                    {{ $message->body }}
                </div>
            </div>
        </div>

        <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-chevron-left me-2"></i>Torna Indietro</a>
    </div>
@endsection
