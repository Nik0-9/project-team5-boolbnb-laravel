@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="my-4">
            <h1 class="h3 mb-0 text-gray-800 fs-1">Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12  col-xl-6">
                @auth
                    <h2>{{ __('Benvenuto, :name!', ['name' => Auth::user()->name]) }}</h2>
                @endauth
                <select name="apartment" id="message_apartment" class="form-control mb-2 mb-md-2 w-25 w-md-auto">
                    <option value="">Seleziona appartamento</option>
                    @foreach ($apartments as $apartment)
                        <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                    @endforeach
                </select>
                <h3>Le tue strutture</h3>
            </div>
            <div class="col-12 col-xl-6">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    #map {
        min-width: 250px;
        min-height: 250px;
    }
</style>

@section('scripts')
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps-web.min.js"></script>
<script>
    // Array di appartamenti con le loro coordinate
    var apartments = @json($apartments);
    console.log(apartments);

    // Inizializza la mappa TomTom con coordinate di default
    var map = tt.map({
        key: '88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI',
        container: 'map',
        center: [12.4964, 41.9028], // Centra la mappa su Roma
        zoom: 5 // Imposta un livello di zoom appropriato per vedere i marker
    });

    // Array per memorizzare le coordinate di tutti i marker
    var bounds = new tt.LngLatBounds();

    // Aggiungi marker per ciascun appartamento
    apartments.forEach(function (apartment) {
        // Verifica se le coordinate esistono e sono valide
        var latitude = parseFloat(apartment.latitude);
        var longitude = parseFloat(apartment.longitude);

        //console.log(`Appartamento: ${apartment.name}, Latitudine: ${latitude}, Longitudine: ${longitude}`);

        if (!isNaN(latitude) && !isNaN(longitude)) {
            var marker = new tt.Marker().setLngLat([longitude, latitude]).addTo(map);

            // Aggiungi le coordinate del marker ai confini della mappa
            bounds.extend([longitude, latitude]);
        } else {
            console.error("Coordinate mancanti o non valide per l'appartamento: ", apartment);
        }
    });

    // Adatta la mappa ai confini dei marker
    if (apartments.length > 0) {
        map.fitBounds(bounds, { padding: 20 });
    }
</script>
@endsection