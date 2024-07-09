@extends('layouts.app')

@section('content')
<div class="card m-4 border-0">
    <h1 class="d-inline">Dettagli Appartamento</h1>
    <p><strong>{{ $apartment->name }}</strong></p>

    <div class="row">
        <!-- Immagine Grande -->
        <div class="col-12 col-md-8">
            <img class="img-fluid w-100" src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{ $apartment->name }}">
        </div>

        <!-- Contenitore per le miniature -->
        <div class="col-12 col-md-4">
            <div class="d-flex flex-column">
                @foreach($apartment->images as $image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" alt="Immagine">
                    </div>
                @endforeach
            </div>
        </div>
        
        <form action="{{ route('admin.apartments.uploadImages', $apartment->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="form-group mb-3 w-50">
            <label for="images">Carica Immagini</label>
            <input type="file" name="images[]" id="images" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Carica Immagini</button>
    </form>
    </div>
    <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
    <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
    @if ($apartment->visible == 1)
    <p><strong>Visibile:</strong> Si</p>
    @else
    <p><strong>Visibile:</strong> No</p>
    @endif
    
    @if($apartment->services)
    <p><strong>Servizi:</strong></p>
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
    <h2>Messaggi</h2>
    @if($apartment->messages->isEmpty())
        <p>Nessun messaggio.</p>
    @else
        <ul>
            @foreach($apartment->messages as $message)
                <li>
                    <strong>{{ $message->name }} {{ $message->surname }}</strong><br>
                    <strong>Email:</strong> {{ $message->email }}<br>
                    <strong>Messaggio:</strong> {{ $message->body }}<br>
                    <small>Inviato il: {{ $message->created_at }}</small>
                </li>
            @endforeach
        </ul>
    @endif

    @if($activeSponsor)
        <p class="text-success">Appartamento sponsorizzato con {{ $activeSponsor->name }} fino al {{ \Carbon\Carbon::parse($activeSponsor->pivot->end_date)->format('d/m/Y H:i') }}</p>
        <p id="remaining-time"></p>
    @else
        <p>Nessuna sponsorizzazione attiva</p>
    @endif

    <a href="{{ route('admin.sponsor.create', $apartment->slug) }}" class="btn btn-primary w-25 mb-4">Sponsorizza</a>
    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary w-25 mb-4">Torna alla Lista</a>
</div>
@endsection

@section('scripts')
@if($activeSponsor)
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            function updateRemainingTime() {
                const endTime = new Date("{{ \Carbon\Carbon::parse($activeSponsor->pivot->end_date)->format('Y-m-d H:i:s') }}").getTime();
                const now = new Date().getTime();
                const distance = endTime - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('remaining-time').innerHTML = `Tempo rimanente: ${days} giorni ${hours} ore ${minutes} minuti ${seconds} secondi`;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById('remaining-time').innerHTML = "Sponsorizzazione scaduta";
                }
            }

            updateRemainingTime();
            const x = setInterval(updateRemainingTime, 1000);
        });
    </script>
@endif
@endsection