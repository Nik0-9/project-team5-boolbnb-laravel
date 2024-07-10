@extends('layouts.app')

@section('content') 
<div class="card m-4 border-0">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="d-inline">Dettagli Appartamento</h1>
        <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="btn btn-warning ">Modifica</a>
    </div>
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
    <h3 class="mt-2">Richiesta di contatto</h3>
    @if($apartment->messages->isEmpty())
        <p>Nessun messaggio.</p>
    @else
    <div class="list-group">
        @foreach ($apartment->messages as $message)
        <div class="list-group-item list-group-item-action my-3">
        <a href=" {{ route('admin.messages.show', $message->id) }}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $message->apartment->name }}</h5>
                    <small>{{ $message->created_at }}</small>
                </div>
                <p>{{ $message->body }}</p>
                <p class="mb-1"><small><strong>Nome utente: </strong>{{ $message->name }} {{$message->surname}}</small></p>
                <div class="d-flex w-100 justify-content-between">
                <small><strong>Email: </strong> {{ $message->email }}</small>
                <!-- Form di eliminazione -->
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger p-1 delete-button">
                     Cancella messaggio
                    </button>
                </form>
                </div>
        </a>
            </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary w-25 mb-4">Torna alla Lista</a>
</div>
@endsection
<style scope>
.list-group-item-action a {
        text-decoration: none; 
        color: inherit;
        cursor: pointer;
      
    }
</style>