@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if($activeSponsor)
    <div class="d-flex align-items-center justify-content-between mt-3">
        <div>
            <p class="text-success mt-2">Appartamento sponsorizzato con {{ $activeSponsor->name }} fino al
                {{ \Carbon\Carbon::parse($activeSponsor->pivot->end_date)->format('d/m/Y H:i') }}
            </p>
            <p id="remaining-time"></p>

        </div>
        <a href="{{ route('admin.sponsor.create', $apartment->slug) }}" class="btn btn-admin w-25 mt-3 mb-4">Sponsorizza</a>
    </div>

@else
    <div class="d-flex align-items-center justify-content-between mt-3">
        <p class="mt-2 text-success">Sponsorizza ora la tua struttura e godi di una maggiore visibilità </p>
        <a href="{{ route('admin.sponsor.create', $apartment->slug) }}" class="btn btn-admin w-25 mb-4">Sponsorizza</a>
    </div>
@endif

<h1>{{ $apartment->name }}</h1>


<div class="row">
    <!-- Immagine Grande -->
    <div class="col-12 col-md-8 mb-4">
        <img class="img-fluid w-50" src="{{ asset('storage/' . $apartment->cover_image)}}" alt="{{ $apartment->name }}">
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0">
            <bold class="d-inline p-3">{{ $messagesCount }} Nuovi messaggi <i class="fa-solid fa-message"></i></bold>
            
            <a href="{{ route('admin.apartments.messages', $apartment->slug) }}" class="btn btn-admin">Visualizza
                Messaggi</a>
        </div>
    </div>
</div>
<div class="row ">
    <!-- Form per il caricamento delle immagini -->
    <div class="col-12 col-md-6 mb-4">
        <form action="{{ route('admin.apartments.uploadImages', $apartment->id) }}" method="POST"
            enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="form-group mb-3">
                <label for="images">Carica Immagini</label>
                <input type="file" name="images[]" id="images" multiple class="form-control w-75" required>
            </div>

            <button type="submit" class="btn btn-admin" id="submitButton">Carica Immagini</button>
        </form>
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
        <div class="d-flex flex-column">
            <a href="{{ route('admin.apartments.edit', $apartment->slug) }}"
                class="btn btn-admin w-25 mb-4 ">Modifica</a>
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-admin w-25 mb-4">Torna alla Lista</a>
        </div>
    </div>

    <!-- Contenitore per le miniature -->
    <div class="col-12 col-md-6 mb-4 d-flex justify-content-end">
        <div class="d-flex flex-column align-items-end w-50">
            @foreach($apartment->images as $image)
                <div class="col mb-2 position-relative">
                    <img src="{{ asset('storage/' . $image->image) }}" class=" w-100"
                        alt="{{ $apartment->name }}">
                    <form action="{{ route('admin.apartments.deleteImage', $image->id) }}" method="POST"
                        class="position-absolute top-0 end-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Sei sicuro di voler eliminare questa immagine di {{ $apartment->name }}?');">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@if($activeSponsor)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const uploadForm = document.getElementById('uploadForm');
        const submitButton = document.getElementById('submitButton');
        const imagesInput = document.getElementById('images');

        uploadForm.addEventListener('submit', function (event) {
            if (imagesInput.files.length === 0) {
                event.preventDefault(); // Prevent form submission
                alert('Seleziona almeno un\'immagine da caricare.');
            }
        });

    });


</script>
<style scope>
    .list-group-item-action a {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .img-fixed {
        width: 100%;
        /* Imposta la larghezza al 100% del contenitore */
        height: 150px;
        /* Imposta l'altezza fissa, puoi cambiare il valore a tua discrezione */
        object-fit: cover;
        /* Mantiene il rapporto di aspetto delle immagini, coprendo l'intero contenitore */
        object-position: center;
        /* Centra l'immagine nel contenitore */
    }
</style>